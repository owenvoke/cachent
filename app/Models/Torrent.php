<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $hash
 * @property string|null $filename
 * @property string created_at
 * @property string updated_at
 * @property User $user
 */
class Torrent extends Model
{
    use HasFactory;
}
