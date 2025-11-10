_
<?php

use App\Models\Channel;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(Channel::class)->constrained('channels')->onDelete('restrict');
            $table->foreignIdFor(Season::class)->constrained('seasons')->onDelete('restrict');
            $table->string('name');
            $table->string('image');
            $table->string('description');
            $table->string('media_type');
            $table->string('media_source');
            $table->string('link');
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podcasts');
    }
};
