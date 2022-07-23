<?php

namespace Tests\Feature;

use App\Models\Category;
use \App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /**
     * This entire unit is to test Categories Api action tests.
     * Status Codes and DB data are validated here
     */

    use RefreshDatabase;

    public function test_if_index_route_returns_categories()
    {
        $categories = Category::factory(10)->create();
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $this->assertEquals($categories->count(), count($response['data']));
    }

    public function test_if_we_can_store_a_category()
    {
        $category_title = fake()->word;
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'category_title' => $category_title,
            'slug' => fake()->slug
        ];
        $this->post(route('categories.store'), $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('categories', ['category_title' => $category_title]);
    }

    public function test_if_we_can_show_specific_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', $category));
        $response->assertStatus(200);
        $this->assertEquals($category->category_title, json_decode($response->getContent())->data->category_title);
    }

    public function test_if_we_can_update_category()
    {
        $title = 'Edited Category Title';
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create(
            ['user_id' => $user->id]
        );
        $data = ['category_title' => $title];
        $response = $this->patch(route('categories.update', $category->id), $data);
        $response->assertStatus(200);

        $category = Category::find(1);
        $this->assertEquals($title, $category->category_title);
    }

    public function test_if_we_can_delete_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $response = $this->delete(route('categories.destroy', $category->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', ['id' => $category->id, 'deleted_at' => null]);
    }
}
