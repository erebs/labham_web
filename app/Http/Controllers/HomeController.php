<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Banners;
use App\Category;
use App\Products;
use App\Customers;
use App\ProductUnits;
use App\Notifications;
use App\Pincodes;
use App\SubCategory;
use App\Address;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent as Agent;
use Illuminate\Support\Facades\Session;

date_default_timezone_set('Asia/Kolkata');

class HomeController extends Controller
{

  public function __construct()
  {
    $this->userId = 0;
    $this->userName = '';
    $this->alwaysPIN = '';

    if(isset($_COOKIE['UserId']) && $_COOKIE['UserId'] > 0) {
      $this->userId = $_COOKIE['UserId'];
    }
    if(isset($_COOKIE['UserId']) && isset($_COOKIE['UserName'])) {
      $this->userName = $_COOKIE['UserName'];
    }
    if(isset($_COOKIE['alwaysPIN']) && $_COOKIE['alwaysPIN'] != '') {
      $this->alwaysPIN = $_COOKIE['alwaysPIN'];
    }

    $this->pincodes = Pincodes::All();
    $this->categories = Category::orderBy('disporder', 'asc')->where('image', '!=', '')->get();
    $this->cartCount = Cart::where('uniqueid', $this->userId)->count();

    $agent = new Agent();
    if ($agent->isMobile()) {
      $this->mobile = 1;
    } else {
      $this->mobile = 0;
    }
  }

