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
        // LOAD THE VIEWS
        $this->loadViewsFrom(resource_path('views/vendor/webfactor/nestedmodels'), 'nestedmodels');
        $this->loadViewsFrom(realpath(__DIR__.'/../views'), 'nestedmodels');

        $this->macros();

        $this->publish();

        // AUTO PUBLISH
        if (\App::environment('local')) {
            if ($this->shouldAutoPublishPublic()) {
                \Artisan::call('vendor:publish', [
                    '--provider' => 'Backpack\CRUD\CrudServiceProvider',
                    '--tag' => 'public',
                ]);
            }
        }
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

    public function publish()
    {
        $this->publishes([__DIR__.'/../views' => resource_path('views/vendor/webfactor/nestedmodels')], 'views');

        $this->publishes([__DIR__.'/../public' => public_path('vendor/webfactor/nestedmodels')], 'public');
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
    }

    /**
     * Checks to see if we should automatically publish
     * vendor files from the public tag.
     *
     * @return bool
     */
    private function shouldAutoPublishPublic()
    {
        $crudPubPath = public_path('vendor/webfactor/nestedmodels');

        if (! is_dir($crudPubPath)) {
            return true;
        }

        return false;
    }
}
