<?php

namespace App\Libraries;


use App\Enums\UpdateStatus;
use App\Models\Update;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use ZipArchive;

class MyUpdate
{
    public function __construct()
    {
        define('STDIN',fopen("php://stdin","r"));
    }

    static function fileUnZip( $fileWithPath, $extractPath )
    {
        $array['status'] = false;
        $zip             = new ZipArchive;
        if ( $zip->open($fileWithPath) === true ) {
            $zip->extractTo($extractPath);
            $zip->close();
            $array['status'] = true;
        } else {
            $array['message'] = 'The update zip does not found';
        }
        return (object) $array;
    }

    static function fileManager( $fileExtractPathWithVersionFolder, $rootPath )
    {
        $returnArray['status'] = false;
        $rootPath              = rtrim($rootPath, '/');
        if ( static::smartCopy($fileExtractPathWithVersionFolder, $rootPath) ) {
            $returnArray['status'] = true;
        } else {
            $returnArray['message'] = 'File distribution fail';
        }
        return (object) $returnArray;
    }

    static function smartCopy(
        $source,
        $destination,
        $options = [ 'folderPermission' => 0777, 'filePermission' => 0777 ]
    ) {
        $result = false;
        if ( is_file($source) ) {
            if ( $destination[ strlen($destination) - 1 ] == '/' ) {
                if ( !file_exists($destination) ) {
                    cmfcDirectory::makeAll($destination, $options['folderPermission'], true);
                }
                $__dest = $destination . "/" . basename($source);
            } else {
                $__dest = $destination;
            }
            $result = copy($source, $__dest);
            @chmod($__dest, $options['filePermission']);
        } elseif ( is_dir($source) ) {
            if ( $destination[ strlen($destination) - 1 ] == '/' ) {
                if ( $source[ strlen($source) - 1 ] == '/' ) {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $destination = $destination . basename($source);
                    @mkdir($destination);
                    @chmod($destination, $options['filePermission']);
                }
            } else {
                if ( $source[ strlen($source) - 1 ] == '/' ) {
                    //Copy parent directory with new name and all its content
                    @mkdir($destination, $options['folderPermission']);
                    @chmod($destination, $options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($destination, $options['folderPermission']);
                    @chmod($destination, $options['filePermission']);
                }
            }

            $dirHandle = opendir($source);
            while ( $file = readdir($dirHandle) ) {
                if ( $file != "." && $file != ".." ) {
                    if ( !is_dir($source . "/" . $file) ) {
                        $__dest = $destination . "/" . $file;
                    } else {
                        $__dest = $destination . "/" . $file;
                    }
                    $result = static::smartCopy($source . "/" . $file, $__dest, $options);
                }
            }
            closedir($dirHandle);
        } else {
            $result = false;
        }
        return $result;
    }

    static function migration( $fileName, $fileExtractPathWithVersionFolder )
    {
        $jsonResponse = static::updateJson($fileName, $fileExtractPathWithVersionFolder);
        if ( !blank($jsonResponse) && $jsonResponse->status ) {
            if ( (bool) $jsonResponse->data->migration === true ) {
                $response = static::artisan('migrate');
                if ( !blank($response) ) {
                    if ( blank($jsonResponse->data->seeds) ) {
                        return true;
                    }
                }
            }

            if ( !blank($jsonResponse->data->seeds) ) {
                $seeds = $jsonResponse->data->seeds;
                foreach ( $seeds as $seed ) {
                    static::artisan($seed['commend'], [ $seed['option']['name'] => $seed['option']['value'] ]);
                }
                return true;
            }
        }
        return false;
    }

    static function updateJson( $fileName, $fileExtractPathWithVersionFolder )
    {
        $array          = [ 'status' => false, 'data' => [] ];
        $updateFileName = static::setSlash($fileExtractPathWithVersionFolder) . $fileName;
        if ( File::exists($updateFileName) ) {
            $file = File::get($updateFileName);
            if ( !blank($file) ) {
                $file  = json_decode($file, true);
                $array = [ 'status' => true, 'data' => (object) $file ];
            } else {
                $array['message'] = $fileName . ' ' . 'file is blank';
            }
        } else {
            $array['message'] = $fileName . ' ' . 'not found';
        }
        return (object) $array;
    }

    static function setSlash( $link )
    {
        return rtrim($link, '/') . '/';
    }

    static function artisan( $commend, $options = [] )
    {
        if ( !blank($commend) ) {
            Artisan::call($commend, $options);
            return Artisan::output();
        }
    }

    static function updateLog( $fileName, $fileExtractPathWithVersionFolder )
    {
        $array          = [ 'status' => false, 'data' => [] ];
        $updateFileName = static::setSlash($fileExtractPathWithVersionFolder) . $fileName;
        if ( File::exists($updateFileName) ) {
            $file = File::get($updateFileName);
            if ( !blank($file) ) {
                $array = [ 'status' => true, 'data' => $file ];
            } else {
                $array['message'] = $fileName . ' ' . 'file is blank';
            }
        } else {
            $array['message'] = $fileName . ' ' . 'not found';
        }
        return (object) $array;
    }

    static function PostData()
    {
        $array   = [];
        $updates = Update::where([ 'status' => UpdateStatus::SUCCESS ])->orderByRaw('id DESC')->first();
        if ( !blank($updates) ) {
            $array = [
                'username'       => 'inilabs',
                'purchasekey'    => '0000-0000-0000-0000',
                'domainname'     => Request::root(),
                'email'          => 'info@inilabs.net',
                'currentversion' => $updates->version,
                'projectname'    => config('site.project_name')
            ];
        }
        return $array;
    }

    static function versionChecking( $postData )
    {
        $array = [
            'status'  => false,
            'message' => 'Error',
            'version' => 'none'
        ];

        $postDataString = json_encode($postData);
        $ch              = curl_init(config('site.update_url'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postDataString)
            ]
        );

        $getResult = curl_exec($ch);
        curl_close($ch);
        if ( !blank($getResult) ) {
            $array = json_decode($getResult, true);
        }
        return (object) $array;
    }

