<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['image', 'video']),
            'url' => $this->faker->imageUrl(),

            'profile_id' => function () {
                return Profile::factory()->create()->id;
            },
            
            'post_id' => function () {
                return Post::factory()->create()->id;
            },
        ];
    }
}
