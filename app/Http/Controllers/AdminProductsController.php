<?php

namespace App\Http\Controllers;

use File;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\ExportProduct;
use App\Products;
use App\Category;
use App\ProductUnits;
use App\SubCategory;
use App\product_gallery;
use App\product_video;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminProductsController extends Controller
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
    
    
    $products = Products::where('delstatus','Active')->orderBy('name','ASC')->get();


    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Products',
      'products' => $products,

    ];

    return view('admin.products.index')->with($data);
  }


  public function create()
  {
    $category = Category::where('status','Active')->orderBy('disporder', 'asc')->pluck('name', 'id');
    $subcategory = SubCategory::where('status','Active')->pluck('name', 'id');

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Products',
      'contentSubHeader' => 'Add Product',
      'category' => $category,
      'subcategory' => $subcategory
    ];

    return view('admin.products.create')->with($data);
  }


  public function store(Request $request)
  {
    $ihd = date('ihd');
    $image = $image2 = $image3 = $image4 = '';
    $slugname = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $request->input('name')));

    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'.'.$extension);
      $image = 'uploads/products/' . $slugname.$ihd.'.' .$extension;
    }

    if($request->hasFile('image2')) {
      $getimage = $request->file('image2');
      $extension = $request->file('image2')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'2.'.$extension);
      $image2 = 'uploads/products/' . $slugname.$ihd.'2.' .$extension;
    }

    if($request->hasFile('image3')) {
      $getimage = $request->file('image3');
      $extension = $request->file('image3')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'3.'.$extension);
      $image3 = 'uploads/products/' . $slugname.$ihd.'3.' .$extension;
    }

    if($request->hasFile('image4')) {
      $getimage = $request->file('image4');
      $extension = $request->file('image4')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'4.'.$extension);
      $image4 = 'uploads/products/' . $slugname.$ihd.'4.' .$extension;
    }

    $products = new Products();
    $products->cat_id = $request->input('cat_id') ?? '0';
    $products->subcat_id = $request->input('subcat_id') ?? '0';
    $products->name = $request->input('name') ?? '';
    $products->desc = $request->input('desc') ?? '';
    $products->price = $request->input('price') ?? '0';
    $products->offerprice = $request->input('offerprice') ?? '0';
    $products->best_seller = $request->input('best_seller') ?? '0';
    $products->featured = $request->input('featured') ?? '0';
    $products->trending = $request->input('trending') ?? '0';
    $products->status = $request->input('status') ?? '';
    $products->image = $image ?? '';
    $products->image2 = $image2 ?? '';
    $products->image3 = $image3 ?? '';
    $products->image4 = $image4 ?? '';
    $products->delstatus = 'Active';
    $products->save();

    return redirect('/admin/products')->with('success', 'Product Added');
  }


  public function show($id)
  {
    $product = Products::find($id);
    $category = Category::pluck('name', 'id');
    $subcategory = SubCategory::pluck('name', 'id');

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Products',
      'contentSubHeader' => 'Edit Product',
      'product' => $product,
      'category' => $category ?? '',
      'subcategory' => $subcategory
    ];

    return view('admin.products.edit')->with($data);
  }


  public function update(Request $request, $id)
  {
    $ihd = date('ihd');
    $image = $image2 = $image3 = $image4 = '';
    $slugname = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $request->input('name')));


    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'.'.$extension);
      $image = 'uploads/products/' .$slugname.$ihd.'.' .$extension;
    }

    if($request->hasFile('image2')) {
      $getimage = $request->file('image2');
      $extension = $request->file('image2')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'2.'.$extension);
      $image2 = 'uploads/products/' . $slugname.$ihd.'2.' .$extension;
    }

    if($request->hasFile('image3')) {
      $getimage = $request->file('image3');
      $extension = $request->file('image3')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'3.'.$extension);
      $image3 = 'uploads/products/' . $slugname.$ihd.'3.' .$extension;
    }

    if($request->hasFile('image4')) {
      $getimage = $request->file('image4');
      $extension = $request->file('image4')->getClientOriginalExtension();
      $path = 'uploads/products/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $slugname.$ihd.'4.'.$extension);
      $image4 = 'uploads/products/' . $slugname.$ihd.'4.' .$extension;
    }

    $products = Products::find($id);
    $products->cat_id = $request->input('cat_id') ?? '0';
    $products->subcat_id = $request->input('subcat_id') ?? '0';
    $products->name = $request->input('name') ?? '';
    $products->desc = $request->input('desc') ?? '';
    $products->price = $request->input('price') ?? '0';
    $products->offerprice = $request->input('offerprice') ?? '0';
    $products->best_seller = $request->input('best_seller') ?? '0';
    $products->featured = $request->input('featured') ?? '0';
    $products->trending = $request->input('trending') ?? '0';
    $products->status = $request->input('status') ?? '';
    $products->image = ($image ? $image : $request->input('imageOld')) ?? '';
    $products->image2 = ($image2 ? $image2 : $request->input('imageOld2')) ?? '';
    $products->image3 = ($image3 ? $image3 : $request->input('imageOld3')) ?? '';
    $products->image4 = ($image4 ? $image4 : $request->input('imageOld4')) ?? '';
    $products->save();

    return redirect('/admin/products')->with('success', 'Product Updated');
  }

  public function destroy($id)
  {
    // ProductUnits::where('productid', $id)->delete();
    Products::where('id', $id)->update([

      'delstatus'=>'Inactive'

    ]);
    return redirect('/admin/products')->with('success', 'Product Deleted');
  }


  public function unitsList($id)
  {
    $product = Products::find($id);
    $units = ProductUnits::where('productid', $id)->orderBy('disp_order', 'asc')->get();
    $disporder = ProductUnits::where('productid', $id)->max('disp_order');

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Products',
      'contentSubHeader' => 'Product Units',
      'product' => $product,
      'units' => $units ?? [],
      'productid' => $id,
      'disporder' => ($disporder > 0) ? $disporder + 1 : '1'
    ];

    return view('admin.products.units')->with($data);
  }

  public function unitSave(Request $request, $id) {
    $units = new ProductUnits();
    $units->productid = $request->input('productid') ?? '0';
    $units->name = $request->input('name') ?? '';
    $units->price = $request->input('price') ?? '0';
    $units->offerprice = $request->input('offerprice') ?? '0';
    $units->disp_order = $request->input('disp_order') ?? '1';
    $units->save();

    return redirect('/admin/products/units/'.$id)->with('success', 'Product Unit Added');
  }

  public function unitUpdate(Request $request, $id) {
    $units = ProductUnits::find($request->input('eid'));
    $units->name = $request->input('name') ?? '';
    $units->price = $request->input('price') ?? '0';
    $units->offerprice = $request->input('offerprice') ?? '0';
    $units->disp_order = $request->input('disp_order') ?? '1';
    $units->save();

    return redirect('/admin/products/units/'.$id)->with('success', 'Product Unit Updated');
  }

  public function unitDelete(Request $request, $id) {
    ProductUnits::where('id', $request->input('did'))->delete();
    return redirect('/admin/products/units/'.$id)->with('success', 'Product Unit Deleted');
  }

  public static function getUnits($productid) {
    return ProductUnits::where('productid', $productid)->orderBy('disp_order', 'asc')->get();
  }

  public static function getProduct($id)
  {
    return Products::where('id', $id)->first();
  }

  public static function getName($id)
  {
    return Products::where('id', $id)->value('name');
  }

  public static function getUnitName($id)
  {
    return ProductUnits::where('id', $id)->value('name');
  }

  public static function getUnit($id)
  {
    return ProductUnits::where('id', $id)->first();
  }

  public function stockUpdate(Request $request)
  {
    if($request->input('type') == 'Add') {
      $products = Products::find($request->input('productid'));
      $stock_avalible = $products->stock_avalible;
      $stock_avalible = $stock_avalible + $request->input('stock_avalible');
      $products->stock_avalible = $stock_avalible;
      $products->save();
    } else {
      $products = Products::find($request->input('productid'));
      $stock_avalible = $products->stock_avalible;
      $stock_avalible = $stock_avalible - $request->input('stock_avalible');
      if($stock_avalible < 0) {
        $stock_avalible = 0;
      }
      $products->stock_avalible = $stock_avalible;
      $products->save();
    }

    return redirect('/admin/products')->with('success', 'Product Stock Updated');
  }



