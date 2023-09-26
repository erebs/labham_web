<?php

namespace App\Http\Controllers;

use File;

use App\Brands;
use App\Products;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminBrandsController extends Controller
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
    $no = 0;
    $page = $request->input('page') ?? 1;
    $page = $page - 1;
    if(isset($page)) { $no = $page * 10; }
    $search = $request->input('search') ?? '';

    $brands = Brands::orderBy('disp_order', 'asc');
    if(isset($search) && $search != '') {
      $brands = $brands->where('name', 'like', "%{$search}%");
    }
    $brands = $brands->paginate(10);
    $disp_order = Brands::max('disp_order');

    $data = [
      'authuser' => Auth::user(),
      'brands'  => $brands,
      'contentHeader' => 'Brands',
      'search' => $search,
      'disp_order' => ($disp_order > 0) ? $disp_order + 1 : '1',
      'no' => $no
    ];

    return view('admin.brands.index')->with($data);
  }


  public function create(Request $request)
  {
    $image = '';
    $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name'));
    
    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = public_path(). '/uploads/brands/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $name.'.'.$extension);
      $image = '/uploads/brands/' .$name. '.' .$extension;
    }

    $brands = new Brands();
    $brands->name = $request->input('name');
    $brands->disp_order = $request->input('disp_order') ?? '1';
    $brands->image = $image ?? '';
    $brands->save();

    return redirect('/admin/brands')->with('success', 'New Brand Created');
  }


  public function update(Request $request)
  {
    $image = '';
    $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name'));
    
    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = public_path(). '/uploads/brands/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $name.'.'.$extension);
      $image = '/uploads/brands/' .$name. '.' .$extension;
    }

    $brands = Brands::find($request->input('id'));
    $brands->name = $request->input('name');
    $brands->disp_order = $request->input('disp_order') ?? '1';
    $brands->image = ($image ? $image : $request->input('imageOld')) ?? '';
    $brands->save();

    return redirect('/admin/brands')->with('success', 'Brands Updated');
  }


  public function destroy($id)
  {
    $category = Brands::find($id);
    $category->delete();

    return redirect('/admin/brands')->with('success', 'Brands Deleted');
  }


  public static function countProducts($id)
  {
    return Products::where('brand_id', $id)->count();
  }

}
