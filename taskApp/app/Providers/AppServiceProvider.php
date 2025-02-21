<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ElasticsearchService;
use Elasticsearch\Client;

use Elastic\Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->singleton(Client::class, function () {
        //     return ClientBuilder::create()
        //         ->setHosts([env('ELASTICSEARCH_HOST', 'elasticsearch:9200')])
        //         ->setBasicAuthentication(env('ELASTICSEARCH_USERNAME'), env('ELASTICSEARCH_PASSWORD'))
        //         ->build();
        // });

        // $this->app->singleton(ElasticsearchService::class, function ($app) {
        //     return new ElasticsearchService($app->make(Client::class));
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
