<?php

namespace App\Http\Controllers;

use Session;

use App\Cart;
use App\Order;
use App\Category;
use App\Products;
use App\ProductUnits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AjaxController extends Controller
{
  public function searchProducts(Request $request)
  {
    $data = '';
    $search = $request->input('search') ?? '';
    $products = Products::where('name', 'like', "%{$search}%")->select('id', 'name')->limit(10)->get();

    foreach ($products as $key => $value) {
      $data .= '<li class="list-group-item"><a href="'.url('/product/'.$value->id).'"><b>'.$value->name.'</b></a></li>';
    }

    echo $data;
  }

  public function changeProductStatus()
  {
    $status = $_GET['status'] ?? 'Active';
    $id = $_GET['id'] ?? '0';

    if($id > 0) {
      $product = Products::find($id);
      $product->status = $status;
      $product->save();

      echo '{"sts":"01","msg":"Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }

  public function changeProductUnitStatus()
  {
    $status = $_GET['status'] ?? 'Active';
    $id = $_GET['id'] ?? '0';

    if($id > 0) {
      $product = ProductUnits::find($id);
      $product->status = $status;
      $product->save();

      echo '{"sts":"01","msg":"Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }

  public function getSizeDetails(Request $request)
  {
    $unitid = $request->input('unitid') ?? '';
    if($unitid > 0) {
      $unit = ProductUnits::where('id', $unitid)->first();
      $offer =  ($unit->price - $unit->offerprice)/$unit->price * 100;

      $data = [];
      $data['sts'] = '01';
      $data['msg'] = 'Success';
      $data['price'] = $unit->price;
      $data['offerprice'] = $unit->offerprice;
      $data['offer'] = round($offer);
      echo json_encode($data);
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong!"}';
    }
  }

  public function addToCart(Request $request)
  {
    if($_COOKIE['UserId'] > 0) {
      $productid = $request->input('productid') ?? '0';
      $productname = $request->input('productname') ?? '';
      $quantity = $request->input('quantity') ?? '';
      $unitid = $request->input('unitid') ?? '';

      $check = Cart::where('uniqueid', $_COOKIE['UserId'])
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
        $cart->uniqueid = $_COOKIE['UserId'];
        $cart->productid = $productid;
        $cart->unitid = $unitid;
        $cart->quantity = $quantity;
        $cart->created_at = date('Y-m-d H:i:00');
        $cart->save();

        echo '{"sts":"01","msg":"'.$productname.' Added to your Cart"}';
      }
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong!"}';
    }
  }

  public function getCartCount()
  {
    return Cart::where('uniqueid', $_COOKIE['UserId'])->count() ?? '0';
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
    $cart->quantity = $quantity;
    $cart->save();
    echo '{"sts":"01","msg":"Cart Updated"}';
  }

  public function changeOrderStatus(Request $request)
  {
    $status = $request->input('status') ?? 'Accepted';
    $id = $request->input('id') ?? '0';

    if($id > 0) {

      if($status=='Delivered')
      {
        $order = Order::find($id);
        $order->status = $status;
        $order->delivered_on = date('Y-m-d H:i:s');
        $order->save();
      }
      else
      {
        $order = Order::find($id);
        $order->status = $status;
        $order->save();
      }
      

      echo '{"sts":"01","msg":"Order Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }

    public function changeReturnStatus(Request $request)
  {
    $status = $request->input('status') ?? 'Pending';
    $id = $request->input('id') ?? '0';

    if($id > 0) {

     
        $order = Order::find($id);
        $order->return_status = $status;
        $order->save();
      
      echo '{"sts":"01","msg":"Return Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }


  public function changePaymentStatus(Request $request)
  {
    $status = $request->input('status') ?? 'Pending';
    $id = $request->input('id') ?? '0';

    if($id > 0) {
      $order = Order::find($id);
      $order->paystatus = $status;
      $order->save();

      echo '{"sts":"01","msg":"Payment Status Updated"}';
    } else {
      echo '{"sts":"00","msg":"Something Went Wrong"}';
    }
  }








  // public function getCategoryBaisedProducts(Request $request)
  // {
  //   $limit = 10;
  //   $search = $request->input('search') ?? '';
  //   $cat_id = $request->input('cats') ?? [];
  //   $min = $request->input('min') ?? '0';
  //   $max = $request->input('max') ?? '0';
  //   $page = $request->input('page') ?? '1';
  //   $offset = ($page - 1) * $limit;
  //   $orderby = $request->input('orderby') ?? '';

  //   $categories = Category::All();

  //   $productsCount = Products::where('status', 'Available');
  //   if($cat_id) {
  //     $productsCount = $productsCount->whereIn('cat_id', $cat_id);
  //   }
  //   if($search != '') {
  //     $productsCount = $productsCount->where('name', 'like', "%{$search}%");
  //   }
  //   if($min > 0) {
  //     $productsCount = $productsCount->where('offerprice', '>', $min);
  //   }
  //   if($max > 0) {
  //     $productsCount = $productsCount->where('offerprice', '<', $max);
  //   }
  //   $productsCount = $productsCount->count();


  //   $products = Products::where('status', 'Available');
  //   if($cat_id) {
  //     $products = $products->whereIn('cat_id', $cat_id);
  //   }
  //   if($search != '') {
  //     $products = $products->where('name', 'like', "%{$search}%");
  //   }
  //   if($min > 0) {
  //     $products = $products->where('offerprice', '>', $min);
  //   }
  //   if($max > 0) {
  //     $products = $products->where('offerprice', '<', $max);
  //   }
  //   if($orderby == 'New') {
  //     $products = $products->orderBy('id', 'desc');
  //   } elseif($orderby == 'Trending') {
  //     $products = $products->orderBy('trending', 'desc');
  //   } elseif($orderby == 'Popular') {
  //     $products = $products->orderBy('best_seller', 'desc');
  //   } elseif($orderby == 'Featured') {
  //     $products = $products->orderBy('featured', 'desc');
  //   }
  //   $products = $products->offset($offset)->limit($limit)->get();


  //   $pageCount = ceil($productsCount / $limit);

  //   $data = '<header class="border-bottom mb-4 pb-3" style="margin-top: 4%;">
  //         <div class="form-inline">
  //           <span class="mr-md-auto">'.$productsCount.' Items found </span>
  //           <select class="mr-2 form-control" id="selOrderBy" onchange="loadProducts(1);">';
  //             if($orderby == 'New') {
  //               $data .= '<option value="New" selected>Latest Products</option>';
  //             } else {
  //               $data .= '<option value="New">Latest Products</option>';
  //             }
  //             if($orderby == 'Trending') {
  //               $data .= '<option value="Trending" selected>Trending Products</option>';
  //             } else {
  //               $data .= '<option value="Trending">Trending Products</option>';
  //             }
  //             if($orderby == 'Popular') {
  //               $data .= '<option value="Popular" selected>Popular Products</option>';
  //             } else {
  //               $data .= '<option value="Popular">Popular Products</option>';
  //             }
  //             if($orderby == 'Featured') {
  //               $data .= '<option value="Featured" selected>Featured Products</option>';
  //             } else {
  //               $data .= '<option value="Featured">Featured Products</option>';
  //             }
  //           $data .= '</select>
  //         </div>
  //       </header>

  //       <div class="row">';
  //         foreach ($products as $key => $value) {
  //           $data .= '<div class="col-md-3 col-6">
  //             <div class="card card-product-grid">
  //               <a href="'.url('/product/'.$value->id).'" class="img-wrap">
  //                 <img src="'.url($value->image).'">
  //               </a>
  //               <figcaption class="info-wrap wrap-adjust">
  //                 <p class="text-muted">';
  //                 if(isset($category[$value->cat_id])) {
  //                   $data .= $category[$value->cat_id];
  //                 }
  //                 $data .= '</p>
  //                 <a href="'.url('/product/'.$value->id).'" class="title ">'.$value->name.'</a>
  //                 <div class="price-wrap mt-2">
  //                   <span class="price">₹ '.$value->offerprice.'</span>
  //                   <del class="price-old">₹ '.$value->price.'</del>';
  //                   $offer =  ($value->price - $value->offerprice)/$value->price * 100;
  //                   $data .= '<b class="label-rating text-success">  <small><b>'.round($offer).'% Off</b></small> </b>
  //                 </div>
  //               </figcaption>
  //             </div>
  //           </div>';
  //         }
  //         if(count($products) == 0) {
  //           $data .= '<center style="width:100%; padding:10%;">
  //           <i class="fas fa-exclamation-circle" style="font-size: 60px; color: #ff6a00;"></i><br><br>
  //           <h3>No Products Found!</h3>
  //           <h5 class="text-muted">Your search did not match any products.</h5>
  //           <center>';
  //         }
  //       $data .= '</div>';

  //       $data .= '<nav class="mt-4" aria-label="Page navigation sample">
  //         <ul class="pagination" style="margin-left: 30%; margin-bottom: 5%">';
  //         if($productsCount <= $limit) {
  //           $data .= '<li class="page-item disabled">
  //             <a class="page-link" href="#">Prev</a>
  //           </li>
  //           <li class="page-item active">
  //             <a class="page-link" href="Javascript:void(0);" onclick="loadProducts(1);">1</a>
  //           </li>
  //           <li class="page-item disabled">
  //             <a class="page-link " href="#">Next</a>
  //           </li>';
  //         } else {
  //           if($page  == 1) {
  //             $data .= '<li class="page-item disabled">
  //               <a class="page-link" href="#">Prev</a>
  //             </li>';
  //           } else {
  //             $data .= '<li class="page-item">
  //               <a class="page-link" href="Javascript:void(0);" onclick="loadProducts('.($page - 1).');">Prev</a>
  //             </li>';
  //           }
  //           for ($i = 1; $i <= $pageCount; $i++) { 
  //             if($page == $i) {
  //               $data .= '<li class="page-item active">
  //                 <a class="page-link" href="Javascript:void(0);" onclick="loadProducts('.$i.');">'.$i.'</a>
  //               </li>';
  //             } else {
  //               $data .= '<li class="page-item">
  //                 <a class="page-link" href="Javascript:void(0);" onclick="loadProducts('.$i.');">'.$i.'</a>
  //               </li>';
  //             }
  //           }
  //           if($page  == $pageCount) {
  //             $data .= '<li class="page-item disabled">
  //               <a class="page-link " href="#">Next</a>
  //             </li>';
  //           } else {
  //             $data .= '<li class="page-item disabled">
  //               <a class="page-link " href="Javascript:void(0);" onclick="loadProducts('.($page + 1).');">Next</a>
  //             </li>';
  //           }
  //         }
  //         $data .= '</ul>
  //       </nav>';
  //   echo $data;
  // }








}
