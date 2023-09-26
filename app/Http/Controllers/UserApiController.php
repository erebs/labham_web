<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 use Illuminate\Support\Facades\Hash;
use App\Category;
use App\Products;
use App\Banners;
use App\Customers;
use App\Address;
use App\Cart;
use App\temp_cart;
use App\Order;
use App\OrderedItems;
use App\return_image;
use App\bank_detail;
use App\product_gallery;
use App\product_video;

class UserApiController extends Controller
{

     public function check_number(Request $req)
    {
        $rules = [
                    
                    'mobile' => 'required',
                   

                    ];
                
            $validator = Validator::make($req->all(), $rules);  

             if ($validator->fails()) 
                {
                   return response()->json(['message'=>"Validation error",'status_code'=>'00'],400);
                } 
            else 
                {
                    if(Customers::where('phone',$req->mobile)->exists())
                    {
                        return response()->json(['message'=>"Mobile number already exists",'status_code'=>'00'],400);
                    }
                    else
                    {
                        
                        return response()->json([

                            'message'=>'Mobile number verified successfully',
                            'status_code'=>'01'
                            ],200);

                     }

                 }
    }

    public function register(Request $req)
    {
        $rules = [
                    'name' => 'required',
                    'mobile' => 'required',
                    'password' => 'required',

                    ];
                
            $validator = Validator::make($req->all(), $rules);  

             if ($validator->fails()) 
                {
                   return response()->json(['message'=>"Validation error",'status_code'=>'00'],400);
                } 
            else 
                {
                    if(Customers::where('phone',$req->mobile)->exists())
                    {
                        return response()->json(['message'=>"Mobile number already exists",'status_code'=>'00'],400);
                    }
                    else
                    {
                        Customers::create([

                            'name'=>$req->name,
                            'phone'=>$req->mobile,
                            'password'=>bcrypt($req->password)


                        ]);
                        return response()->json([

                            'message'=>'Registration completed successfully.',
                            'status_code'=>'01'
                            ],200);

                     }

                 }
    }


        public function login(Request $req)
    {
        $rules = [

                    'mobile' => 'required',
                    'password' => 'required',

                    ];
                
            $validator = Validator::make($req->all(), $rules);  

             if ($validator->fails()) 
                {
                   return response()->json(['message'=>"Validation error",'status_code'=>'00'],400);
                } 
            else 
                {
                    $user=Customers::where('phone', $req->mobile)->first(); 
                    if($user)
                        {
                            if(Hash::check($req->password,$user->password))
                            {
                                $token=$user->createToken('user-app')->plainTextToken;

                                return response()->json([

                               // 'user_id'=>$user->id,    
                                'token'=>$token,    
                                'name'=>$user->name,
                                //'email_id'=>$user->email_id,    
                                'message'=>'Login Success',
                                'status_code'=>'01'
                                ],200);
                            }
                            else
                            {
                                return response()->json([

                                'message'=>'Incorrect password ',
                                'status_code'=>'00'
                                ],400);
                            }
                          
                        }
                        else
                            {
                                return response()->json([

                                'message'=>'Invalid user ',
                                'status_code'=>'00'
                                ],400);
                            }

                 }
    }


        public function home()
        {
            $user=auth()->user()->id;

            $user_details=Customers::where('id',$user)->first();
            $categories=Category::where('status','Active')->orderBy('disporder','ASC')->limit(4)->get();
            $banners = Banners::where('type', '1')->orderBy('id', 'asc')->get();
            $popular_products=Products::where('delstatus','Active')->where('status','Available')->where('best_seller', '1')->orderBy('id','DESC')->limit(4)->get();
            $featured_products=Products::where('delstatus','Active')->where('status','Available')->where('featured', '1')->orderBy('id','DESC')->limit(4)->get();
            $trending_products=Products::where('delstatus','Active')->where('status','Available')->where('trending', '1')->orderBy('id','DESC')->limit(4)->get();

            return response()->json([

                    'user_details'=>$user_details,
                    'categories'=>$categories,
                    'banners'=>$banners,
                    'popular_products'=>$popular_products,
                    'featured_products'=>$featured_products,
                    'trending_products'=>$trending_products,
                    'status_code'=>'01'
                    ],200);
        }

         public function all_categories()
        {

            $categories=Category::where('status','Active')->orderBy('disporder','ASC')->get();

            return response()->json([

                    'categories'=>$categories,
                    'status_code'=>'01'
                    ],200);
        }

        public function all_products()
        {

            $products=Products::where('delstatus','Active')->where('status','Available')->get();
            $banner = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();

            return response()->json([

                    'products'=>$products,
                    'banner'=>$banner,
                    'status_code'=>'01'
                    ],200);
        }

