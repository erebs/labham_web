<?php

namespace App\Http\Controllers;

use Session;

use App\User;
use App\Order;
use App\Products;
use App\Customers;
use App\DeliveryBoy;
use App\OrderedItems;
use App\Pincodes;
use App\bank_detail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

date_default_timezone_set('Asia/Kolkata');

class AdminController extends Controller
{


  public function index()
  {
    if (!Auth::id()) {
      return redirect('/admin/login');
    }

    $totalproducts = Products::where('delstatus','Active')->count();
    $totalavalibleproducts = Products::where('delstatus','Active')->where('status', 'Available')->count();

    $totalcusts = Customers::count();
    $totalncusts = Customers::where('join_on', '>=', date('Y-m-d 00:00:00'))->count();


    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Dashboard',
      'totalproducts' => $totalproducts ?? '0',
      'totalavalibleproducts' => $totalavalibleproducts ?? '0',
      'totalcusts' => $totalcusts ?? '0',
      'totalncusts' => $totalncusts ?? '0'
    ];
    return view('admin.index')->with($data);
  }


	public function login()
	{
    if (Auth::id()) {
      return redirect('/admin');
    }

    $data = [
      'contentHeader' => 'Login',
    ];

    return view('admin.login')->with($data);
  }


  public function check(Request $req)
  {

    $remember = false;
    if($req->input('remember') == 'on') {
      $remember = true;
    }

    $user = User::where('name', $req->input('name'))
            ->where('password', md5($req->input('password')))
            ->where('type', 'superadmin')
            ->where('status', 'Active')
            ->first();

    if($user) {
      Auth::loginUsingId($user->id, $remember);
      return redirect('/admin');
    } 

   return redirect('/admin/login')->with('error', 'Invalid User Name or Password!');
  }


  public function forget()
  {
  }


  public function sentMail(Request $req)
  {
  }


  public function logout()
  {
    Session::forget('issuperadmin');

    Auth::logout();
    return redirect('/admin/login')->with('success', 'Logout Successfully!');
  }


  public function pincodes()
  {
    $pincodes = Pincodes::All();

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Delivery Pincodes',
      'pincodes' => $pincodes
    ];

    return view('admin.pincodes')->with($data);
  }


  public function savePincodes(Request $request)
  {
    $pincount = Pincodes::where('pincode', $request->input('pincode'))->count();
    if($pincount == 0) {
      $pincodes = new Pincodes();
      $pincodes->pincode = $request->input('pincode') ?? '';
      $pincodes->district = $request->input('district') ?? '';
      $pincodes->state = $request->input('state') ?? '';
      $pincodes->save();
    }

    return redirect('/admin/pincodes')->with('success', 'Pincode Added.');
  }




  public function analytics()
  {
    if (!Auth::id()) {
      return redirect('/admin/login');
    }

    $fdate = $_GET['fdate'] ?? date('d/m/Y');
    $tdate = $_GET['tdate'] ?? date('d/m/Y');
    $sfdate = $_GET['fdate'] ?? date('m/d/Y');
    $stdate = $_GET['tdate'] ?? date('m/d/Y');

    $fdate = date("Y-m-d", strtotime($fdate));
    $tdate = date("Y-m-d", strtotime($tdate));

    $fdate = $fdate.' 00:00:00';
    $tdate = $tdate.' 23:59:59';

    $totalorders = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate]
    ])->count();

    $totaldorders = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate],
      ['status', '=', 'Delivered']
    ])->count();

    $totalcorders = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate],
      ['status', '=', 'Cancelled']
    ])->count();

  

    $customers = Customers::where([
      ['join_on', '>=', $fdate],
      ['join_on', '<=', $tdate]
    ])->count();

    $totaldproducts = OrderedItems::join('orders', 'ordered_items.orderid', '=', 'orders.id')
    ->where([
      ['orders.order_on', '>=', $fdate],
      ['orders.order_on', '<=', $tdate],
      ['orders.status', '=', 'Delivered']
    ])->count();

    $totalcproducts = OrderedItems::join('orders', 'ordered_items.orderid', '=', 'orders.id')
    ->where([
      ['orders.order_on', '>=', $fdate],
      ['orders.order_on', '<=', $tdate],
      ['orders.status', '=', 'Cancelled']
    ])->count();

    $totalamount = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate]
    ])->sum('offerprice');

    $totalpporders = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate],
      ['paystatus', '=', 'Pending']
    ])->count();

    $totalpsorders = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate],
      ['paystatus', '=', 'Success']
    ])->count();

    $totalpforders = Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate],
      ['paystatus', '=', 'Failed']
    ])->count();

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Analytics',
      'fdate' => $fdate,
      'tdate' => $tdate,
      'sfdate' => $sfdate,
      'stdate' => $stdate,
      'totalorders' => $totalorders,
      'totaldorders' => $totaldorders,
      'totalcorders' => $totalcorders,
      'customers' => $customers,
      'totaldproducts' => $totaldproducts,
      'totalamount' => $totalamount,
      'totalcproducts' => $totalcproducts,
      'totalpporders' => $totalpporders,
      'totalpsorders' => $totalpsorders,
      'totalpforders' => $totalpforders,
    ];
    return view('admin.analytics')->with($data);
  }

  public static function getOrderReport($date)
  {
    $fdate = $date.' 00:00:00';
    $tdate = $date.' 23:59:59';

    return Order::where([
      ['order_on', '>=', $fdate],
      ['order_on', '<=', $tdate]
    ])->count();
  }


   public function settings()
  {
    $settings = bank_detail::where('id',1)->first();

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Settings',
      'settings' => $settings
    ];

    return view('admin.settings')->with($data);
  }

   public function setsettings(Request $request)
  {
    
     bank_detail::where('id',1)->update([

      'bank'=>$request->bank,
      'name'=>$request->beneficiary,
      'account_num'=>$request->acc,
      'ifsc_code'=>$request->ifsc,

     ]);
    
    return redirect('/admin/settings')->with('success', 'Bank details updated.');
  }


}
