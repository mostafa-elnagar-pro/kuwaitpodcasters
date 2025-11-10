<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;


class FileService
{
    public static function uploadImage(
        UploadedFile $file,
        string $folder,
        string|null $oldFilePath = null,
        string $disk = 'uploads',
        bool $returnJson = false
    ) {
        $fileName = Str::uuid()->toString();

        $relativePath = "$disk/$folder/$fileName.webp";
        $absolutePath = Storage::disk($disk)->path($folder);

        if (!File::isDirectory($absolutePath)) {
            File::makeDirectory($absolutePath, 0777, true, true);
        }

        $image = Image::read($file);

        $width = $image->width(); //min(1000, $image->width());
        $height = $image->height(); // min(800, $image->height());

        $image->contain($width, $height)
            ->encode(new WebpEncoder(80))
            ->save(public_path($relativePath));

        // delete the old if exists    
        if (!is_null($oldFilePath)) {
            self::unlink($oldFilePath, $disk);
        }

        if ($returnJson) {
            return response()->json([
                'fileName' => "$fileName.webp",
                'uploaded' => 1,
                'url' => displayFile($relativePath)
            ]);
        }

        return $relativePath;
    }
    /**end of uploadImage */


    public static function uploadVideoOrAudio(
        UploadedFile $file,
        string $folder,
        string|null $oldFilePath = null,
        string $disk = 'uploads',
        bool $named = true
    ) {
        $fileName = $named ?
            $file->getBasename() :
            Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        $relativePath = "$disk/$folder/$fileName";
        $absolutePath = Storage::disk($disk)->path($folder);

        if (!File::isDirectory($absolutePath)) {
            File::makeDirectory($absolutePath, 0777, true, true);
        }

        File::move($file, public_path($relativePath));

        // delete the old if exists    
        if (!is_null($oldFilePath)) {
            self::unlink($oldFilePath, $disk);
        }

        return $relativePath;
    }
    /**end of uploadVideo */


    public static function unlink(string $oldFilePath, string $disk = "uploads")
    {
        if (File::exists(public_path($oldFilePath))) {
            File::delete(public_path($oldFilePath));
        }

        return true;
    }
    /**end of unlink */


}