    public function popular_products()
    {
        $products=Products::where('delstatus','Active')->where('status','Available')->where('best_seller', '1')->orderBy('id','DESC')->get();
        $banner = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
        return response()->json([

                    'products'=>$products,
                    'banner'=>$banner,
                    'status_code'=>'01'
                    ],200);
    }

     public function featured_products()
    {
        $products=Products::where('delstatus','Active')->where('status','Available')->where('featured', '1')->orderBy('id','DESC')->get();
        $banner = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
       return response()->json([

                    'products'=>$products,
                    'banner'=>$banner,
                    'status_code'=>'01'
                    ],200);
    }

     public function trending_products()
    {
         $products=Products::where('delstatus','Active')->where('status','Available')->where('trending', '1')->orderBy('id','DESC')->get();
         $banner = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
       return response()->json([

                    'products'=>$products,
                    'banner'=>$banner,
                    'status_code'=>'01'
                    ],200);
    }

     public function categorywise_products($catid)
    {
        $products=Products::where('delstatus','Active')->where('status','Available')->where('cat_id', $catid)->get();
       return response()->json([

                    'products'=>$products,
                    'status_code'=>'01'
                    ],200);
    }

    public function product_details($pid)
    {
        $product=Products::where('id',$pid)->first();
        $gallery=product_gallery::where('product_id',$pid)->get();
        $videos=product_video::where('product_id',$pid)->get();
        $related_products=Products::where('delstatus','Active')->where('status','Available')->where('id','!=', $product->id)->orderBy('id','DESC')->limit(4)->get();
       return response()->json([

                    'product'=>$product,
                    'gallery'=>$gallery,
                    'videos'=>$videos,
                    'related_products'=>$related_products,
                    'status_code'=>'01'
                    ],200);
    }

            public function user_profile()
        {
            $user=auth()->user()->id;

            $user_details=Customers::where('id',$user)->first();
            return response()->json([

                    'name'=>$user_details->name,
                    'mobile'=>$user_details->phone,
                    'email'=>$user_details->email,
                    'status_code'=>'01'
                    ],200);
        }

          public function edit_profile(Request $req)
    {
        $user=auth()->user()->id;

           if(Customers::where('phone',$req->mobile)->where('id','!=',$user)->exists())
                {
                    return response()->json([
                    'message'=>'Mobile number already exists',
                    'status_code'=>'00'
                    ],400);
                }
           else if(Customers::where('email',$req->mail)->where('id','!=',$user)->exists())
                {
                    return response()->json([
                    'message'=>'Mail Id already exists',
                    'status_code'=>'00'
                    ],400);
                }    
            else
                {
                    Customers::where('id',$user)->update([

                        'name'=>$req->name,
                        'phone'=>$req->mobile,
                        'email'=>$req->mail,

                    ]);
                    return response()->json([
                    'message'=>'Profile updated successfully',
                    'status_code'=>'01'
                    ],200);
                }    
        

       
    }

        public function all_address(Request $req)
    {
        $user=auth()->user()->id;
         $address_list=Address::where('user_id',$user)->where('status','Active')->orderBy('id','DESC')->get();

                    return response()->json([
                    'address_list'=>$address_list,
                    'status_code'=>'01'
                    ],200);
       
    }

     public function add_address(Request $req)
    {
        $user=auth()->user()->id;
        if(Address::where('user_id',$user)->where('status','Active')->exists())
        {
            $default='0';
        }
        else
        {
          $default='1';  
        }

        Address::create([

                        'user_id'=>$user,
                        'default'=>$default,
                        'name'=>$req->name,
                        'mobile'=>$req->mobile,
                        'address'=>$req->address,
                        'district'=>$req->district,
                        'state'=>$req->state,
                        'pincode'=>$req->pincode,
                        'landmark'=>$req->landmark,


                    ]);
                    return response()->json([
                    'message'=>'Address added successfully',
                    'status_code'=>'01'
                    ],200);
    }

        public function default_address(Request $req)
    {

        $user=auth()->user()->id;
        Address::where('id',$req->address_id)->update([

                        'default'=>'1',
                    ]);

        Address::where('user_id',$user)->where('id','!=',$req->address_id)->update([

                        'default'=>'0',
                    ]);

            return response()->json([
                    'message'=>'Address set as defualt',
                    'status_code'=>'01'
                    ],200);
    }

