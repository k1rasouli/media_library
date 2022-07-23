<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MediaTest extends TestCase
{
    /**
     * This entire unit is to test Media Api action tests.
     * Status Codes and DB data are validated here
     */

    use RefreshDatabase;

    public function test_if_index_route_returns_media_list()
    {
        $media_list = Media::factory(10)->create();
        $response = $this->get(route('media.index'));
        $response->assertStatus(200);
        $this->assertEquals($media_list->count(), count($response['data']));
    }

    public function test_if_we_can_store_a_media()
    {
        $title = fake()->word;
        $category = Category::factory()->create();
        $this->actingAs(User::find($category->user_id));

        $media_type = 0;
        $extensions = ['mp3'];
        $file_name = fake()->word . '.' . $extensions[0];

        $media_file = UploadedFile::fake()->create($file_name);

        $data = [
            'media_type' => $media_type,
            'media_title' => $title,
            'media_order' => 1,
            'media_size' => fake()->randomDigit(),
            'extension' => $extensions[0],
            'file_name' => $file_name,
            'category_id' => $category->id,
            'user_id' => $category->user_id,
            'media_file' => $media_file
        ];

        $this->post(route('media.store'), $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('media', ['media_title' => $title]);
    }

    public function test_if_we_can_show_specific_media()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $media = Media::factory()->create();
        $response = $this->get(route('media.show', $media));
        $response->assertStatus(200);

        $this->assertEquals($media->media_title, json_decode($response->getContent())->data->title);
    }

    public function test_if_we_can_update_media()
    {
        $title = 'Edited Media Title';
        $user = User::factory()->create();
        $this->actingAs($user);
        $media = Media::factory()->create(
            ['user_id' => $user->id]
        );
        $data = [
            'media_title' => $title,
            'media_type' => $media->media_type,
            'category_id' => $media->category_id,
        ];
        $response = $this->patch(route('media.update', ['medium' => $media]), $data);
        $response->assertStatus(200);

        $media = Media::find(1);
        $this->assertEquals($title, $media->media_title);
    }

    public function test_if_we_can_delete_media()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $media = Media::factory()->create();
        $response = $this->delete(route('media.destroy', $media->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('media', ['id' => $media->id, 'deleted_at' => null]);
    }
}
