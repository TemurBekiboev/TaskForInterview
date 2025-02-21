<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $categoryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryService = new CategoryService();
    }

    #[Test]
    public function it_returns_all_categories()
    {

        Category::factory()->count(3)->create();


        $categories = $this->categoryService->index();


        $this->assertCount(3, $categories);
    }

    #[Test]
    public function it_can_store_a_category()
    {

        $data = [
            'title'       => 'Test Category',
            'description' => 'This is a test category.',
            'image'       => 'test.jpg'
        ];


        $category = $this->categoryService->store($data);


        $this->assertDatabaseHas('categories', [
            'id'    => $category->id,
            'title' => 'Test Category',
        ]);
        $this->assertEquals('Test Category', $category->title);
        $this->assertEquals('This is a test category.', $category->description);
    }

    #[Test]
    public function it_can_show_a_category()
    {

        $category = Category::factory()->create();


        $foundCategory = $this->categoryService->show($category->id);


        $this->assertEquals($category->id, $foundCategory->id);
    }

    #[Test]
    public function it_can_update_a_category()
    {

        $category = Category::factory()->create();


        $data = [
            'title'       => 'Updated Category Title',
            'description' => 'Updated description.',
            'image'       => 'updated.jpg'
        ];


        $updatedCategory = $this->categoryService->update($data, $category->id);


        $this->assertEquals('Updated Category Title', $updatedCategory->title);
        $this->assertDatabaseHas('categories', [
            'id'    => $category->id,
            'title' => 'Updated Category Title'
        ]);
    }

    #[Test]
    public function it_can_destroy_a_category()
    {

        $category = Category::factory()->create();


        $result = $this->categoryService->destroy($category->id);


        $this->assertEquals(1, $result);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