     public function edit_address(Request $req)
    {

        Address::where('id',$req->address_id)->update([

                        'name'=>$req->name,
                        'mobile'=>$req->mobile,
                        'address'=>$req->address,
                        'district'=>$req->district,
                        'state'=>$req->state,
                        'pincode'=>$req->pincode,
                        'landmark'=>$req->landmark,


                    ]);
        return response()->json([
                    'message'=>'Address updated successfully',
                    'status_code'=>'01'
                    ],200);
    }

     public function delete_address(Request $req)
    {
        $user=auth()->user()->id;
        $chkdef=Address::where('id',$req->address_id)->first();
        if($chkdef->default=='1')
        {
           Address::where('id',$req->address_id)->update([

                        'status'=>'Deleted',
                    ]);
           $add=Address::where('user_id',$user)->where('status','Active')->orderBy('id','DESC')->limit(1)->first();
           Address::where('id',$add->id)->update([

                        'default'=>'1',
                    ]);
                     return response()->json([
                    'message'=>'Address deleted successfully',
                    'status_code'=>'01'
                    ],200); 
        }

        else
        {
           Address::where('id',$req->address_id)->update([

                        'status'=>'Deleted',
                    ]);
            return response()->json([
                    'message'=>'Address deleted successfully',
                    'status_code'=>'01'
                    ],200);         
        }
        
               
        
    }


    ////////////////////////////

    public function cart()
    {
        $user=auth()->user()->id;
        //$cart=Cart::where('uniqueid',$user)->orderBy('id','DESC')->get();
        $cart = Cart::join('products', 'carts.productid', '=', 'products.id')
    ->select('carts.*', 'products.name', 'products.desc', 'products.image', 'products.price', 'products.offerprice')
    ->where('uniqueid',$user)
    ->orderBy('id','DESC')
    ->get();
        return response()->json([
                    'cart'=>$cart,
                    'status_code'=>'01'
                    ],200); 
    }

    public function cart_count()
    {
        $user=auth()->user()->id;
        $cart=Cart::where('uniqueid',$user)->sum('quantity');
        return response()->json([
                    'cart_count'=>$cart,
                    'status_code'=>'01'
                    ],200); 
    }

    public function add_item(Request $req)
    {

             $user=auth()->user()->id;
                $chk=Cart::where('uniqueid',$user)->where('productid',$req->product_id)->first();
                if($chk)
                {
                       Cart::where('uniqueid',$user)->where('productid',$req->product_id)->update([

                        'quantity'=>$chk->quantity+$req->qty,

                       ]);
                        return response()->json([
                    'message'=>'Item added to cart',
                    'status_code'=>'01'
                    ],200); 
                }

                else
                {
                   Cart::create([

                                'uniqueid'=>$user,
                                'productid'=>$req->product_id,
                                'unitid'=>0,
                                'color_id'=>0,
                                'quantity'=>$req->qty,
                                'created_at'=>date('Y-m-d H:i:s')
                            ]);
                     return response()->json([
                    'message'=>'Item added to cart',
                    'status_code'=>'01'
                    ],200);         
                }
 
       
    }

         public function delete_item(Request $req)
    {
        
           Cart::where('id',$req->cart_id)->delete();
             return response()->json([
                    'message'=>'Item deleted successfully',
                    'status_code'=>'01'
                    ],200);
    }

        public function increase_qty(Request $req)
    {
        
        $cart=Cart::where('id',$req->cart_id)->first();
           Cart::where('id',$req->cart_id)->update([

            'quantity'=>$cart->quantity+1,

           ]);
            return response()->json([
                    'message'=>'Cart updated successfully',
                    'status_code'=>'01'
                    ],200);
    }

     public function decrease_qty(Request $req)
    {
        $cart=Cart::where('id',$req->cart_id)->first();
           Cart::where('id',$req->cart_id)->update([

            'quantity'=>$cart->quantity-1,

           ]);
            return response()->json([
                    'message'=>'Cart updated successfully',
                    'status_code'=>'01'
                    ],200);
    }

      public function bank_details()
    {
  
        $bank_details=bank_detail::where('id',1)->first();
       return response()->json([
                    'bank_details'=>$bank_details,
                    'status_code'=>'01'
                    ],200);
    }


    public function place_order(Request $req)
    {
        $user=auth()->user()->id;
        $cart=Cart::where('uniqueid',$user)->orderBy('id','DESC')->get();

        $order=Order::create([

                'customerid'=>$user,
                'addressid'=>$req->address_id,
                'paytype'=>$req->payment_type,
                'paymentid'=>$req->reference_id,
                'details'=>$req->note,
                'order_on'=>date('Y-m-d H:i:s')

            ]);
        $lastInsertedId = $order->id;

        foreach($cart as $c)
        {
           OrderedItems::create([

                'orderid'=>$lastInsertedId,
                'productid'=>$c->productid,
                'quantity'=>$c->quantity,
                'amount'=>$c->GetProd->offerprice*$c->quantity,

            ]); 

           Cart::where('id',$c->id)->delete();
        }

        return response()->json([
                    'messages'=>'Order placed successfully',
                    'status_code'=>'01'
                    ],200);
    }


