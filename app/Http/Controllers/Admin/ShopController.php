<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Shop;
use App\Models\User;
use App\Enums\Status;
use App\Models\Product;
use App\Helpers\Support;
use App\Enums\ShopStatus;
use App\Enums\UserStatus;
use App\Enums\ProductType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\ShopRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BackendController;

class ShopController extends BackendController
{
    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Shops';
        $this->middleware(['permission:shop'])->only('index');
        $this->middleware(['permission:shop_create'])->only('create', 'store');
        $this->middleware(['permission:shop_edit'])->only('edit', 'update');
        $this->middleware(['permission:shop_delete'])->only('destroy');
        $this->middleware(['permission:shop_show'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Support::checking()->status) {
            if (auth()->user()->myrole == 3) {
                $shopID = auth()->user()->shop->id ?? 0;
                if ($shopID == 0) {
                    return view('admin.shop.shopcreate', $this->data);
                }
                return $this->show($shopID);
            }
            return view('admin.shop.index', $this->data);
        } else {
            return redirect(route('admin.setting.purchasekey'))->withError('Invalid Envato Username and Purchase code.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shop.create', $this->data);
    }

    /**
     * @param ShopRequest $request
     *
     * @return mixed
     */
    public function store(ShopRequest $request)
    {
        $user             = new User;
        $user->first_name = strip_tags($request->get('first_name'));
        $user->last_name  = strip_tags($request->get('last_name'));
        $user->email      = strip_tags($request->get('email'));
        $user->username   = strip_tags($request->username ?? $this->username($request->email));
        $user->phone      = strip_tags($request->get('phone'));
        $user->address    = strip_tags($request->get('address'));
        $user->status     = $request->get('userstatus');
        $user->password   = bcrypt(strip_tags($request->get('password')));
        $user->save();
        $role = Role::find(3);
        $user->assignRole($role->name);
        $shop                  = new Shop;
        $shop->user_id         = $user->id;
        $shop->name            = strip_tags($request->name);
        $shop->description     = strip_tags($request->description);
        $shop->address         = strip_tags($request->shopaddress);
        $shop->status     = $request->get('status');
        $shop->save();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $shop->addMediaFromRequest('image')->toMediaCollection('shops');
        }

        return redirect(route('admin.shop.index'))->withSuccess('The Data Inserted Successfully');
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['shop']      = Shop::shopowner()->findOrFail($id);

        return view('admin.shop.edit', $this->data);
    }

    /**
     * @param ShopRequest $request
     * @param Shop $shop
     *
     * @return mixed
     */
    public function update(ShopRequest $request, Shop $shop)
    {
        if (!blank($shop->user)) {

            $user             = $shop->user;
            $user->first_name = strip_tags($request->get('first_name'));
            $user->last_name  = strip_tags($request->get('last_name'));
            $user->email      = strip_tags($request->get('email'));
            $user->username   = strip_tags($request->username ?? $this->username($request->email));
            $user->phone      = strip_tags($request->get('phone'));
            $user->address    = strip_tags($request->get('address'));
            $user->status     = $request->get('userstatus');
            if (!blank($request->get('password')) && (strlen($request->get('password')) >= 4)) {
                $user->password = bcrypt(strip_tags($request->get('password')));
            }
            $user->save();
            $role = Role::find(3);
            $user->assignRole($role->name);;
            $shop->name            = strip_tags($request->name);
            $shop->description     = strip_tags($request->description);
            $shop->address         = strip_tags($request->shopaddress);
            $shop->status = $request->status;
            $shop->save();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $shop->media()->delete($shop->id);
                $shop->addMediaFromRequest('image')->toMediaCollection('shops');
            }
            return redirect(route('admin.shop.index'))->withSuccess('The Data Updated Successfully');
        } else {
            return redirect(route('admin.shop.index'))->withError('The User Not Found');
        }
    }

    public function show($id)
    {
        $shop                          = Shop::shopowner()->findOrFail($id);
        $orders                        = Sale::where(['shop_id' => $id])->whereDate('created_at', Carbon::today())->get();
        $this->data['total_order']     = $orders->count();
        if (blank($shop->user)) {
            return redirect(route('admin.shop.index'))->withError('The user not found.');
        }
        $this->data['shop'] = $shop;
        $this->data['user'] = $shop->user;
        return view('admin.shop.show', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shop::shopowner()->findOrFail($id)->delete();
        return redirect(route('admin.shop.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getshop(Request $request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }

            if (!blank($queryArray)) {
                $shops = Shop::where($queryArray)->orderBy('id', 'desc')->shopowner()->get();
            } else {
                $shops = Shop::orderBy('id', 'desc')->shopowner()->get();
            }
            $i         = 1;
            $shopArray = [];
            if (!blank($shops)) {
                foreach ($shops as $shop) {
                    $shopArray[$i]          = $shop;
                    $shopArray[$i]['name']  = Str::limit($shop->name, 20);
                    $shopArray[$i]['setID'] = $i;
                    $i++;
                }
            }
            return Datatables::of($shopArray)->addColumn('action', function ($shop) {
                $retAction = '';
                if (auth()->user()->can('shop_show')) {
                    $retAction .= '<a href="' . route('admin.shop.show', $shop) . '" class="btn btn-sm btn-icon float-left btn-info mr-2" data-toggle="tooltip" data-placement="top" title="View"> <i class="far fa-eye"></i></a>';
                }
                if (auth()->user()->can('shop_edit')) {
                    $retAction .= '<a href="' . route('admin.shop.edit', $shop) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }
                if (auth()->user()->can('shop_delete')) {
                    $retAction .= '<form class="float-left pl-2" action="' . route('admin.shop.destroy', $shop) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                }
                return $retAction;
            })->editColumn('user_id', function ($shop) {
                return Str::limit($shop->user->name ?? null, 20);
            })
                ->editColumn('status', function ($shop) {
                    return ($shop->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })->editColumn('id', function ($shop) {
                    return $shop->setID;
                })->make(true);
        }
    }


    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }
}
