<?php

namespace Database\Factories;

use App\Models\Torrent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Torrent>
 */
class TorrentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hash' => $this->faker->sha1(),
            'filename' => "{$this->faker->slug()}.{$this->faker->fileExtension()}",
            'user_id' => UserFactory::new(),
        ];
    }
}
