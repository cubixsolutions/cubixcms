<?php  namespace App\Providers; 

use View;
use Illuminate\Support\ServiceProvider;
use App\Setting;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     * @param Setting $setting
     */
    public function boot( Setting $setting)
    {

        $setting = $setting->all();

        View::composer('*', function($view) use($setting) {

           foreach($setting as $row) {

               $view->with('title',$row->company);
               $view->with('slogan',$row->slogan);

           }

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        //

    }

}