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
        // Create an instance of your service class
        $this->categoryService = new CategoryService();
    }

    #[Test]
    public function it_returns_all_categories()
    {
        // Arrange: Create 3 category records
        Category::factory()->count(3)->create();

        // Act: Get all categories using the service
        $categories = $this->categoryService->index();

        // Assert: We should have exactly 3 categories
        $this->assertCount(3, $categories);
    }

    #[Test]
    public function it_can_store_a_category()
    {
        // Arrange: Prepare sample data
        $data = [
            'title'       => 'Test Category',
            'description' => 'This is a test category.',
            'image'       => 'test.jpg'
        ];

        // Act: Create a new category via the service
        $category = $this->categoryService->store($data);

        // Assert: The category is stored in the database and matches our data
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
        // Arrange: Create a category
        $category = Category::factory()->create();

        // Act: Retrieve the category using the service
        $foundCategory = $this->categoryService->show($category->id);

        // Assert: The returned category matches the one we created
        $this->assertEquals($category->id, $foundCategory->id);
    }

    #[Test]
    public function it_can_update_a_category()
    {
        // Arrange: Create a category record
        $category = Category::factory()->create();

        // Prepare update data
        $data = [
            'title'       => 'Updated Category Title',
            'description' => 'Updated description.',
            'image'       => 'updated.jpg'
        ];

        // Act: Update the category using the service
        $updatedCategory = $this->categoryService->update($data, $category->id);

        // Assert: The category's data has been updated
        $this->assertEquals('Updated Category Title', $updatedCategory->title);
        $this->assertDatabaseHas('categories', [
            'id'    => $category->id,
            'title' => 'Updated Category Title'
        ]);
    }

    #[Test]
    public function it_can_destroy_a_category()
    {
        // Arrange: Create a category record
        $category = Category::factory()->create();

        // Act: Delete the category using the service
        $result = $this->categoryService->destroy($category->id);

        // Assert: Check that destroy returns 1 (number of deleted records)
        $this->assertEquals(1, $result);
        // And the category is no longer in the database
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