    ///////////////////////////////////////


      public function orders()
    {
         $user=auth()->user()->id;
        //$orders=Order::where('customerid',$user)->orderBy('order_on','DESC')->get();
        // $orders = Order::join('ordered_items', 'orders.id', '=', 'ordered_items.orderid')
        //     ->join('products', 'ordered_items.productid', '=', 'products.id')
        //     ->select('orders.*', 'products.name', 'products.desc', 'products.image', 'products.price', 'products.offerprice', 'ordered_items.quantity','ordered_items.amount')
        //     ->where('customerid',$user)
        //     ->orderBy('order_on','DESC')
        //     ->get();

         $orders = Order::with(['orderedItems.product'])
    ->where('customerid', $user)
    ->orderBy('order_on', 'DESC')
    ->get();

    $formattedOrders = [];
foreach ($orders as $order) {
    $formattedOrder = [
        'order_id' => $order->id,
        'order_date' => $order->order_on,
        'customer_id' => $order->customerid,
        'total_amount' => $order->total_amount,
        'status' => $order->status,
        'return_status' => $order->return_status,
        'return_details' => $order->return_det,
        'status' => $order->status,
        'ordered_items' => [],
        'return_images' => []
    ];

    foreach ($order->orderedItems as $orderedItem) {
        $formattedOrderedItem = [
            'product_name' => $orderedItem->product->name,
            'product_desc' => $orderedItem->product->desc,
            'product_image' => $orderedItem->product->image,
            'quantity' => $orderedItem->quantity,
            'amount' => $orderedItem->amount,
        ];
        $formattedOrder['ordered_items'][] = $formattedOrderedItem;
    }
    foreach ($order->returnImages as $returnImage) {
        $formattedReturnImage = [
            'image_path' => $returnImage->image,
           
        ];
        $formattedOrder['return_images'][] = $formattedReturnImage;
    }

    $formattedOrders[] = $formattedOrder;
}






       return response()->json([
                    'orders'=>$formattedOrders,
                    'status_code'=>'01'
                    ],200);
    }

     public function cancel_order(Request $req)
    {

        //$order=Order::where('id',$req->order_id)->first();
        Order::where('id',$req->order_id)->update([

            'status'=>'Cancelled',
           

        ]);

            return response()->json([
                    'message'=>'Order cancelled successfully',
                    'status_code'=>'01'
                    ],200);
    }

    /////////////////////////////


      public function search_product(Request $req)
    {
        $prod = $req->product;
       $products = Products::where('name', 'like', '%' . $prod . '%')->where('delstatus','Active')->where('status','Available')->orderBy('name','ASC')->limit(8)->get();
       return response()->json([
                    'products'=>$products,
                    'status_code'=>'01'
                    ],200);
     
    }

    ////////////////////////////////////////


     public function send_otp(Request $req)
    {
        
            

           $user=Customers::where('phone',$req->mobile)->first();

           if($user)
        {
            //$otp = rand(1000, 9999);
            $otp='1111';
             // $response=Http::get('http://sms.erebs.in/api/sms_api.php?username=trac&api_password=9m82v925wrf&template_id=1207168616683035285&message=Hello '.$user->name.', your verification code is: '.$otp.'. Please enter this code to complete your shop registration. Thank you, Tool Rental Association for Care.&destination='.$req->mob.'&type=2&sender=TRACAP');

            return response()->json([
                    'otp'=>intval($otp),
                    'message'=>'Otp sent successfully',
                    'status_code'=>'01'
                    ],200);
        }
        else
        {
           return response()->json([
                    'message'=>'Invalid mobile number',
                    'status_code'=>'00'
                    ],400);
        }
        
    }

     public function reset_password(Request $req)
    {
        $user=Customers::where('phone',$req->mobile)->first();

           if($user)
        {
        
          Customers::where('phone',$req->mobile)->update([

            'password'=>bcrypt($req->password),

          ]);

           return response()->json([
                    'message'=>'Password changed successfully',
                    'status_code'=>'01'
                    ],200);
         }
         else
         {
            return response()->json([
                    'message'=>'Invalid mobile number',
                    'status_code'=>'00'
                    ],400);
         }  
        
    }




}