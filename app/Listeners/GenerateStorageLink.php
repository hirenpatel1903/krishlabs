<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 29/4/20
 * Time: 8:47 PM
 */

namespace App\Listeners;


use App\Libraries\MyUpdate;
use RachidLaasri\LaravelInstaller\Events\LaravelInstallerFinished;

class GenerateStorageLink
{

    public function handle( LaravelInstallerFinished $event )
    {
        //MyUpdate::artisan('storage:link');
    }
}
