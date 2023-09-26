<?php
namespace App\Http\Controllers;

use Session;

use App\User;
use App\Cart;
use App\Order;
use App\Banners;
use App\Amounts;
use App\Products;
use App\Category;
use App\Customers;
use App\ProductUnits;
use App\Notifications;
use App\SubCategory;
use App\Brands;
use App\Pincodes;
use App\Address;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class ApiController extends Controller
{
  public function getPincodeDetails(Request $request)
  {
    $pincode = $request->input('pincode') ?? '';
    $url = 'https://api.postalpincode.in/pincode/'.$pincode;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response);

    if($response[0]->Status == 'Success') {
      $PostOffice = $response[0]->PostOffice;
      $District = $PostOffice[0]->District;
      $State = $PostOffice[0]->State;
      echo '{"sts":"01","District":"'.$District.'","State":"'.$State.'"}';
    } else {
      echo '{"sts":"00","msg":"No Result Found!"}';
    }
  }

  public function searchPincode(Request $request)
  {
    $term = $request->input('term') ?? '';
    $pincodes = Pincodes::whereRaw("pincode LIKE '%$term%'")->select('pincode')->limit(20)->get();
    if(count($pincodes) > 0) {
      foreach ($pincodes as $value) {
        $option = new \stdClass();
        $option->id = $value->pincode;
        $option->text = $value->pincode;
        $options[] = $option;
      }
      echo json_encode(['results' => $options ?: []]);
    }
  }

  public function addWebPincode(Request $request)
  {
    $pin = $request->input('pin') ?? '';
    setcookie("alwaysPIN", $pin, time() + 30 * 24 * 60 * 60, '/');
    echo '{"sts":"01","msg":"Pincode Added"}';
  }

  public function search(Request $request)
  {
    $data = '';
    $search = $request->input('search') ?? '';
    if($search == '') {
      $categories = Category::where('name', 'LIKE', "%$search%")->limit(5)->where('image', '!=', '')->inRandomOrder()->get();
      if($categories) {
        foreach ($categories as $key => $value) {
          $data .= '<li class="list-group-item1 p-6-12">';
            $data .= '<a href="'.url('/products/'.$value->id).'">';
            $data .= '<img src="'.url($value->image).'" style="max-width: 32px;" alt="'.$value->name.'">
            &nbsp; <b style="color: #658ac5;">'.$value->name.'</b>';
            $data .= '</a>
          </li>';
        }
      }

      $subcategories = SubCategory::where('name', 'LIKE', "%$search%")->limit(5)->inRandomOrder()->get();
      if($subcategories) {
        foreach ($subcategories as $key => $value) {
          $category = Category::where('id', $value->cat_id)->first();
          $data .= '<li class="list-group-item1 p-6-12">';
            $data .= '<a href="'.url('/products/'.$value->cat_id.'/'.$value->id).'">
              <img src="'.url($category->image).'" style="max-width: 32px;" alt="'.$category->name.'">
              &nbsp; '.$value->name.' in 
              <b style="color: #658ac5;">'.$category->name.'</b>
            </a>
          </li>';
        }
      }
    } else {

      $data .= '<li class="list-group-item1 text-muted" style="background-color: #e9eef6;"><strong>Category</strong></li>';
      $categories = Category::where('name', 'LIKE', "%$search%")->limit(3)->where('image', '!=', '')->inRandomOrder()->get();
      if($categories) {
        foreach ($categories as $key => $value) {
          $data .= '<li class="list-group-item1 p-6-12">';
            $data .= '<a href="'.url('/products/'.$value->id).'">';
            $data .= '<img src="'.url($value->image).'" style="max-width: 32px;" alt="'.$value->name.'">
            &nbsp; <b style="color: #658ac5;">'.$value->name. '</b>';
            $data .= '</a>
          </li>';
        }
      }

      $subcategories = SubCategory::where('name', 'LIKE', "%$search%")->limit(3)->inRandomOrder()->get();
      if($subcategories) {
        foreach ($subcategories as $key => $value) {
          $category = Category::where('id', $value->cat_id)->first();
          $data .= '<li class="list-group-item1 p-6-12">';
            $data .= '<a href="'.url('/products/'.$value->cat_id.'/'.$value->id).'">
            <img src="'.url($category->image).'" style="max-width: 32px;" alt="'.$category->name.'">
              &nbsp; '.$value->name.' in 
              <b style="color: #658ac5;">'.$category->name.'</b>
            </a>
          </li>';
        }
      }
      $products = Products::where('name', 'LIKE', "%$search%")->limit(4)->inRandomOrder()->get();
      if($products) {
        $data .= '<li class="list-group-item1 text-muted" style="background-color: #e9eef6;"><strong>Products</strong></li>';
        foreach ($products as $key => $value) {
          $data .= '<li class="list-group-item1 p-6-12">';
          $data .= '<a href="'.url('/product/'.$value->id).'">';
          $data .= '<i class="fas fa-search"></i>&nbsp;&nbsp;'.$value->name;
          $data .= '</li>';
        }
      }
    }

    echo $data;
  }

  public function searchSubCategory(Request $request)
  {
    $options = [];
    $term = $request->input('term') ?? '';
    $search = $request->input('search') ?? 'false';
    $cat_id = $request->input('cat_id') ?? '';

    $cats = SubCategory::whereRaw("name LIKE '%$term%'")->select('id','name');
    if($cat_id > 0) {
      $cats = $cats->where('cat_id', $cat_id);
    }
    $cats = $cats->where('status','Active')->limit(10)->get();

    if($search == 'true') {
      $option = new \stdClass();
      $option->id = '0';
      $option->text = 'Select Sub-Category';
      $options[] = $option;
    }
    if(count($cats) > 0) {
      foreach ($cats as $value) {
        $option = new \stdClass();
        $option->id = $value->id;
        $option->text = $value->name;
        $options[] = $option;
      }
      echo json_encode(['results' => $options ?: []]);
    }
  }

  public function defaultAddress(Request $request)
  {
    $userid = $request->input('userid') ?? '0';
    $addressid = $request->input('addressid') ?? '0';

    $update = [
      'default' => '0'
    ];
    $address = Address::where('user_id', $userid)->update($update);

    $address = Address::find($addressid);
    $address->default = '1';
    $address->save();

    echo '{"sts":"01","msg":"Address Updated"}';
  }

  public function searchPincodes(Request $request)
  {
    $search = $request->input('search') ?? '';
    $limit = $request->input('limit') ?? '10';

    $pincodes = Pincodes::whereRaw("pincode LIKE '%$search%'")->limit($limit)->get();
    
    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['pincodes'] = $pincodes;
    echo json_encode($data);
  }

  public function searchHome(Request $request)
  {
    $search = $request->input('search') ?? '';
    $limit = $request->input('limit') ?? '10';

    $categories = Category::where('name', 'LIKE', "%$search%")->limit($limit)->inRandomOrder()->get();
    $subcategories = SubCategory::where('name', 'LIKE', "%$search%")->limit($limit)->inRandomOrder()->get();
    $products = Products::where('name', 'LIKE', "%$search%")->limit($limit)->inRandomOrder()->get();

    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['categories'] = $categories;
    $data['subcategories'] = $subcategories;
    $data['products'] = $products;
    echo json_encode($data);
  }

  public function login(Request $request)
  {
    $user = Customers::where('password', md5($request->input('password')))
      ->where(function($query) use($request) {
        $query->where('email', $request->input('emailormobile'))
              ->orWhere('phone', $request->input('emailormobile'));
      })->first();
    if($user) {
      setcookie("UserName", $user->name, time() + 30 * 24 * 60 * 60, '/');
      setcookie("UserId", $user->id, time() + 30 * 24 * 60 * 60, '/');

      $data = [];
      $data['sts'] = '01';
      $data['msg'] = 'Success';
      $data['user'] = $user;
      echo json_encode($data);
    } else {
      echo '{"sts":"00","msg":"Invalid User Details!"}';
    }
  }

  public function checkCustomerNumber(Request $request)
  {
    $phone = $request->input('number') ?? '';
    $userCount = Customers::where('phone', $phone)->count();
    if($userCount > 0) {
      echo '{"sts":"01","msg":"Number Already Exists."}';
    } else {
      echo '{"sts":"00","msg":"No Result Found!"}';
    }
  }

  public function checkCustomerEmail(Request $request)
  {
    $email = $request->input('email') ?? '';
    $userCount = Customers::where('email', $email)->count();
    if($userCount > 0) {
      echo '{"sts":"01","msg":"Number Already Exists."}';
    } else {
      echo '{"sts":"00","msg":"No Result Found!"}';
    }
  }

  public function sentRegOTP(Request $request)
  {
    $email = $request->input('email') ?? '';
    $phone = $request->input('number') ?? '';
    $name = $request->input('name') ?? '';

    $otp = rand(1000 , 9999);
    setcookie("alwaysIn", $otp, time() + 60 * 60, '/');

    //app('App\Http\Controllers\MailController')->registrationOTP($email, $phone, $name, $otp);

    $msg = urlencode($otp.' is the OTP for your Fahad Bazar app. Please do not share this with anyone. ');
    $url = 'http://sms.erebs.in/api/sms_api.php?username=fahadbazar&api_password=k5m2yd1739b&message='.$msg.'&destination='.$phone.'&type=2&sender=FAHADB&schedule_time=&template_id=1207164010540181840';
    $ch = curl_init($url); // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    echo '{"sts":"01","msg":"OTP Send"}';
  }

  public function verifyOTP(Request $request)
  {
    if($_COOKIE["alwaysIn"] == $request->input('otp')) {
      echo '{"sts":"01","msg":"OTP Match."}';
    } else {
      echo '{"sts":"00","msg":"OTP Does Not Match!"}';
    }
  }

  public function register(Request $request)
  {
    $user = new Customers();
    $user->name = ucwords($request->input('name')) ?? '';
    $user->email = strtolower($request->input('email')) ?? '';
    $user->password = md5($request->input('password')) ?? '';
    $user->phone = $request->input('number') ?? '';
    $user->join_on = date('Y-m-d H:i:00');
    $user->save();

    setcookie("UserName", $user->name, time() + 30 * 24 * 60 * 60, '/');
    setcookie("UserId", $user->id, time() + 30 * 24 * 60 * 60, '/');

    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['user'] = $user;
    echo json_encode($data);
  }

  public function registerSendOTP(Request $request)
  {
    $email = $request->input('email') ?? '';
    $phone = $request->input('number') ?? '';
    $name = $request->input('name') ?? '';

    $otp = rand(1000 , 9999);

    //app('App\Http\Controllers\MailController')->registrationOTP($email, $phone, $name, $otp);

    $msg = urlencode($otp.' is the OTP for your Fahad Bazar app. Please do not share this with anyone. ');
    $url = 'http://sms.erebs.in/api/sms_api.php?username=fahadbazar&api_password=k5m2yd1739b&message='.$msg.'&destination='.$phone.'&type=2&sender=FAHADB&schedule_time=&template_id=1207164010540181840';
    $ch = curl_init($url); // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    echo '{"sts":"01","msg":"OTP Send.","otp":"'.$otp.'"}';
  }

  public function update(Request $request, $id)
  {
    $user = Customers::find($id);
    $user->name = ucwords($request->input('name')) ?? '';
    $user->email = strtolower($request->input('email')) ?? '';
    $user->save();

    echo '{"sts":"01","msg":"Profile Updated."}';
  }

  public function home(Request $request)
  {
    $categories = Category::inRandomOrder()->get();
    $banners = Banners::where('type', '3')->inRandomOrder()->get();
    $sbanners = Banners::where('type', '2')->inRandomOrder()->first();
    $fbanners = Banners::where('type', '4')->inRandomOrder()->get();
    $popularsProducts = Products::where('status' , 'Available')
                        ->select('id','name','image','price','cat_id', 'offerprice')
                        ->where('best_seller', '1')
                        ->where('stock_avalible', '>', 0)
                        ->inRandomOrder()
                        ->limit(15)->get();
    $trendingProducts = Products::where('status' , 'Available')
                        ->select('id','name','image','price','cat_id', 'offerprice')
                        ->where('trending', '1')
                        ->where('stock_avalible', '>', 0)
                        ->inRandomOrder()
                        ->limit(15)->get();
    $bestOffersProducts = Products::select(
                          Products::raw('id, name, price, offerprice, image, cat_id, ((price - offerprice)/price * 100) AS difference')
                        )
                        ->where('status' , 'Available')
                        ->where('stock_avalible', '>', 0)
                        ->whereRaw('((price - offerprice)/price * 100) > 20')
                        ->inRandomOrder()
                        ->limit(15)->get();

    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['categories'] = $categories;
    $data['banners'] = $banners;
    $data['sbanners'] = $sbanners;
    $data['fbanners'] = $fbanners;
    $data['popularsProducts'] = $popularsProducts;
    $data['trendingProducts'] = $trendingProducts;
    $data['bestOffersProducts'] = $bestOffersProducts;
    echo json_encode($data);
  }

  public function products(Request $request)
  {
    $search = $request->input('search') ?? '';
    $filter = $request->input('filter') ?? 'newest';
    $limit = $request->input('limit') ?? '20';
    $offset = $request->input('offset') ?? '0';
    $cat_id = $request->input('cat_id') ?? '0';
    $subcat_id = $request->input('subcat_id') ?? '0';

    $products = Products::where('status' , 'Available');
    if($cat_id > 0) {
      $products = $products->where('cat_id', $cat_id);
    }
    if($subcat_id > 0) {
      $products = $products->where('subcat_id', $subcat_id);
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
    if(isset($search) && $search != '') {
      $products = $products->where('name', 'like', "%{$search}%");
    }
    $products = $products->offset($offset)->limit($limit)->get();

    $productArr = [];
    if(count($products) > 0) {
      foreach ($products as $key => $value) {
        $product = new \stdClass();
        $product->id = $value->id;
        $product->cat_id = $value->cat_id;
        $product->cat_name = Category::where('id', $value->cat_id)->value('name') ?? '';
        $product->subcat_id = $value->subcat_id;
        $product->stock_avalible = $value->stock_avalible;
        $product->subcat_name = SubCategory::where('id', $value->subcat_id)->value('name') ?? '';
        $product->name = $value->name;
        $product->desc = $value->desc;
        $product->offerprice = $value->offerprice;
        $product->price = $value->price;
        $product->best_seller = $value->best_seller;
        $product->featured = $value->featured;
        $product->trending = $value->trending;
        $product->status = $value->status;
        $product->image = $value->image;
        $product->image2 = $value->image2;
        $product->image3 = $value->image3;
        $product->image4 = $value->image4;
        $product->units = ProductUnits::where('productid', $value->id)->orderBy('disp_order', 'asc')->get();
        $productArr[] = $product;
      }
    }

    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['products'] = $productArr;
    echo json_encode($data);
  }

  public function product($id)
  {
    $product = Products::where('id', $id)->first();
    if($product) {
      $products = Products::where('status', 'Available')->where('stock_avalible', '>', 0);
      if($product->cat_id > 0) {
        $products = $products->where('cat_id', $product->cat_id);
      }
      if($product->subcat_id > 0) {
          $products = $products->where('subcat_id', $product->subcat_id);
        }
      $products = $products->where('id', '!=', $id)->inRandomOrder()->offset(0)->limit(12)->get();

      $productArr = [];
      if(count($products) > 0) {
        foreach ($products as $key => $value) {
          $sproduct = new \stdClass();
          $sproduct->id = $value->id;
          $sproduct->cat_id = $value->cat_id;
          $sproduct->cat_name = Category::where('id', $value->cat_id)->value('name') ?? '';
          $sproduct->subcat_id = $value->subcat_id;
          $sproduct->stock_avalible = $value->stock_avalible;
          $sproduct->subcat_name = SubCategory::where('id', $value->subcat_id)->value('name') ?? '';
          $sproduct->name = $value->name;
          $sproduct->desc = $value->desc;
          $sproduct->offerprice = $value->offerprice;
          $sproduct->price = $value->price;
          $sproduct->best_seller = $value->best_seller;
          $sproduct->featured = $value->featured;
          $sproduct->trending = $value->trending;
          $sproduct->status = $value->status;
          $sproduct->image = $value->image;
          $sproduct->image2 = $value->image2;
          $sproduct->image3 = $value->image3;
          $sproduct->image4 = $value->image4;
          $sproduct->unit = ProductUnits::where('productid', $value->id)->orderBy('disp_order', 'asc')->first();
          $productArr[] = $sproduct;
        }
      }

      $data = [];
      $data['sts'] = '01';
      $data['msg'] = 'Success';
      $data['product'] = $product;
      $data['units'] = ProductUnits::where('productid', $id)->orderBy('disp_order', 'asc')->get();
      $data['category'] = Category::where('id', $product->cat_id)->value('name');
      $data['sub_category'] = SubCategory::where('id', $product->subcat_id)->value('name');
      $data['similar_products'] = $productArr;
      echo json_encode($data);
    } else {
      echo '{"sts":"00","msg":"Product does not Exists!"}';
    }
  }

  public function addToCart(Request $request)
  {
    $userid = $request->input('userid') ?? Session::get('userid') ?? '0';
    $productid = $request->input('productid') ?? '0';
    $unitid = $request->input('unitid') ?? '0';
    $quantity = $request->input('quantity') ?? '0';
    $productname = $request->input('productname') ?? 'Item';


    $product = Products::find($productid);

    if($product->status == 'Available' && $product->stock_avalible > 0) {
      if($product->stock_avalible >= $quantity) {
        $check = Cart::where('uniqueid', $userid)
        ->where('productid', $productid)
        ->where('unitid', $unitid)
        ->first();

        if($check && isset($check->quantity)) {
          $cart = Cart::find($check->id);
          $cart->quantity = $quantity;
          $cart->save();

          echo '{"sts":"01","msg":"Cart Updated."}';
        } else {
          $cart = new Cart();
          $cart->uniqueid = $userid;
          $cart->productid = $productid;
          $cart->unitid = $unitid;
          $cart->quantity = $quantity;
          $cart->created_at = date('Y-m-d H:i:00');
          $cart->save();

          echo '{"sts":"01","msg":"'.$productname.' Added to your Cart"}';
        }
      } else {
        echo '{"sts":"00","msg":"Only '.$product->stock_avalible.' Stocks Remaning."}';
      }
    } else {
      echo '{"sts":"00","msg":"Zero Stock Available"}';
    }
  }

  public function removeCart(Request $request)
  {
    $cartid = $request->input('cartid') ?? '0';
    $cart = Cart::find($cartid);
    $cart->delete();
    echo '{"sts":"01","msg":"Product Removed from Cart"}';
  }

  public function changeQuantity(Request $request)
  {
    $cartid = $request->input('cartid') ?? '0';
    $quantity = $request->input('quantity') ?? '0';

    $cart = Cart::find($cartid);
    $product = Products::find($cart->productid);
    if($product->stock_avalible >= $quantity) {
      $cart->quantity = $quantity;
      $cart->save();
      echo '{"sts":"01","msg":"Cart Updated"}';
    } else {
      echo '{"sts":"00","msg":"Only '.$product->stock_avalible.' Stocks Remaning."}';
    }
  }

  public function getCartCount(Request $request)
  {
    $userid = $request->input('userid') ?? '0';
    return Cart::where('uniqueid', $userid)->count();
  }

  public function getCartSumTotal(Request $request)
  {
    $userid = $request->input('userid') ?? '0';
    $cartitems = Cart::where('uniqueid', $userid)->get();

    $data = '';
    $sumtotal = $totalprice = 0;
    $ccount = count($cartitems) ?? '0';
    if($ccount > 0) {
      foreach ($cartitems as $key => $value) {
        $unit = ProductUnits::where('id', $value->unitid)->first();

        $totalprice = $unit->offerprice * $value->quantity;
        $sumtotal = $sumtotal + $totalprice;
      }
    }
    echo '{"sts":"01","sum":"'.$sumtotal.'"}';
  }

  public function getCart(Request $request)
  {
    $userid = $request->input('userid') ?? '0';

    $cartitems = Cart::where('uniqueid', $userid)->get();

    $cartsArr = [];
    $ccount = count($cartitems) ?? '0';
    if($ccount > 0) {
      foreach ($cartitems as $key => $value) {
        $cartArr = new \stdClass();
        $cartArr->id = $value->id;
        $cartArr->userid = $value->uniqueid;
        $cartArr->productid = $value->productid;
        $cartArr->unitid = $value->unitid;
        $cartArr->quantity = $value->quantity;
        $cartArr->created_at = $value->created_at;
        $cartArr->productname = Products::where('id', $value->productid)->value('name');
        $cartArr->unitname = ProductUnits::where('id', $value->unitid)->value('name');
        $cartArr->stock_avalible = Products::where('id', $value->productid)->value('stock_avalible');
        $cartArr->unitprice = ProductUnits::where('id', $value->unitid)->value('price');
        $cartArr->unitofferprice = ProductUnits::where('id', $value->unitid)->value('offerprice');
        $cartsArr[] = $cartArr;
      }
    }

    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['cart'] = $cartsArr;
    echo json_encode($data);
  }

  public function clearCart(Request $request) {
    $userid = $request->input('userid') ?? '0';

    $cartitems = Cart::where('uniqueid', $userid)->delete();

    echo '{"sts":"01","msg":"Cart Cleared"}';
  }

  public function placeOrder(Request $request)
  {
    $userid = $request->input('userid') ?? '0';
    $paystatus = $request->input('paystatus') ?? 'Pending';
    $details = $request->input('details') ?? '';
    $paymentid = $request->input('paymentid') ?? '';

    if($userid > 0) {
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
      
      $cartitems = Cart::where('uniqueid', $userid)->get();
      $address = Address::where('user_id', $userid)->where('status', 'Active')->orderBy('default', 'desc')->first();

      switch ($request->input('type')) {
        case 'CoD':
          if(count($cartitems) > 0) {
            foreach ($cartitems as $key => $value) {
              $unit = ProductUnits::where('id', $value->unitid)->first();

              $order = new Order();
              $order->customerid = $userid;
              $order->addressid = $request->input('addressid') ?? $address->id;
              $order->productid = $value->productid;
              $order->unit_name = $unit->name;
              $order->price = $unit->price;
              $order->offerprice = $unit->offerprice;
              $order->quantity = $value->quantity;
              $order->paytype = 'CoD';
              $order->paystatus = $paystatus ?? 'Pending';
              $order->status = 'New';
              $order->paymentid = $paymentid ?? '';
              $order->details = $details ?? '';
              $order->order_on = date('Y-m-d H:i:00');
              $order->save();

              $product = Products::find($value->productid);
              $stock_avalible = $product->stock_avalible - $value->quantity;
              $product->stock_avalible = $stock_avalible;
              $product->save();

              Cart::where('id', $value->id)->delete();
            }

            echo '{"sts":"01","msg":"Order Placed"}';
          } else {
            echo '{"sts":"01","msg":"Your Cart is Empty!"}';
          }
          break;

        case 'Online':

          if(count($cartitems) > 0) {
            foreach ($cartitems as $key => $value) {
              $unit = ProductUnits::where('id', $value->unitid)->first();

              $order = new Order();
              $order->customerid = $userid;
              $order->addressid = $request->input('addressid') ?? $address->id;
              $order->productid = $value->productid;
              $order->unit_name = $unit->name;
              $order->price = $unit->price;
              $order->offerprice = $unit->offerprice;
              $order->quantity = $value->quantity;
              $order->paytype = 'Online';
              $order->paystatus = $paystatus ?? 'Pending';
              $order->status = 'New';
              $order->paymentid = $paymentid ?? '';
              $order->details = $details ?? '';
              $order->order_on = date('Y-m-d H:i:00');
              $order->save();

              $product = Products::find($value->productid);
              $stock_avalible = $product->stock_avalible - $value->quantity;
              $product->stock_avalible = $stock_avalible;
              $product->save();

              Cart::where('id', $value->id)->delete();
            }

            echo '{"sts":"01","msg":"Order Placed"}';
          } else {
            echo '{"sts":"01","msg":"Your Cart is Empty!"}';
          }
          break;


        default:
          echo '{"sts":"00","msg":"Something Went Wrong"}';
          break;
      }
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }

  public function orders(Request $request)
  {
    $userid = $request->input('userid') ?? '0';
    $status = $request->input('status') ?? '';
    $limit = $request->input('limit') ?? '10';
    $offset = $request->input('offset') ?? '0';

    $orders = Order::where('customerid', $userid)->orderBy('id', 'desc');
    if(isset($status) && $status != '' && $status != 'All') {
      $orders = $orders->where('status', $status);
    }
    $orders = $orders->offset($offset)->limit($limit)->get();


    $ordersArr = [];
    foreach ($orders as $key => $value) {
      $orderArr = new \stdClass();
      $orderArr->id = $value->id;
      $orderArr->productid = $value->productid;
      $orderArr->customerid = $value->customerid;
      $orderArr->unit_name = $value->unit_name;
      $orderArr->price = $value->price;
      $orderArr->offerprice = $value->offerprice;
      $orderArr->quantity = $value->quantity;
      $orderArr->paytype = $value->paytype;
      $orderArr->paystatus = $value->paystatus;
      $orderArr->status = $value->status;
      $orderArr->details = $value->details;
      $orderArr->order_on = $value->order_on;
      $orderArr->cname = Customers::where('id', $value->customerid)->value('name');
      $orderArr->cphone = Customers::where('id', $value->customerid)->value('phone');
      $orderArr->cemail = Customers::where('id', $value->customerid)->value('email');
      $orderArr->caddress = Address::where('id', $value->addressid)->first();
      $ordersArr[] = $orderArr;
    }


    if(count($orders) > 0) {
      $data = [];
      $data['sts'] = '01';
      $data['msg'] = 'Success';
      $data['orders'] = $ordersArr;
      echo json_encode($data);
    } else {
      echo '{"sts":"00","msg":"No Results Found!"}';
    }
  }


  public function order(Request $request, $id)
  {
    $orderArr = [];

    $order = Order::where('id', $id)->first();

    if(isset($order) > 0) {
      $deliveryboy_id = $order->deliveryboy ?? '0';
      $orderArr['id'] = $order->id;
      $orderArr['customerid'] = $order->customerid;
      $orderArr['productid'] = $order->productid;
      $orderArr['unit_name'] = $order->unit_name;
      $orderArr['price'] = $order->price;
      $orderArr['offerprice'] = $order->offerprice;
      $orderArr['quantity'] = $order->quantity;
      $orderArr['paytype'] = $order->paytype;
      $orderArr['paystatus'] = $order->paystatus;
      $orderArr['status'] = $order->status;
      $orderArr['details'] = $order->details;
      $orderArr['order_on'] = $order->order_on;
      $orderArr['cname'] = Customers::where('id', $order->customerid)->value('name');
      $orderArr['cphone'] = Customers::where('id', $order->customerid)->value('phone');
      $orderArr['cemail'] = Customers::where('id', $order->customerid)->value('email');
      $orderArr['caddress'] = Address::where('id', $order->addressid)->first();

      $data = [];
      $data['sts'] = '01';
      $data['msg'] = 'Success';
      $data['orders'] = $orderArr;
      echo json_encode($data);
    } else {
      echo '{"sts":"00","msg":"No Results Found!"}';
    }
  }

  public function changeOrderStatus(Request $request, $id)
  {
    if($id > 0) {
      $order = Order::find($id);
      $order->adminstatus = $request->input('status') ?? 'New';
      $order->save();

      echo '{"sts":"01","msg":"Order Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }

  public function changePaymentStatus(Request $request, $id)
  {
    if($id > 0) {
      $order = Order::find($id);
      $order->paystatus = $request->input('status') ?? 'Pending';
      $order->save();

      echo '{"sts":"01","msg":"Payment Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }


  public function notifications(Request $request)
  {
    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['notifications'] = Notifications::orderBy('id', 'desc')->get();
    echo json_encode($data);
  }

  public function address(Request $request)
  {
    $userid = $request->input('userid') ?? '0';

    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['address'] = Address::where('user_id', $userid)->where('status', 'Active')->get();
    echo json_encode($data);
  }

  public function storeAddress(Request $request)
  {
    $userid = $request->input('userid') ?? '0';
    $update = [
      'default' => '0'
    ];
    $address = Address::where('user_id', $userid)->update($update);

    $address = new Address;
    $address->user_id = $userid;
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

    echo '{"sts":"01","msg":"Address Created"}';
  }

  public function showAddress($id)
  {
    $data = [];
    $data['sts'] = '01';
    $data['msg'] = 'Success';
    $data['address'] = Address::where('id', $id)->first();;
  }

  public function updateAddress(Request $request, $id)
  {
    $userid = $request->input('userid') ?? '0';
    $update = [
      'default' => '0'
    ];
    $address = Address::where('user_id', $userid)->update($update);

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

    echo '{"sts":"01","msg":"Address Updated"}';
  }

  public function removeAddress(Request $request, $id)
  {
    $address = Address::find($id);
    $address->status = 'Deleted';
    $address->save();

    return redirect('/address')->with('success', 'Address Removed.');
  }


}
