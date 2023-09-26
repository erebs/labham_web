<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use Illuminate\Http\Response;

use Auth;
use Session;

class FrontendController extends Controller
{
    public function terms()
    {
        return view('frontend.terms');
    }

    public function mycart()
    {
        if(Auth::guard('member')->check())
        {
            return redirect()->route('member.cart');
        }
        else
        {
            return redirect()->route('default.cart');
        }
        
    }
    public function privacy_policy()
    {
        return view('frontend.privacy_policy');
    }
    public function faq()
    {
        return view('frontend.faq');
    }
    public function return_policy()
    {
        return view('frontend.return_policy');
    }
    public function about()
    {
        return view('frontend.aboutus');
    }
    public function contact()
    {
        return view('frontend.contactus');
    }
    public function products()
    {
        $prod=Products::where('delstatus','Active')->where('status','Available')->get();
         $banners = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
        return view('frontend.products',['prod'=>$prod,'banners'=>$banners]);
    }
     public function blog()
    {
        return view('frontend.blog');
    }

     public function popular_products()
    {
        $prod=Products::where('delstatus','Active')->where('status','Available')->where('best_seller', '1')->orderBy('id','DESC')->get();
        $banners = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
        return view('frontend.popular_products',['prod'=>$prod,'banners'=>$banners]);
    }

     public function featured_products()
    {
        $prod=Products::where('delstatus','Active')->where('status','Available')->where('featured', '1')->orderBy('id','DESC')->get();
        $banners = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
        return view('frontend.featured_products',['prod'=>$prod,'banners'=>$banners]);
    }

     public function trending_products()
    {
         $prod=Products::where('delstatus','Active')->where('status','Available')->where('trending', '1')->orderBy('id','DESC')->get();
         $banners = Banners::where('type', '2')->inRandomOrder()->limit(1)->first();
        return view('frontend.trending_products',['prod'=>$prod,'banners'=>$banners]);
    }


    public function home()
    {
           

          
        $cat=Category::where('status','Active')->orderBy('disporder','ASC')->limit(4)->get();
        $banners = Banners::where('type', '1')->orderBy('id', 'asc')->get();
        $pop=Products::where('delstatus','Active')->where('status','Available')->where('best_seller', '1')->orderBy('id','DESC')->limit(4)->get();
        $featured=Products::where('delstatus','Active')->where('status','Available')->where('featured', '1')->orderBy('id','DESC')->limit(4)->get();
        $trending=Products::where('delstatus','Active')->where('status','Available')->where('trending', '1')->orderBy('id','DESC')->limit(4)->get();
        return view('frontend.index',['cat'=>$cat,'banners'=>$banners,'pop'=>$pop,'featured'=>$featured,'trending'=>$trending]);
    }

    public function categories()
    {
        $cat=Category::where('status','Active')->orderBy('disporder','ASC')->get();
        return view('frontend.category',['cat'=>$cat]);
    }

    public function category_products($cid)
    {
        $catid=decrypt($cid);
        $cat=Category::select('name')->where('id',$catid)->first();
        $prod=Products::where('delstatus','Active')->where('status','Available')->where('cat_id', $catid)->get();
        return view('frontend.category_products',['prod'=>$prod,'cat'=>$cat]);
    }

     public function productsingle($cid)
    {
        $pid=decrypt($cid);
        $prod=Products::where('id',$pid)->first();
        $gal=product_gallery::where('product_id',$pid)->get();
        $vid=product_video::where('product_id',$pid)->get();
        $relprod=Products::where('delstatus','Active')->where('status','Available')->where('id','!=', $prod->id)->orderBy('id','DESC')->limit(4)->get();
        return view('frontend.productsingle',['prod'=>$prod,'relprod'=>$relprod,'gal'=>$gal,'vid'=>$vid]);
    }

     public function signin()
    {
        return view('frontend.login');
    }

    public function signup()
    {
        return view('frontend.signup');
    }


    public function user_signup(Request $req)
    {

        if(Customers::where('phone',$req->mobile)->exists())
        {
            $data['err']="Mobile number already exists";
        }
        else
        {
            Customers::create([

                'name'=>$req->name,
                'phone'=>$req->mobile,
                'password'=>bcrypt($req->pass)


            ]);
            $data['success']="Registration completed successfully";

         }
         echo json_encode($data);
       
    }


