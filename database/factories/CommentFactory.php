<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        return [
            'body' => $this->faker->sentence,

            'profile_id' => function () {
                return Profile::factory()->create()->id;
            },
            
            'post_id' => function () {
                return Post::factory()->create()->id;
            },
        ];
    }
}
