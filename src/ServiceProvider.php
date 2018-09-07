<?php

namespace Axn\ViewComponents;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
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
        $this->app->afterResolving('blade.compiler', function(BladeCompiler $blade) {

            $blade->directive('render', function($expression) {
                return "<?php echo render($expression); ?>";
            });
        });
    }
}
