<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            \App\Repositories\Admin\Index\IndexRepositoryContract::class,
            \App\Repositories\Admin\Index\IndexRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\Menu\MenuRepositoryContract::class,
            \App\Repositories\Admin\Menu\MenuRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\Role\RoleRepositoryContract::class,
            \App\Repositories\Admin\Role\RoleRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\Account\AccountRepositoryContract::class,
            \App\Repositories\Admin\Account\AccountRepository::class
        );

        $this->app->bind(
            \App\Repositories\Admin\Category\CategoryRepositoryContract::class,
            \App\Repositories\Admin\Category\CategoryRepository::class
        );

         $this->app->bind(
             \App\Repositories\Admin\Product\ProductRepositoryContract::class,
             \App\Repositories\Admin\Product\ProductRepository::class
         );

        $this->app->bind(
            \App\Repositories\Admin\Banner\BannerRepositoryContract::class,
            \App\Repositories\Admin\Banner\BannerRepository::class
        );


        $this->app->bind(
            \App\Repositories\Api\Index\IndexRepositoryContract::class,
            \App\Repositories\Api\Index\IndexRepository::class
        );

    }
}
