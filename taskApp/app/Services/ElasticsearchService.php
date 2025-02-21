<?php
namespace App\Services;

use Elasticsearch\Client;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->setBasicAuthentication(env('ELASTICSEARCH_USERNAME'), env('ELASTICSEARCH_PASSWORD'))->build(); 
        // $this->client = $client;
        $this->checkAndCreateIndex();
    }

    private function checkAndCreateIndex()
    {
        $indexParams = ['index' => 'products'];

        if (!$this->client->indices()->exists($indexParams)) {
            $this->client->indices()->create([
                'index' => 'products',
                'body' => [
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 1,
                    ],
                    'mappings' => [
                        'properties' => [
                            'title' => ['type' => 'text'],
                            'description' => ['type' => 'text'],
                            'price' => ['type' => 'float'],
                            'category_id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ]);
        }
    }

    public function indexProduct($product)
    {
        $params = [
            'index' => 'products', 
            'id' => $product->id,   
            'body' => [
                'title' => $product->title,
                'price' => $product->price,
                'description' => $product->description,
                'category_id' => $product->category_id,
            ]
        ];

        return $this->client->index($params);
    }

    public function searchProducts($query)
    {
        
        try {
            $params = [
                'index' => 'products',
                'body' => [
                    'query' => [
                        'match' => ['title' => $query]
                    ]
                ]
            ];
    
            $response = $this->client->search($params)->asArray();
    
            \Log::info('Elasticsearch Response:', $response);
    
            return $response;
        } catch (\Exception $e) {
            \Log::error("Elasticsearch search failed: " . $e->getMessage());
            return ['error' => 'Search failed'];
        }
    }
    public function deleteProduct($id)
{
    $params = [
        'index' => 'products',  
        'id' => $id,             
    ];

    return $this->client->delete($params);
}
}
