<?php

namespace App\Http\Controllers;


use Setting;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;
use RachidLaasri\LaravelInstaller\Helpers\FinalInstallManager;
use RachidLaasri\LaravelInstaller\Helpers\InstalledFileManager;
use RachidLaasri\LaravelInstaller\Events\LaravelInstallerFinished;

class FinalController extends \RachidLaasri\LaravelInstaller\Controllers\FinalController
{

    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        Setting::set([
            'web_purchase_username' => env('PURCHASE_USERNAME'),
            'web_purchase_code' => env('PURCHASE_CODE')]);
        Setting::save();


        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }

}
