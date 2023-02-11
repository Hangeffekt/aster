<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Metatags;
use App\Models\Carts;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $metaTags = Metatags::get();

        foreach($metaTags as $metaTag){
            $analytics = $metaTag->analytics;
            $keywords = $metaTag->keywords;
            $description = $metaTag->description;
        }

        $catalog = DB::table('catalogs')
            ->where("status", 1)
            ->get();

        //cart items

        $count_products = Carts::get();

    View::share(["analytics"=>$analytics, "keywords"=>$keywords, "description"=>$description, "catalogs"=>$catalog, "CountProducts"=>$count_products]);
    }
}
