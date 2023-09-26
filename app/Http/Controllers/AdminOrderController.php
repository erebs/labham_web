<?php

namespace App\Http\Controllers;

use Session;

use App\Shops;
use App\Order;
use App\Category;
use App\Products;
use App\Customers;
use App\DeliveryBoy;
use App\ProductUnits;
use App\OrderedItems;
use App\return_image;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminOrderController extends Controller
{
  public function __construct(Request $request, Redirector $redirect)
  {
    $this->middleware(function ($request, $next) {
      if (!Auth::id() || (isset(Auth::user()->type) && Auth::user()->type != 'superadmin')) {
        return redirect('/admin/login');
      }
      return $next($request);
    });
  }

  public function index(Request $request)
  {
    $status = $request->input('status') ?? '';
    $search = $request->input('search') ?? '';
    $limit = $request->input('limit') ?? '10';
    $paytype = $request->input('paytype') ?? '';
    $paystatus = $request->input('paystatus') ?? '';

print_r($status);

    $orders = Order::orderBy('id', 'DESC');
    if($status != '' && $status != 'All') {
      $orders = $orders->where('status', $status);
    }
    if($search != '') {
      $orders = $orders->where('id', 'like', "{$search}");
    }
    $orders = $orders->paginate($limit);


    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Orders',
      'orders' => $orders,
      'status' => $status,
      'search' => $search,
      'limit' => $limit,
      'paytype' => $paytype,
      'paystatus' => $paystatus
    ];

    return view('admin.orders.index')->with($data);
  }


  public function view($id)
  {
    $order = Order::where('id', $id)->first();
    $prod  = OrderedItems::where('orderid',$id)->get();
    $retimg  = return_image::where('orderid',$id)->get();

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Orders',
      'order' => $order,
      'prod' => $prod,
      'retimg' => $retimg,
    ];

    return view('admin.orders.view')->with($data);
  }

  public static function getNew($id = 0)
  {
    if($id > 0) {
      return Order::where('shopid', $id)->where('status', 'New')->count();
    } else {
      return Order::where('status', 'New')->count();
    }
  }

  public static function getCount($status)
  {
    return Order::where('status', $status)->count();
  }

  public static function getSellerOrderCount($status, $id)
  {
    return Order::where('shopid', $id)->where('status', $status)->count();
  }

}
