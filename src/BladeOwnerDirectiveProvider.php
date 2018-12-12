<?php

namespace SamuelSemegne\LaravelBladeOwnerDirective;

use Gate;
use Blade;
use Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class BladeOwnerDirectiveProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * This directive checks whether every route-binded-model belongs to the current user.
         */
        Blade::if('owner', function() {
            $modelCount = 0;
            foreach (Request::route()->parameters() as $key => $value) {
              if ($value instanceof Model) {
                $modelCount++;
                // Bail on the first denail.
                if (Gate::denies('touch-thing', $value)) {
                    return false;
                }
              }
            }

            // We passed all gates.
            return ($modelCount ? true : false);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
