<?php

namespace Tests\Unit;

use App\Services\ProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Product;
use PHPUnit\Framework\Attributes\Test;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = new ProductService();
    }

    #[Test]
    public function it_can_get_products_by_category()
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $products = $this->productService->index($category->id);

        $this->assertCount(3, $products);
    }

    #[Test]
    public function it_can_store_a_product()
    {
        $category = Category::factory()->create();
        $data = [
            'title' => 'Test Product',
            'price' => 100.00,
            'description' => 'This is a test product',
            'image' => 'image.jpg',
            'category_id' => $category->id,
        ];

        $product = $this->productService->store($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', ['title' => 'Test Product']);
    }

    #[Test]
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $foundProduct = $this->productService->show($product->id);

        $this->assertEquals($product->id, $foundProduct->id);
    }

    #[Test]
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();
        $newData = ['title' => 'Updated Title'];

        $updatedProduct = $this->productService->update($newData, $product->id);

        $this->assertEquals('Updated Title', $updatedProduct->title);
        $this->assertDatabaseHas('products', ['title' => 'Updated Title']);
    }

    #[Test]
    public function it_can_destroy_a_product()
    {
        $product = Product::factory()->create();

        $this->productService->destroy($product->id);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

}
