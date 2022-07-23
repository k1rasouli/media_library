<?php

namespace Database\Factories;

use App\libs\Music;
use App\Models\Category;
use App\Models\Media;
use App\Models\User;
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
    public function definition()
    {
        static $order = 1;
        $media_type = random_int(0, 2);
        $extentions = [];
        switch ($media_type)
        {
            case 0:
                $extentions = ['mp3'];
                break;
            case 1:
                $extentions = ['mp4', 'm4v'];
                break;
            case 2:
                $extentions = ['zip', 'tar.gz'];
                break;
        }

        shuffle($extentions);
        $category = Category::factory()->create();
        return [
            'media_type' => $media_type,
            'media_title' => fake()->text(50),
            'media_order' => $order++,
            'media_size' => fake()->randomDigit(),
            'extension' => $extentions[0],
            'file_name' => fake()->word . '.' . $extentions[0],
            'category_id' => $category->id,
            'user_id' => $category->user_id
        ];
    }
}
