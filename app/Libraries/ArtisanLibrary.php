<?php

namespace App\Libraries;


use Illuminate\Support\Facades\Artisan;

class ArtisanLibrary
{
    static function call( $commend, $options = [] )
    {
        if(!blank($commend)) {
            Artisan::call($commend, $options);
            return Artisan::output();
        }
    }

}
