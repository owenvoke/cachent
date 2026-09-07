<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\TorrentFactory;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $hash
 * @property string|null $filename
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
#[Unguarded]
class Torrent extends Model
{
    /** @use HasFactory<TorrentFactory> */
    use HasFactory;

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
