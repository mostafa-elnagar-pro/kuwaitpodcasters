<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class FileChunkingService
{
    public static function videoOrAudio(array $data): object
    {
        $totalChunks = (int) $data['total_chunks'];
        $chunkIdx = (int) $data['chunk_index'];
        $uploadId = $data['upload_id'] ?? null;
        $chunkFile = $data['chunk'];
        $ext = $data['media_type']==='video' ? 'mp4' : 'mp3';

        if ($chunkIdx === 1) {
            $uploadId = Str::uuid()->toString();
        }

        $targetChunkPath = storage_path("app/chunks/$uploadId.part_$chunkIdx");

        $chunkFile->move(
            dirname($targetChunkPath),
            basename($targetChunkPath)
        );

        // check if it's still chunking
        if ($chunkIdx < $totalChunks) {
            return (object) [
                'processed' => false,
                'upload_id' => $uploadId,
                'progress' => ceil(($chunkIdx / $totalChunks) * 100),
            ];
        }

        $assembledFile = storage_path("app/chunks/$uploadId.$ext");

        // re-assemble them into a complete file
        $handle = fopen($assembledFile, 'wb');

        for ($i = 1; $i <= $totalChunks; $i++) {
            $fileChunk = storage_path("app/chunks/$uploadId.part_$i");
            $chunkHandle = fopen($fileChunk, 'rb');
            while (!feof($chunkHandle)) {
                fwrite($handle, fread($chunkHandle, 8192));
            }
            fclose($chunkHandle);
        }
        fclose($handle);

        

        // delete the individual chunk files
        // for ($i = 1; $i <= $totalChunks; $i++) {
        //     $fileChunk = storage_path("app/chunks/$uploadId.part_$i");
        //     unlink($fileChunk);
        // }

        return (object) [
            'processed' => true,
            'upload_id' => $uploadId,
            'progress' => 100,
            'new_file' => new UploadedFile($assembledFile, basename($assembledFile))
        ];
    }
}
