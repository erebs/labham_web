<?php

namespace App\Http\Controllers;

use Session;

use App\Order;
use App\Customers;
use App\Address;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminCustomerController extends Controller
{
  public function __construct(Request $request, Redirector $redirect)
  {
    $this->middleware(function ($request, $next) {
      return $next($request);
    });
  }

  public function index()
  {
    if (!Auth::id() || (isset(Auth::user()->type) && Auth::user()->type != 'superadmin')) {
      return redirect('/admin/login');
    }
    $search = $_GET['q'] ?? '';

    $customers = Customers::orderBy('id', 'desc');
    if(isset($search) && $search != '') {
      $customers = $customers->where('name', 'like', "%{$search}%")
        ->orWhere('phone', 'like', "%{$search}%");
    }
    $customers = $customers->paginate(10);

    $data = [
      'authuser' => Auth::user(),
      'customers'  => $customers,
      'contentHeader' => 'Customers',
      'search' => $search,
    ];

    return view('admin.customers.index')->with($data);
  }


  public static function get($id)
  {
    return Customers::where('id', $id)->first();
  }

  public static function getAddress($id)
  {
    return Address::where('id', $id)->first();
  }


  public function seller()
  {
    if (Session::get('sellerid') > 0) {} else {
      return redirect('/seller/login');
    }
    $search = $_GET['q'] ?? '';

    $customerid = Order::where('shopid', Session::get('sellerid'))->pluck('customerid');

    $customers = Customers::orderBy('id', 'desc')->whereIn('id', $customerid);
    if(isset($search) && $search != '') {
      $customers = $customers->where('name', 'like', "%{$search}%")
        ->orWhere('phone', 'like', "%{$search}%");
    }
    $customers = $customers->paginate(10);

    $data = [
      'username' => Session::get('sellername'),
      'sellerid' => Session::get('sellerid'),
      'customers'  => $customers,
      'contentHeader' => 'Customers',
      'search' => $search,
    ];

    return view('seller.customers.index')->with($data);
  }
}
