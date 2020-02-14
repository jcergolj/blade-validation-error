<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('validation', function ($id) {
            return '<?php
                $__errorArgs = ['.$id.'];
                $__bag = $errors->getBag($__errorArgs[1] ?? \'default\');
                if ($__bag->has($__errorArgs[0])) :
                    if (isset($message)) {
                        $__messageOriginal = $message;
                    }
                    $message = $__bag->first($__errorArgs[0]);
            ?>
                <span class="error">{{ $message }}</span>
            <?php
                unset($message);
                if (isset($__messageOriginal)) {
                    $message = $__messageOriginal;
                }
                
                endif;
                unset($__errorArgs, $__bag);
            ?>';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