    static function fileDownload( $version, $location )
    {
        $response = [ 'status' => false ];
        try {
            ini_set('memory_limit', '1024M');
            $curlUrl = static::setSlash(config('site.file_url')) . $version . '.zip';
            $downloadPath = static::setSlash($location) . $version . '.zip';
            $curl               = curl_init();
            curl_setopt($curl, CURLOPT_URL, $curlUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSLVERSION, 3);
            $data = curl_exec($curl);
            curl_close($curl);
            if($data) {
                if(!File::exists(static::setSlash($location) )) {
                    File::makeDirectory(static::setSlash($location), 0777, true, true);
                }

                if ( $file = @fopen($downloadPath, 'w+') ) {
                    fputs($file, $data);
                    fclose($file);
                    $response['status']       = true;
                } else {
                    $response['message'] = 'Request not found';
                }
            }
            return (object) $response;
        } catch ( \Exception $exception ) {
            $response['message'] = $exception->getMessage();
            return (object) $response;
        }
    }

    static function deleteZipWithFile( $updateVersion, $fileExtractPath )
    {
        $returnArray['status'] = false;
        try {
            $fileWithPath = static::setSlash($fileExtractPath) . $updateVersion;
            if ( File::exists($fileWithPath) ) {
                unlink($fileWithPath . '.zip');
                static::rmdirRecursive($fileWithPath);
            }
            $returnArray['status'] = true;
        } catch ( \Exception $e ) {
            $returnArray['message'] = 'File delete permission problem';
        }
        return (object) $returnArray;
    }

    static function rmdirRecursive( $dir )
    {
        if ( !file_exists($dir) ) {
            return true;
        }

        if ( !is_dir($dir) ) {
            return unlink($dir);
        }

        foreach ( scandir($dir) as $item ) {
            if ( $item == '.' || $item == '..' ) {
                continue;
            }

            if ( !static::rmdirRecursive($dir . DIRECTORY_SEPARATOR . $item) ) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
