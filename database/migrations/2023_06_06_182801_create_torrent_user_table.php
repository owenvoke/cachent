<?php

declare(strict_types=1);

use App\Models\Torrent;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('torrent_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Torrent::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('torrent_user');
    }
};
