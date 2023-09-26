<?php

namespace App\Http\Controllers;
use File;

use App\Banners;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminBannerController extends Controller
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
  

  public function listFirst()
  {
    $banners = Banners::where('type', '1')->orderBy('id', 'asc')->get();
    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Banners',
      'contentSubHeader' => 'First Banners',
      'banners'  => $banners,
    ];
    return view('admin.banner.first')->with($data);
  }


  public function listSecond()
  {
    $banners = Banners::where('type', '2')->orderBy('id', 'asc')->get();
    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Banners',
      'contentSubHeader' => 'Middle Banner',
      'banners'  => $banners,
    ];
    return view('admin.banner.second')->with($data);
  }


  public function listThird()
  {
    $banners = Banners::where('type', '3')->orderBy('id', 'asc')->get();
    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Banners',
      'contentSubHeader' => 'Slider Banners(Mobile)',
      'banners'  => $banners,
    ];
    return view('admin.banner.third')->with($data);
  }

  public function listFourth()
  {
    $banners = Banners::where('type', '4')->orderBy('id', 'asc')->get();
    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Banners',
      'contentSubHeader' => 'Footer Banners',
      'banners'  => $banners,
    ];
    return view('admin.banner.fourth')->with($data);
  }

  public function create(Request $request)
  {
    $image = '';
    $redi = $request->input('redi') ?? 'first';
    $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name'));
    
    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = public_path(). '/uploads/banners/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $name.'_'.$request->input('type').'.'.$extension);
      $image = '/uploads/banners/' .$name.'_'.$request->input('type'). '.' .$extension;
    }

    $banner = new Banners();
    $banner->type = $request->input('type') ?? '1';
    $banner->name = $request->input('name') ?? '';
    $banner->image = $image ?? '';
    $banner->url = $request->input('url') ?? '';
    $banner->save();

    return redirect('/admin/banners/'.$redi)->with('success', 'New Banner Created');
  }


  public function update(Request $request)
  {
    $image = '';
    $redi = $request->input('redi') ?? 'first';
    $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name'));
    
    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = public_path(). '/uploads/banners/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $name.'_'.$request->input('type').'.'.$extension);
      $image = '/uploads/banners/' .$name.'_'.$request->input('type'). '.' .$extension;
    }

    $banner = Banners::find($request->input('id'));
    $banner->type = $request->input('type') ?? '1';
    $banner->name = $request->input('name') ?? '';
    $banner->url = $request->input('url') ?? '';
    $banner->image = ($image ? $image : $request->input('imageOld')) ?? '';
    $banner->save();

    return redirect('/admin/banners/'.$redi)->with('success', 'Banner Updated');
  }


  public function destroy($type, $id)
  {
    $banner = Banners::findOrFail($id);
    $banner->delete();

    return redirect('/admin/banners/'.$type)->with('success', 'Banner Removed');
  }
}
