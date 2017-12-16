<?php

namespace Xu42\KuaiDiNiao;

use Illuminate\Support\ServiceProvider;

class KuaiDiNiaoServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('kdniao.php'),
        ], 'config');
    }


    public function register()
    {
        //
    }

}