function import(Request $request)
    {
     

        Excel::import(new UsersImport, $request->file('file')->store('temp'));
        return back();

     
    }
    public function export() 
    {
       
        return Excel::download(new ExportProduct, 'products.csv', \Maatwebsite\Excel\Excel::CSV);
    ob_end_clean();
    }



      public function product_gallery($id)
  {
    $gal = product_gallery::where('product_id',$id)->latest()->get();

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Gallery',
      'contentSubHeader' => 'Product Gallery',
      'gal' => $gal,
      'pid'=>$id
    ];

    return view('admin.products.gallery')->with($data);
  }

   public function prod_gallery_create(Request $request)
  {
    $image = '';
    $name = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name'));
    
    if($request->hasFile('image')) {
      $getimage = $request->file('image');
      $extension = $request->file('image')->getClientOriginalExtension();
      $path = public_path(). '/uploads/product_gallery/';
      File::makeDirectory($path, $mode = 0777, true, true);
      $getimage->move($path, $name.'.'.$extension);
      $image = '/uploads/product_gallery/' .$name. '.' .$extension;
    }

    $category = new product_gallery();
    $category->product_id = $request->input('pid');
    $category->title = $request->input('name');
    $category->image = $image ?? '';
    $category->save();

    return redirect('/admin/product-gallery/'.$request->input('pid'))->with('success', 'Added successfully');
  }

   public function prod_gallery_delete($id,$pid)
  {
    product_gallery::where('id', $id)->delete();
    return redirect('/admin/product-gallery/'.$pid)->with('success', 'Deleted successfully');
  }


        public function product_videos($id)
  {
    $vid = product_video::where('product_id',$id)->latest()->get();

    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Videos',
      'contentSubHeader' => 'Product Videos',
      'vid' => $vid,
      'pid'=>$id
    ];

    return view('admin.products.videos')->with($data);
  }

   public function prod_video_create(Request $request)
  {
  

    $category = new product_video();
    $category->product_id = $request->input('pid');
    $category->title = $request->input('name');
    $category->url = $request->input('url');
    $category->save();

    return redirect('/admin/product-videos/'.$request->input('pid'))->with('success', 'Added successfully');
  }

   public function prod_video_delete($id,$pid)
  {
    product_video::where('id', $id)->delete();
    return redirect('/admin/product-videos/'.$pid)->with('success', 'Deleted successfully');
  }











}



