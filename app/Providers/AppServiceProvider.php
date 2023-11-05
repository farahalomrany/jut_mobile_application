<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
use App\FormFields\SizePricesFormField;
use App\FormFields\RelatedProductsFormField;
use App\FormFields\PointsFormField;
use App\FormFields\DistributorFormField;
use App\FormFields\GiftsFormField;
use App\FormFields\DestinationsFormField;
use App\FormFields\Destinations1FormField;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Voyager::addFormField(SizePricesFormField::class);

        Voyager::addFormField(RelatedProductsFormField::class);

        Voyager::addFormField(PointsFormField::class);

        Voyager::addFormField(DistributorFormField::class);

        Voyager::addFormField(GiftsFormField::class);

        Voyager::addFormField(DestinationsFormField::class);
        
        Voyager::addFormField(Destinations1FormField::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        Voyager::addAction(\App\Actions\Products::class);
        Voyager::addAction(\App\Actions\Distributor::class);
        Voyager::addAction(\App\Actions\Gifts::class);
        Voyager::addAction(\App\Actions\Message_answer::class);
        Voyager::addAction(\App\Actions\Message_ignore::class);

        Relation::morphMap([
            'member' => 'App\Models\Member',
            'observer' => 'App\Models\Observer',
            'admin' => 'App\Models\Admin',
            'distributor' => 'App\Models\Distributor',
            
        ]);

        
    }
}
