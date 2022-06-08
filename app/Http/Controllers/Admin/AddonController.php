<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Addon;
use App\Models\Migration;
use App\Libraries\MyString;
use App\Libraries\FileLibrary;
use App\Http\Requests\AddonRequest;
use App\Http\Services\AddonService;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\BackendController;




class AddonController extends BackendController
{
    protected $file_name;
    protected $file_folder_name;
    protected $file_extension;
    protected $file_with_path;
    protected $file_upload_path;
    protected $file_extract_path;
    protected $file_extract_path_with_version_folder;
    protected $root_path;
    protected $addon_service;
    protected $addon;
    protected $image;

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Addons';
        $this->addon_service     = new AddonService();

        $this->middleware(['permission:addons'])->only('index');
        $this->middleware(['permission:addons_create'])->only('create', 'store');
        $this->middleware(['permission:addons_delete'])->only('destroy');
    }

    public function index()
    {

        $this->data['addons'] = Addon::where('status', 5)->orderBy('id', 'DESC')->get();
        return view('admin.addon.index', $this->data);
    }

    public function create()
    {
        if(env('DEMO')) {
            return redirect(route('admin.addons.index'))->withError('Addon upload system is disable for the demo');
        }
        return view('admin.addon.create', $this->data);
    }

    public function store( AddonRequest $request )
    {

        $file                                        = $request->addon_file->getClientOriginalName();
        $this->file_name                             = $file;
        $this->file_folder_name                      = pathinfo($file, PATHINFO_FILENAME);
        $this->file_extension                        = pathinfo($file, PATHINFO_EXTENSION);
        $this->file_with_path                        = MyString::set_slash(config('addon.upload_path')) . $this->file_name;
        $this->file_upload_path                      = MyString::set_slash(config('addon.upload_path'));
        $this->file_extract_path                     = MyString::set_slash(config('addon.extract_path'));
        $this->root_path                             = MyString::strReplaceEnd('public/', '', MyString::strReplaceEnd('public', '', config('addon.root_path')));
        $this->file_extract_path_with_version_folder = $this->file_extract_path . $this->file_folder_name . '/file';

        $request->addon_file->move(config('addon.upload_path'), $file);
        $response = $this->addon_upload();
        if($response->status) {
            if(isset($this->addon['id'])) {
                $addon = Addon::where($this->addon)->update(['id' => $this->addon->id]);
            } else {
                $addon = Addon::create($this->addon);
            }

            $addon->addMedia($this->file_extract_path . $this->file_folder_name . $this->image)->toMediaCollection('addon');
            $this->addon_service->delete_zip($this->file_folder_name, $this->file_extract_path);
            return redirect(route('admin.addons.index'))->withSuccess('Addon install successfully.');
        } else {
            return redirect(route('admin.addons.index'))->withError($response->message);
        }
    }

    private function addon_upload()
    {
        try {
            $response = ['status' => false];
            if(File::exists($this->file_with_path)) {
                if(FileLibrary::file_unzip($this->file_with_path, $this->file_extract_path)->status) {
                    $addon_file_read = FileLibrary::read_json('addon.json', $this->file_extract_path . $this->file_folder_name);
                    if($addon_file_read->status) {
                        $addon = Addon::where(['slug' => $addon_file_read->data->slug])->orderBy('id', 'desc')->first();
                        if(!blank($addon) && $addon_file_read->data->version <= $addon->version) {
                            $response['message'] = 'The version already exist';
                        } else {
                            if(FileLibrary::file_manager($this->file_extract_path_with_version_folder, $this->root_path)->status) {
                                $addon_file_read = FileLibrary::read_json('addon.json', $this->file_extract_path . $this->file_folder_name);
                                if($addon_file_read->status) {
                                    $this->addon = [
                                        'title'             => $addon_file_read->data->title,
                                        'description'       => $addon_file_read->data->description,
                                        'version'           => $addon_file_read->data->version,
                                        'date'              => Carbon::parse()->format('Y-m-d H:i:s'),
                                        'purchase_username' => null,
                                        'purchase_code'     => null,
                                        'slug'              => $addon_file_read->data->slug,
                                        'author'            => $addon_file_read->data->author,
                                        'status'            => 5,
                                        'files'             => json_encode($addon_file_read->data)
                                    ];

                                    $this->image = $addon_file_read->data->image;
                                    $this->addon_service->migration('addon.json', $this->file_extract_path . $this->file_folder_name);

                                    $seed_file = $this->file_extract_path . $this->file_folder_name . '/Migration.php';
                                    if(File::exists($seed_file)) {
                                        include($seed_file);
                                        $obj = new \Migration();
                                        $obj->up();
                                    }

                                    $this->addon_service->artisan('addon.json', $this->file_extract_path . $this->file_folder_name);
                                    if(!blank($addon)) {
                                        $this->addon['id'] = $addon->id;
                                    }
                                    $response = ['status' => true, 'message' => 'Success'];
                                } else {
                                    $response['message'] = 'The addon.json file read fail';
                                }
                            } else {
                                $response['message'] = 'The addon file distributions fail';
                            }
                        }
                    } else {
                        $response['message'] = 'The json file does not found.';
                    }
                } else {
                    $response['message'] = 'The addon file unzip fail';
                }
            } else {
                $response['message'] = 'The addon file does not found';
            }

            return (object)$response;
        } catch( \Exception $exception ) {
            return (object)['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function destroy( $id )
    {
        $addon         = Addon::findOrFail($id);
        $file_response = $this->addon_file_delete($addon);
        if($file_response->status) {
            $addon->delete();
            return redirect(route('admin.addons.index'))->withSuccess('The data deleted successfully.');
        } else {
            return redirect(route('admin.addons.index'))->withError($file_response->message);
        }
    }

    private function addon_file_delete( $addon )
    {
        $files             = json_decode($addon->files, true);
        $file_extract_path = MyString::set_slash(config('addon.extract_path'));
        $root_path         = MyString::strReplaceEnd('public/', '', MyString::strReplaceEnd('public', '', config('site.root_path')));
        try {
            if(isset($files['files'])) {
                foreach($files['files'] as $fileWithPath) {
                    if(File::exists($root_path . $fileWithPath)) {
                        File::delete($root_path . $fileWithPath);
                    }
                }
            }

            $seed_file = $file_extract_path . $addon->slug . '/Migration.php';

            if(File::exists($seed_file)) {
                include($seed_file);
                $obj = new \Migration();
                $obj->down();
            }

            if(File::exists($file_extract_path . $addon->slug)) {
                FileLibrary::delete_file_recursive($file_extract_path . $addon->slug);
            }

            return (object)['status' => true, 'message' => 'Success'];
        } catch( \Exception $exception ) {
            return (object)['status' => false, 'message' => $exception->getMessage()];
        }
    }
}
