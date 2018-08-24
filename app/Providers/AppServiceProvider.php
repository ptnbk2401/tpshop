<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Model\Cat;
use App\Model\Product;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $objCat = new Cat();
        $objProduct = new Product();
        $objItemsCat  = $objCat->getItems();
        $objItemsRandCat  = $objCat->getRandItems();
        $objNewItems = $objProduct->getNewItems();
        View::share('objItemsCat', $objItemsCat);
        View::share('objNewItems', $objNewItems);
        View::share('objItemsRandCat', $objItemsRandCat);
        View::share('urlAdmin', getenv('URL_TEMPLATE_ADMIN'));
        View::share('urlTpshop', getenv('URL_TEMPLATE_TPSHOP'));
        View::composer('*', function($view){
            $view->with([
                'objUser' => Auth::user(), 
            ]);
        });

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
