<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ShopStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\BackendController;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchaseitem;
use App\Models\Sale;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Dashboard';
        $this->middleware([ 'permission:dashboard' ])->only('index');
    }

    public function index()
    {
        $this->data['months'] = [1=>'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $role      = Role::find(2);
        $this->data['totalCustomer']     = User::role($role->name)->latest()->get();
        if(auth()->user()->myrole == 3){
            $this->data['sales']      = Sale::where(['shop_id'=>auth()->user()->shop->id])->orderBy('id', 'desc')->get();
            $this->data['todaySale'] = Sale::where(['shop_id'=>auth()->user()->shop->id])->orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->get();
            $totalSales = Sale::where(['shop_id'=>auth()->user()->shop->id])->orderBy('id', 'desc')->get();
            $this->data['purchaseAmount'] = Purchase::where(['shop_id'=>auth()->user()->shop->id])->get()->sum('sub_total');
            $this->data['products'] = Product::where(['shop_id'=>auth()->user()->shop->id])->orderBy('id', 'desc')->get();
            $yearlySales = Sale::orderBy('id', 'desc')->where(['shop_id'=>auth()->user()->shop->id])->whereYear('created_at', date('Y'))->get();
            $yearlyPurchases = Purchase::orderBy('id', 'desc')->where(['shop_id'=>auth()->user()->shop->id])->whereYear('created_at', date('Y'))->get();

        }else{
            $this->data['sales']      = Sale::orderBy('id', 'desc')->get();
            $this->data['todaySale'] = Sale::orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->get();
            $this->data['purchaseAmount'] = Purchase::orderBy('id', 'desc')->get()->sum('sub_total');
            $this->data['products'] = Product::orderBy('id', 'desc')->get();
            $totalSales = Sale::orderBy('id', 'desc')->get();
            $yearlySales = Sale::orderBy('id', 'desc')->whereYear('created_at', date('Y'))->get();
            $yearlyPurchases = Purchase::orderBy('id', 'desc')->whereYear('created_at', date('Y'))->get();

        }

        $totalIncome = 0;
        $this->data['totalProduct'] = $this->data['products']->count();
        $this->data['totalTodaySale'] = $this->data['todaySale']->count();

        if ( !blank($totalSales) ) {
            foreach ( $totalSales as $totalSale ) {
                $totalIncome += $totalSale->paid_amount;
            }
        }


        $monthWiseTotalIncome    = [];
        $monthDayWiseTotalIncome = [];
        $monthWiseTotalSale     = [];
        $monthDayWiseTotalSale  = [];
        if ( !blank($yearlySales) ) {
            foreach ( $yearlySales as $yearlySale ) {
                $monthNumber = (int)date('m', strtotime($yearlySale->created_at));
                $dayNumber   = (int)date('d', strtotime($yearlySale->created_at));
                if ( !isset($monthDayWiseTotalIncome[ $monthNumber ][ $dayNumber ]) ) {
                    $monthDayWiseTotalIncome[ $monthNumber ][ $dayNumber ] = 0;
                }
                $monthDayWiseTotalIncome[ $monthNumber ][ $dayNumber ] += $yearlySale->paid_amount;
                if ( !isset($monthWiseTotalIncome[ $monthNumber ]) ) {
                    $monthWiseTotalIncome[ $monthNumber ] = 0;
                }
                $monthWiseTotalIncome[ $monthNumber ] += $yearlySale->paid_amount;
                if ( !isset($monthDayWiseTotalSale[ $monthNumber ][ $dayNumber ]) ) {
                    $monthDayWiseTotalSale[ $monthNumber ][ $dayNumber ] = 0;
                }
                $monthDayWiseTotalSale[ $monthNumber ][ $dayNumber ] += 1;
                if ( !isset($monthWiseTotalSale[ $monthNumber ]) ) {
                    $monthWiseTotalSale[ $monthNumber ] = 0;
                }
                $monthWiseTotalSale[ $monthNumber ] += 1;
            }
        }

        $monthWiseTotalPurchase    = [];
        $monthDayWiseTotalPurchase = [];

        if ( !blank($yearlyPurchases) ) {
            foreach ( $yearlyPurchases as $yearlyPurchase ) {
                $monthNumber = (int)date('m', strtotime($yearlyPurchase->created_at));
                $dayNumber   = (int)date('d', strtotime($yearlyPurchase->created_at));
                if ( !isset($monthWiseTotalPurchase[ $monthNumber ]) ) {
                    $monthWiseTotalPurchase[ $monthNumber ] = 0;
                }
                $monthWiseTotalPurchase[ $monthNumber ] += $yearlyPurchase->sub_total;
            }
        }

        $this->data['monthWiseTotalIncome']    = $monthWiseTotalIncome;
        $this->data['monthDayWiseTotalIncome'] = $monthDayWiseTotalIncome;
        $this->data['monthWiseTotalSale']     = $monthWiseTotalSale;
        $this->data['monthDayWiseTotalSale']  = $monthDayWiseTotalSale;

        $this->data['monthWiseTotalPurchase']     = $monthWiseTotalPurchase;
        $this->data['monthDayWiseTotalPurchase']  = $monthDayWiseTotalSale;
        $this->data['totalSales'] = $totalSales;
        $this->data['totalIncome'] = $totalIncome;

        return view('admin.dashboard.index', $this->data);
    }

    public function dayWiseIncomeSale( Request $request )
    {
        $type          = $request->type;
        $monthID       = $request->monthID;
        $dayWiseData   = $request->dayWiseData;
        $showChartData = [];
        if ( $type && $monthID ) {
            $days        = date('t', mktime(0, 0, 0, $monthID, 1, date('Y')));
            $dayWiseData = json_decode($dayWiseData, true);
            for ( $i = 1; $i <= $days; $i++ ) {
                $showChartData[ $i ] = isset($dayWiseData[ $i ]) ? $dayWiseData[ $i ] : 0;
            }
        } else {
            for ( $i = 1; $i <= 31; $i++ ) {
                $showChartData[ $i ] = 0;
            }
        }
        echo json_encode($showChartData);
    }

}
