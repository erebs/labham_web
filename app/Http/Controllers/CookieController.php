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
use Illuminate\Http\Response;

use Auth;
use Session;

class CookieController extends Controller
{
     public function cart()
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
        
        $cart=temp_cart::where('uniqueid',$uid)->orderBy('id','DESC')->get();
        return view('frontend.tempcart',['cart'=>$cart]);
    }

    public function delete_cart(Request $req)
    {
        
           temp_cart::where('id',$req->cid)->delete();
            $data['success']='success';         
               
            echo json_encode($data);
    }

    public function plus_cart(Request $req)
    {
        
           temp_cart::where('id',$req->cid)->update([

            'quantity'=>$req->qty+1,

           ]);
            $data['success']='success';         
               
            echo json_encode($data);
    }

     public function minus_cart(Request $req)
    {
        
           temp_cart::where('id',$req->cid)->update([

            'quantity'=>$req->qty-1,

           ]);
            $data['success']='success';         
               
            echo json_encode($data);
    }
}
