<?php

namespace Webfactor\Laravel\Backpack\NestedModels;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class NestedModelsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->macros();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function macros()
    {
        Blueprint::macro('tree', function () {
            $this->unsignedInteger('parent_id')->nullable()->index();
            $this->unsignedInteger('lft')->default(0)->index();
            $this->unsignedInteger('rgt')->default(0)->index();
            $this->unsignedInteger('depth')->default(0);

            $this->foreign('parent_id')->references('id')->on($this->table)
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Router::macro('tree', function($uri, $action) {
            //TODO
        });
    }
}