    public function user_signin(Request $req)
    {
        
        $uname=$req->mobile;
        $psw=$req->pass;

           if(Auth::guard('member')->attempt(['phone' => $uname, 'password' => $psw]))
                {
                    


                    $sessionVariableName = 'tempuser';

                if (Session::has($sessionVariableName)) {
                $sessionValue = Session::get($sessionVariableName);
                $tempcart=temp_cart::where('uniqueid',$sessionValue)->get();
                // $mycart=Cart::where('uniqueid',Auth::guard('member')->user()->id)->get();
                foreach($tempcart as $tm)
                    {
                        if(Cart::where('uniqueid',Auth::guard('member')->user()->id)->where('productid',$tm->productid)->exists())
                        {
                            $mycart=Cart::where('uniqueid',Auth::guard('member')->user()->id)->where('productid',$tm->productid)->first();
                            Cart::where('uniqueid',Auth::guard('member')->user()->id)->where('productid',$tm->productid)->update([

                                'quantity'=>$mycart->quantity+$tm->quantity,

                            ]);
                        }
                        else
                        {
                          Cart::create([

                            'uniqueid'=>Auth::guard('member')->user()->id,
                            'productid'=>$tm->productid,
                            'unitid'=>$tm->unitid,
                            'color_id'=>$tm->color_id,
                            'quantity'=>$tm->quantity,
                            'created_at'=>date('Y-m-d H:i:s')
                            ]);  
                        }

                        temp_cart::where('id',$tm->id)->delete();

                    }
                    $data['success']='Login success.Please wait...';
                }
                else
                {
                    $data['success']='Login success.Please wait...';
                }
                



                }
            else
                {
                    $data['err']='Invalid user !';
                }    
        

        echo json_encode($data);
    }









    public function profile()
    {
        $add=Address::where('user_id',auth()->guard('member')->user()->id)->where('status','Active')->orderBy('id','DESC')->get();
        $orders=Order::where('customerid',auth()->guard('member')->user()->id)->orderBy('order_on','DESC')->get();

        return view('frontend.profile',['add'=>$add,'orders'=>$orders]);
    }

     public function edit_profile(Request $req)
    {

           if(Customers::where('phone',$req->mobile)->where('id','!=',auth()->guard('member')->user()->id)->exists())
                {
                    $data['err']='Mobile number already exists';
                }
           else if(Customers::where('email',$req->mail)->where('id','!=',auth()->guard('member')->user()->id)->exists())
                {
                    $data['err1']='Mail Id already exists';
                }    
            else
                {
                    Customers::where('id',auth()->guard('member')->user()->id)->update([

                        'name'=>$req->name,
                        'phone'=>$req->mobile,
                        'email'=>$req->mail,

                    ]);
                    $data['success']='success';
                }    
        

        echo json_encode($data);
    }

    public function logout()
    {
        Auth::guard('member')->logout();
        return redirect()->route('home');
    }

     public function addaddress()
    {
        return view('frontend.addaddress');
    }

    public function address_add(Request $req)
    {

        if(Address::where('user_id',auth()->guard('member')->user()->id)->where('status','Active')->exists())
        {
            $default='0';
        }
        else
        {
          $default='1';  
        }

        Address::create([

                        'user_id'=>auth()->guard('member')->user()->id,
                        'default'=>$default,
                        'name'=>$req->name,
                        'mobile'=>$req->mobile,
                        'address'=>$req->address,
                        'district'=>$req->dist,
                        'state'=>$req->st,
                        'pincode'=>$req->pincode,
                        'landmark'=>$req->land,


                    ]);
                    $data['success']='success';
               
        echo json_encode($data);
    }

    public function def_address(Request $req)
    {


        Address::where('id',$req->aid)->update([

                        'default'=>'1',
                    ]);

        Address::where('user_id',auth()->guard('member')->user()->id)->where('id','!=',$req->aid)->update([

                        'default'=>'0',
                    ]);



                    $data['success']='success';
               
        echo json_encode($data);
    }

     public function editaddress($aid)
    {
        $adid=decrypt($aid);
        $add=Address::where('id',$adid)->first();
        return view('frontend.editaddress',['add'=>$add]);
    }

       public function address_edit(Request $req)
    {

        Address::where('id',$req->aid)->update([

                        'name'=>$req->name,
                        'mobile'=>$req->mobile,
                        'address'=>$req->address,
                        'district'=>$req->dist,
                        'state'=>$req->st,
                        'pincode'=>$req->pincode,
                        'landmark'=>$req->land,


                    ]);
                    $data['success']='success';
               
        echo json_encode($data);
    }

      public function delete_address(Request $req)
    {
        $chkdef=Address::where('id',$req->body)->first();
        if($chkdef->default=='1')
        {
           Address::where('id',$req->body)->update([

                        'status'=>'Deleted',
                    ]);
           $add=Address::where('user_id',auth()->guard('member')->user()->id)->where('status','Active')->orderBy('id','DESC')->limit(1)->first();
           Address::where('id',$add->id)->update([

                        'default'=>'1',
                    ]);
                    $data['success']='success'; 
        }

        else
        {
           Address::where('id',$req->body)->update([

                        'status'=>'Deleted',
                    ]);
            $data['success']='success';         
        }
        
               
        echo json_encode($data);
    }

