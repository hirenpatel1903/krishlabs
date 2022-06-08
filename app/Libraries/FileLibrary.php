<?php

namespace App\Libraries;
define('STDIN', fopen("php://stdin", "r"));


use Illuminate\Support\Facades\Artisan;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class FileLibrary
{

    private static function response( $array )
    {
        return (object)$array;
    }

    public static function file_unzip( $fileWithPath, $extractPath )
    {
        $array['status'] = false;
        $zip             = new ZipArchive;
        if($zip->open($fileWithPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
            $array['status'] = true;
        } else {
            $array['message'] = 'The update zip does not found';
        }
        return static::response($array);
    }

    public static function file_manager( $fileExtractPathWithVersionFolder, $root_path )
    {
        $response['status'] = true;
        $root_path              = rtrim($root_path, '/');
        if ( static::smart_copy($fileExtractPathWithVersionFolder, $root_path) ) {
            $response['status'] = true;
        } else {
            $response['message'] = 'File distribution fail';
        }
        return static::response($response);
    }

    static function smart_copy(
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
                    $result = static::smart_copy($source . "/" . $file, $__dest, $options);
                }
            }
            closedir($dirHandle);
        } else {
            $result = false;
        }

        return $result;
    }

    public static function delete_file_recursive( $dir )
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

            if ( !static::delete_file_recursive($dir . DIRECTORY_SEPARATOR . $item) ) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public static function read_json( $file_name, $file_extract_path_with_version_folder )
    {
        $response          = [ 'status' => false, 'data' => [] ];
        $update_file_name = MyString::set_slash($file_extract_path_with_version_folder) . $file_name;
        if ( File::exists($update_file_name) ) {
            $file = File::get($update_file_name);
            if ( !blank($file) ) {
                $file  = json_decode($file, true);
                $response = [ 'status' => true, 'data' => (object) $file ];
            } else {
                $response['message'] = $file_name . ' ' . 'file is blank';
            }
        } else {
            $response['message'] = $file_name . ' ' . 'not found';
        }

        return static::response($response);
    }

    public static function deleteWithFile($fileWithPath )
    {
        $returnArray['status'] = false;
        try {
            if ( File::exists($fileWithPath) ) {
                File::delete($fileWithPath);
            }
            $returnArray['status'] = true;
        } catch ( \Exception $e ) {
            $returnArray['message'] = 'File delete permission problem';
        }
        return (object) $returnArray;
    }
}