  public function index()
  {
    if($this->mobile == '1') {
      $banners = Banners::where('type', '3')->inRandomOrder()->get();
    } else {
      $banners = Banners::where('type', '1')->inRandomOrder()->get();
    }
    $sbanners = Banners::where('type', '2')->inRandomOrder()->first();
    $fbanners = Banners::where('type', '4')->inRandomOrder()->get();

    $category = Category::pluck('name', 'id');
    $popularsProducts = Products::where('status' , 'Available')
                        ->select('id','name','image','price','cat_id', 'offerprice')
                        ->where('best_seller', '1')
                        ->inRandomOrder()
                        ->limit(15)->get();
    $trendingProducts = Products::where('status' , 'Available')
                        ->select('id','name','image','price','cat_id', 'offerprice')
                        ->where('trending', '1')
                        ->inRandomOrder()
                        ->limit(15)->get();
    $bestOffersProducts = Products::select(
                          Products::raw('id, name, price, offerprice, image, cat_id, ((price - offerprice)/price * 100) AS difference')
                        )
                        ->where('status' , 'Available')
                        ->whereRaw('((price - offerprice)/price * 100) > 20')
                        ->inRandomOrder()
                        ->limit(15)->get();

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Home',
      'banners' => $banners,
      'sbanners' => $sbanners,
      'popularsProducts' => $popularsProducts,
      'trendingProducts' => $trendingProducts,
      'bestOffersProducts' => $bestOffersProducts,
      'category' => $category,
      'fbanners' => $fbanners
    ];
    return view('index')->with($data);
  }

  public function profile(Request $request, $cid = 0, $scid = 0)
  {
    $user = [];
    if($this->userId > 0) {
      $user = Customers::where('id', $this->userId)->first();
    } else {
      return redirect('/');
    }

    if(!$user) {
      return redirect('/logout');
    }

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'My profile',
      'user' => $user
    ];

    return view('profile')->with($data);
  }

  public function saveProfile(Request $request)
  {
    if($this->userId > 0) { } else {
      return redirect('/');
    }

    $user = Customers::find($this->userId);
    $user->name = ucwords($request->input('name')) ?? '';
    $user->email = strtolower($request->input('email')) ?? '';
    $user->save();

    return redirect('/profile')->with('success', 'Profile Updated');
  }

  public function logout()
  {
    setcookie('UserId', '', time()-3600);
    setcookie('UserName', '', time()-3600);
    unset ($_COOKIE['UserId']);
    unset ($_COOKIE['UserName']);

    return redirect('/')->with('success', 'Logout Successfull');
  }

  public function categories()
  {
    $categories = Category::orderBy('disporder', 'asc')->get();
 
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'Header' => 'Categories',
      'categories' => $categories
    ];

    return view('categories')->with($data);
  }

  public function products(Request $request, $cid = 0, $scid = 0)
  {
    $limit = 100;
    $page = $request->input('page') ?? 1;
    $filter = $request->input('filter') ?? 'Newest';
    $offset = ($page -1) * $limit;

    $category = Category::pluck('name', 'id');

    $products = Products::where('status' , 'Available');
    if($cid > 0) {
      $products = $products->where('cat_id', $cid);
    }
    if($scid > 0) {
      $products = $products->where('subcat_id', $scid);
    }
    if($filter == 'newest') {
      $products = $products->orderBy('id', 'desc');
    } elseif($filter == 'featured') {
      $products = $products->where('featured', '1');
    } elseif($filter == 'trending') {
      $products = $products->where('trending', '1');
    } elseif($filter == 'popular') {
      $products = $products->where('best_seller', '1');
    } elseif($filter == 'high') {
      $products = $products->orderBy('offerprice', 'desc');
    } elseif($filter == 'low') {
      $products = $products->orderBy('offerprice', 'asc');
    }
    $products = $products->paginate(40) ?? [];

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Products',
      'cid' => $cid,
      'scid' => $scid,
      'page' => $page,
      'filter' => $filter,
      'products' => $products,
      'category' => $category
    ];

    return view('products')->with($data);
  }

  public static function getSubCats($cat_id)
  {
    return SubCategory::where('cat_id', $cat_id)->get() ?? [];
  }

  public function product($id)
  {
    $product = Products::find($id);
    $category = Category::pluck('name', 'id');

    $units = ProductUnits::where('productid', $id)->orderBy('disp_order', 'asc')->get();
    $unitsCount = ProductUnits::where('productid', $id)->where('status', 'Enabled')->orderBy('disp_order', 'asc')->count();
    $similarProducts = Products::where('status' , 'Available')->where('cat_id', $product->cat_id)->where('id', '!=', $id)->limit(15)->inRandomOrder()->get();

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Product',
      'category' => $category,
      'product' => $product,
      'units' => $units,
      'unitsCount' => $unitsCount,
      'similarProducts' => $similarProducts
    ];

    return view('product')->with($data);
  }

  public function cart()
  {
    $cartCount = Cart::where('uniqueid', $this->userId)->count();
    $category = Category::pluck('name', 'id');
    $carts = Cart::where('uniqueid', $this->userId)->get();

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Checkout',
      'cartCount' => $cartCount ?? '0',
      'carts' => $carts,
      'category' => $category
    ];

    return view('cart')->with($data);
  }

  public function checkout()
  {
    if($this->userId > 0) { } else {
      return redirect('/');
    }

    $address = Address::where('user_id', $this->userId)->where('status', 'Active')->orderBy('id', 'asc')->get();

    $cartCount = Cart::where('uniqueid', $this->userId)->count();
    $category = Category::pluck('name', 'id');
    $carts = Cart::where('uniqueid', $this->userId)->get();

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Checkout',
      'cartCount' => $cartCount ?? '0',
      'carts' => $carts,
      'category' => $category,
      'address' => $address
    ];

    return view('checkout')->with($data);
  }

  public function address()
  {
    if($this->userId > 0) {} else {
      return redirect('/');
    }

    $address = Address::where('user_id', $this->userId)->where('status', 'Active')->get() ?? [];
    $user = Customers::where('id', $this->userId)->first();
  
    if(!$user) {
      return redirect('/logout');
    }

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'My Address',
      'address' => $address,
      'user' => $user
    ];

    return view('address')->with($data);
  }

  public function createAddress()
  {
    if($this->userId > 0) {} else {
      return redirect('/');
    }

    $user = Customers::find($this->userId);

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Create Address',
      'user' => $user
    ];

    return view('createaddress')->with($data);
  }

  public function storeAddress(Request $request)
  {
    $update = [
      'default' => '0'
    ];
    $address = Address::where('user_id', $this->userId)->update($update);

    $address = new Address;
    $address->user_id = $this->userId;
    $address->default = '1';
    $address->name = ucwords($request->input('name')) ?? '';
    $address->email = strtolower($request->input('email')) ?? '';
    $address->mobile = $request->input('mobile') ?? '';
    $address->phone = $request->input('phone') ?? '';
    $address->pincode = $request->input('pincode') ?? '';
    $address->landmark = $request->input('landmark') ?? '';
    $address->city = $request->input('city') ?? '';
    $address->address = $request->input('address') ?? '';
    $address->district = ucwords($request->input('district')) ?? 0;
    $address->state = ucwords($request->input('state')) ?? 0;
    $address->type = $request->input('type') ?? 'Home';
    $address->status = 'Active';
    $address->save();

    return redirect('/address')->with('success', 'Address Added');
  }

  public function showAddress($id)
  {
    if($this->userId > 0) {} else {
      return redirect('/');
    }

    $user = Customers::find($this->userId);
    $address = Address::where('id', $id)->first();
 
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Update Address',
      'user' => $user,
      'address' => $address
    ];

    return view('showaddress')->with($data);
  }

  public function updateAddress(Request $request, $id)
  {
    $update = [
      'default' => '0'
    ];
    $address = Address::where('user_id', $this->userId)->update($update);

    $address = Address::find($id);
    $address->default = '1';
    $address->name = ucwords($request->input('name')) ?? '';
    $address->email = strtolower($request->input('email')) ?? '';
    $address->mobile = $request->input('mobile') ?? '';
    $address->phone = $request->input('phone') ?? '';
    $address->pincode = $request->input('pincode') ?? '';
    $address->landmark = $request->input('landmark') ?? '';
    $address->city = $request->input('city') ?? '';
    $address->address = $request->input('address') ?? '';
    $address->district = ucwords($request->input('district')) ?? 0;
    $address->state = ucwords($request->input('state')) ?? 0;
    $address->type = $request->input('type') ?? 'Home';
    $address->status = 'Active';
    $address->save();

    return redirect('/address')->with('success', 'Address Updated');
  }

  public function removeAddress(Request $request, $id)
  {
    $address = Address::find($id);
    $address->status = 'Deleted';
    $address->save();

    return redirect('/address')->with('success', 'Address Removed.');
  }

  public function placeOrderCoD(Request $request)
  {
      
    if($this->userId > 0) {
      $post_vars = array(
        "icon" => 'https://fahadbazar.com/images/full-logo.png',
        "title" => 'New Order Arrived.',
        "message" => 'New Order Arrived Check your Orders History',
        "url" => 'https://fahadbazar.com/admin/orders'
      );

      $headers = Array();
      $headers[] = "Authorization: api_key=b3a2978b0e03e26dca8f3d9d1c473755";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.pushalert.co/rest/v1/send');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vars));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($ch);
      $output = json_decode($result, true);


      $cartitems = Cart::where('uniqueid', $this->userId)->get();
      $address = Address::where('user_id', $this->userId)->where('status', 'Active')->orderBy('default', 'desc')->first();
      if(count($cartitems) > 0) {
        $total = 0;
        foreach ($cartitems as $key => $value) {
          $unit = ProductUnits::where('id', $value->unitid)->first();

          $order = new Order();
          $order->customerid = $this->userId;
          $order->addressid = $address->id;
          $order->productid = $value->productid;
          $order->unit_name = $unit->name;
          $order->price = $unit->price;
          $order->offerprice = $unit->offerprice;
          $order->quantity = $value->quantity;
          $order->paytype = 'CoD';
          $order->paystatus = 'Pending';
          $order->status = 'New';
          $order->details = '';
          $order->order_on = date('Y-m-d H:i:00');
          $order->save();

          $product = Products::find($value->productid);
          $stock_avalible = $product->stock_avalible - $value->quantity;
          $product->stock_avalible = $stock_avalible;
          $product->save();

          $total = $total + ($unit->offerprice * $value->quantity);
          Cart::where('id', $value->id)->delete();
        }
        $total = $total + 0;

        return redirect('/payment-success/'.$total);
      } else {
        return redirect('/checkout')->with('error', 'Your Cart is Empty!');
      }
    } else {
      return redirect('/login')->with('error', 'Session TimeOut!');
    }
  }

  public function placeOrderOnline(Request $request)
  {
    $total = $sumtotal = 0;
    $orderids = '';

    if($this->userId > 0) {
      $cartitems = Cart::where('uniqueid', $this->userId)->get();
      $address = Address::where('user_id', $this->userId)->where('status', 'Active')->orderBy('default', 'desc')->first();
      if(count($cartitems) > 0) {
        foreach ($cartitems as $key => $value) {
          $unit = ProductUnits::where('id', $value->unitid)->first();

          $order = new Order();
          $order->customerid = $this->userId;
          $order->addressid = $address->id;
          $order->productid = $value->productid;
          $order->unit_name = $unit->name;
          $order->price = $unit->price;
          $order->offerprice = $unit->offerprice;
          $order->quantity = $value->quantity;
          $order->paytype = 'Online';
          $order->paystatus = 'Pending';
          $order->status = 'New';
          $order->details = '';
          $order->order_on = date('Y-m-d H:i:00');
          $order->save();

          $product = Products::find($value->productid);
          $stock_avalible = $product->stock_avalible - $value->quantity;
          $product->stock_avalible = $stock_avalible;
          $product->save();

          if($orderids == '') {
            $orderids = $order->id;
          } else {
            $orderids = $orderids.','.$order->id;
          }

          $total = $total + ($unit->offerprice * $value->quantity);

          Cart::where('id', $value->id)->delete();
        }

        $customer = Customers::where('id', $this->userId)->first();

        $sumtotal = $total;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        // curl_setopt($ch, CURLOPT_HTTPHEADER,
        //             array("X-Api-Key:afb09837a3aa6e557760bc613eae0bed",
        //                   "X-Auth-Token:9edf4aa5687639a9a1d8bd30fc14f83e"));
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array("X-Api-Key:3c25b0585d4fd69cc0c3a751c729f2ba",
                          "X-Auth-Token:87180fedf262c99fd5e3a4d8d7509121"));
        $payload = Array(
            'purpose' => 'Fahadbazar Order of Amount: '.$sumtotal,
            'amount' => $sumtotal,
            'phone' => $customer->phone,
            'buyer_name' => $customer->name,
            'redirect_url' => url('/payresult'),
            'send_email' => true,
            'send_sms' => true,
            'email' => $customer->email,
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $response = json_decode($response);

        Session::put('paymentid', $response->payment_request->id);
        Session::put('orderids', $orderids);
        Session::put('sumtotal', $sumtotal);

        return redirect($response->payment_request->longurl);

      } else {
        return redirect('/checkout')->with('error', 'Your Cart is Empty!');
      }
    } else {
      return redirect('/login')->with('error', 'Session TimeOut!');
    }
  }

  public function payresult(Request $request)
  {
    $paymentid = Session::get('paymentid');
    $orderids = Session::get('orderids');
    $sumtotal = Session::get('sumtotal');

    $details = [];
    $details['payment_id'] = $request->input('payment_id');
    $details['payment_status'] = $request->input('payment_status');
    $details['payment_request_id'] = $request->input('payment_request_id');

    if($request->input('payment_status') == 'Credit') {
      $payment_status = 'Success';
    } elseif($request->input('payment_status') == 'Failed') {
      $payment_status = 'Failed';
    } else {
      $payment_status = 'Pending';
    }

    $orderidsArr = explode(',', $orderids);

    foreach ($orderidsArr as $key => $orderid) {
      $order = Order::find($orderid);
      $order->paymentid = Session::get('paymentid') ?? '';
      $order->paystatus = $payment_status ?? 'Pending';
      $order->details = $details;
      $order->save();

      if($payment_status == 'Failed') {
        $product = Products::find($order->productid);
        $stock_avalible = $product->stock_avalible + $order->quantity;
        $product->stock_avalible = $stock_avalible;
        $product->save();
      }
    }

    if($payment_status == 'Success' || $payment_status == 'Pending') {
      return redirect('/payment-success/'.$sumtotal);
    } else {
      return redirect('/orders')->with('error', 'Payment Failed Try Again!');
    }
  }

  public function paySuccess($amt)
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'title' => 'Payment Success',
      'amt' => $amt
    ];

    return view('payment-success')->with($data);
  }

  public function orders()
  {
    if($this->userId > 0) {} else {
      return redirect('/');
    }

    $orders = Order::orderBy('id', 'desc')->where('customerid', $this->userId)->paginate(10);
    $user = Customers::find($this->userId);
    $category = Category::pluck('name', 'id');

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'orders' => $orders,
      'user' => $user,
      'category' => $category
    ];

    return view('orders')->with($data);
  }

  public function order($id)
  {
    if($this->userId > 0) {} else {
      return redirect('/');
    }

    $order = Order::where('id', $id)->first();
    $user = Customers::find($this->userId);
    $category = Category::pluck('name', 'id');
    $address = Address::where('id', $order->addressid)->first();

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
      'order' => $order,
      'user' => $user,
      'category' => $category,
      'address' => $address
    ];

    return view('order')->with($data);
  }

  public function cancelOrder($id)
  {
    $order = Order::find($id);
    $order->status = 'Cancelled';
    $order->save();

    return redirect('/orders')->with('success', 'Order Cancelled.');
  }

  public function notifications()
  {
    if($this->userId > 0) {} else {
      return redirect('/')->with('error', 'login to Continue.');
    }

    $user = Customers::find($this->userId);
    $notifications = Notifications::orderBy('id', 'desc')->limit(10)->get() ?? [];

    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'notifications' => $notifications,
      'mobile' => $this->mobile,
      'user' => $user
    ];

    return view('notifications')->with($data);
  }

  public function contactus()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile
    ];

    return view('contactus')->with($data);
  }

  public function aboutus()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'mobile' => $this->mobile,
      'cartCount' => $this->cartCount
    ];

    return view('aboutus')->with($data);
  }

  public function terms()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
    ];

    return view('terms')->with($data);
  }

  public function privacy()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
    ];

    return view('privacy')->with($data);
  }

  public function return()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
    ];

    return view('return')->with($data);
  }
	
	 public function refund()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
    ];

    return view('refund')->with($data);
  }
	
		 public function shipping()
  {
    $data = [
      'userId' => $this->userId,
      'userName' => $this->userName,
      'alwaysPIN' => $this->alwaysPIN,
      'pincodes' => $this->pincodes,
      'categories' => $this->categories,
      'cartCount' => $this->cartCount,
      'mobile' => $this->mobile,
    ];

    return view('shipping')->with($data);
  }

  public function file1()
  {
    return view('file1');
  }

  public function file2()
  {
    return view('file2');
  }

  public function file3()
  {
    return view('file3');
  }

  public function file4()
  {
    return view('file4');
  }

  public function file5()
  {
    return view('file5');
  }
}