    ////////////////


    public function cart()
    {
        $uid=auth()->guard('member')->user()->id;
        $cart=Cart::where('uniqueid',$uid)->orderBy('id','DESC')->get();
        return view('frontend.cart',['cart'=>$cart]);
    }

     public function get_cartcount()
    {
        if(Auth::guard('member')->check())
        {
            $uid=auth()->guard('member')->user()->id;
            $cart=Cart::where('uniqueid',$uid)->orderBy('id','DESC')->sum('quantity');
            echo $cart;
        }
        else
        {
                $sessionVariableName = 'tempuser';

                if (Session::has($sessionVariableName)) {
                $sessionValue = Session::get($sessionVariableName);
                }
                else
                {
                $sessionValue=time();
                Session::put($sessionVariableName,$sessionValue);  
                }
            
            $uid=$sessionValue;
            $cart=temp_cart::where('uniqueid',$uid)->orderBy('id','DESC')->sum('quantity');
            echo $cart;  
        }    


          
    }


      public function add_to_cart(Request $req)
    {

        if(Auth::guard('member')->check())
        {
            $uid=auth()->guard('member')->user()->id;
            $chk=Cart::where('uniqueid',$uid)->where('productid',$req->pid)->first();
            if($chk)
            {
                   Cart::where('uniqueid',$uid)->where('productid',$req->pid)->update([

                    'quantity'=>$chk->quantity+1,

                   ]);
                $data['success']='success'; 
            }

            else
            {
               Cart::create([

                            'uniqueid'=>$uid,
                            'productid'=>$req->pid,
                            'unitid'=>0,
                            'color_id'=>0,
                            'quantity'=>1,
                            'created_at'=>date('Y-m-d H:i:s')
                        ]);
                $data['success']='success';         
            }
        }
        else
        {
            $sessionVariableName = 'tempuser';

                if (Session::has($sessionVariableName)) {
                $sessionValue = Session::get($sessionVariableName);
                }
                else
                {
                $sessionValue=time();
                Session::put($sessionVariableName,$sessionValue);  
                }
            
            $uid=$sessionValue;
            $chk=temp_cart::where('uniqueid',$uid)->where('productid',$req->pid)->first();
            if($chk)
            {
                   temp_cart::where('uniqueid',$uid)->where('productid',$req->pid)->update([

                    'quantity'=>$chk->quantity+1,

                   ]);
                $data['success']='success'; 
            }

            else
            {
               temp_cart::create([

                            'uniqueid'=>$uid,
                            'productid'=>$req->pid,
                            'unitid'=>0,
                            'color_id'=>0,
                            'quantity'=>1,
                            'created_at'=>date('Y-m-d H:i:s')
                        ]);
                $data['success']='success';         
            }
               
     
        }

           echo json_encode($data);
    }

        public function add_cart(Request $req)
    {
        if(Auth::guard('member')->check())
        {
                $uid=auth()->guard('member')->user()->id;
                $chk=Cart::where('uniqueid',$uid)->where('productid',$req->pid)->first();
                if($chk)
                {
                       Cart::where('uniqueid',$uid)->where('productid',$req->pid)->update([

                        'quantity'=>$chk->quantity+$req->qty,

                       ]);
                    $data['success']='success'; 
                }

                else
                {
                   Cart::create([

                                'uniqueid'=>$uid,
                                'productid'=>$req->pid,
                                'unitid'=>0,
                                'color_id'=>0,
                                'quantity'=>$req->qty,
                                'created_at'=>date('Y-m-d H:i:s')
                            ]);
                    $data['success']='success';         
                }
        }
        else
        {

             $sessionVariableName = 'tempuser';

                if (Session::has($sessionVariableName)) {
                $sessionValue = Session::get($sessionVariableName);
                }
                else
                {
                $sessionValue=time();
                Session::put($sessionVariableName,$sessionValue);  
                }
            
            $uid=$sessionValue;
                $chk=temp_cart::where('uniqueid',$uid)->where('productid',$req->pid)->first();
                if($chk)
                {
                       temp_cart::where('uniqueid',$uid)->where('productid',$req->pid)->update([

                        'quantity'=>$chk->quantity+$req->qty,

                       ]);
                    $data['success']='success'; 
                }

                else
                {
                   temp_cart::create([

                                'uniqueid'=>$uid,
                                'productid'=>$req->pid,
                                'unitid'=>0,
                                'color_id'=>0,
                                'quantity'=>$req->qty,
                                'created_at'=>date('Y-m-d H:i:s')
                            ]);
                    $data['success']='success';         
                }

        }
        
               
        echo json_encode($data);
    }


