<?php

namespace App\Http\Services;



use App\Libraries\ArtisanLibrary;
use App\Libraries\FileLibrary;
use App\Libraries\MyString;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AddonService
{
    private function response( $array )
    {
        return (object) $array;
    }

    public function migration( $file_name, $file_extract_path_with_version_folder )
    {
        $addon_json = FileLibrary::read_json($file_name, $file_extract_path_with_version_folder);
        if ( !blank($addon_json) && $addon_json->status ) {
            if ( (bool) $addon_json->data->migration === true ) {
                $response = ArtisanLibrary::call('migrate', ['--force' => true]);
                if ( !blank($response) ) {
                    if ( blank($addon_json->data->seeds) ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function artisan( $file_name, $file_extract_path_with_version_folder )
    {
        $addon_json = FileLibrary::read_json($file_name, $file_extract_path_with_version_folder);
        if ( !blank($addon_json) && $addon_json->status ) {
            if ( !blank($addon_json->data->seeds) ) {
                $seeds = $addon_json->data->seeds;
                foreach ( $seeds as $seed ) {
                    ArtisanLibrary::call($seed['commend'], [ $seed['option']['name'] => $seed['option']['value'] ]);
                }
                return true;
            }
        }
        return false;
    }

    public function delete_zip( $file_folder_name, $file_extract_path )
    {
        $response['status'] = false;
        try {
            $file_with_path = MyString::set_slash($file_extract_path) . $file_folder_name;
            if ( File::exists($file_with_path) ) {
                unlink($file_with_path . '.zip');
            }
            ArtisanLibrary::call('optimize:clear');
            $response['status'] = true;
        } catch ( \Exception $e ) {
            $response['message'] = 'File delete permission problem';
        }

        return (object) $response;
    }

}