     public function delete_cart(Request $req)
    {
        
           Cart::where('id',$req->cid)->delete();
            $data['success']='success';         
               
            echo json_encode($data);
    }

    public function plus_cart(Request $req)
    {
        
           Cart::where('id',$req->cid)->update([

            'quantity'=>$req->qty+1,

           ]);
            $data['success']='success';         
               
            echo json_encode($data);
    }

     public function minus_cart(Request $req)
    {
        
           Cart::where('id',$req->cid)->update([

            'quantity'=>$req->qty-1,

           ]);
            $data['success']='success';         
               
            echo json_encode($data);
    }


        public function checkout()
    {
        $uid=auth()->guard('member')->user()->id;
        $cart=Cart::where('uniqueid',$uid)->orderBy('id','DESC')->get();
        $bank=bank_detail::where('id',1)->first();
        $addresses=Address::where('user_id',$uid)->where('status','Active')->orderBy('id','DESC')->get();
        return view('frontend.checkout',['cart'=>$cart,'addresses'=>$addresses,'bank'=>$bank]);
    }

      public function placeorder(Request $req)
    {
        $uid=auth()->guard('member')->user()->id;
        $cart=Cart::where('uniqueid',$uid)->orderBy('id','DESC')->get();

        $order=Order::create([

                'customerid'=>auth()->guard('member')->user()->id,
                'addressid'=>$req->address,
                'paytype'=>$req->paytype,
                'paymentid'=>$req->refid,
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

        $data['success']="success";
        echo json_encode($data);
    }

     public function return_img(Request $req)
    {
        $img = $req->file('img');

        if($img=='')
        {
            $new_name="";
        }
        else{
          $image = $req->file('img');
             $new_name = "return_img/" . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('return_img'), $new_name);
        }


       return_image::create([

        'orderid'=>$req->oid,
        'image'=>$new_name,

       ]);   

       $data['success']='Success';
       echo json_encode($data);  
    }

      public function del_image(Request $req)
    {


        return_image::where('id',$req->aid)->delete();


                    $data['success']='success';
               
        echo json_encode($data);
    }

    public function return_order(Request $req)
    {


        Order::where('id',$req->aid)->update([

            'return_status'=>'Return Requested',
            'return_det'=>$req->retdet

        ]);


                    $data['success']='success';
               
        echo json_encode($data);
    }

    public function cancel_order(Request $req)
    {


        Order::where('id',$req->body)->update([

            'status'=>'Cancelled',
           

        ]);


        $data['success']='success';
               
        echo json_encode($data);
    }



    public function get_prod(Request $req)
    {
        $prod = $req->prod;
       $products = Products::where('name', 'like', '%' . $prod . '%')->where('delstatus','Active')->where('status','Available')->orderBy('name','ASC')->limit(8)->get();
     
   
            $output = '';

           if(sizeof($products))
           {
           
            foreach($products as $p)
            {
             
                $img=url($p->image);
                $enid=encrypt($p->id);

                $output .= '
               
            <a href="/v1/productsingle/'.$enid.'" style="text-decoration:none;color:black;"><h6 class="suggestion-name"><img class="suggestion-img" style="width:30px;border-radius:10px;" src='.$img.'> &nbsp&nbsp <a href="/v1/productsingle/'.$enid.'" style="text-decoration:none;color:black;">'.$p->name.'</a></h6></a>
                    <hr>
               ';

            }
            }
            
        
            
            echo $output;
    }



            public function forgot_password()
    {
        return view('frontend.forgot_password');
    }

     public function send_otp(Request $req)
    {
        
            //$otp = rand(1000, 9999);
        $otp='1111';

           $user=Customers::where('phone',$req->mobile)->first();

           if($user)
        {
             // $response=Http::get('http://sms.erebs.in/api/sms_api.php?username=trac&api_password=9m82v925wrf&template_id=1207168616683035285&message=Hello '.$user->name.', your verification code is: '.$otp.'. Please enter this code to complete your shop registration. Thank you, Tool Rental Association for Care.&destination='.$req->mob.'&type=2&sender=TRACAP');
            return intval($otp);
        }
        else
        {
            echo "1";
        }
        
    }

    public function password_reset(Request $req)
    {
        
          Customers::where('phone',$req->mobile)->update([

            'password'=>bcrypt($req->pass),

          ]);

          $data['success']='success';
          echo json_encode($data);
        
    }





}
