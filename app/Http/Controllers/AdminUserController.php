<?php

namespace App\Http\Controllers;

use Session;

use App\User;
use App\Amount;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminUserController extends Controller
{

  public function __construct(Request $request, Redirector $redirect)
  {
    $this->middleware(function ($request, $next) {
      if (!Auth::id()) {
        return redirect('/admin/login');
      }
      return $next($request);
    });

    $this->statusArr = ['1' => 'Active', '2' => 'Inactive', '3' => 'Suspended'];
  }


  public function index()
  {
    $issuperadmin = 0;
    if (Session::has('issuperadmin')) {
      $issuperadmin = 1;
    }

    $status = $_GET['s'] ?? '';
    $search = $_GET['q'] ?? '';
    $slimit = $_GET['slimit'] ?? '10';

    $users = User::orderBy('id', 'desc')->where('type', '2')->where('added_by', Auth::id());
    if(isset($status) && $status != '' && $status != 'All') {
      $users = $users->where('status', $status);
    }

    if(isset($search) && $search != '') {
      $users = $users->where(function ($query) use ($search) {
        $query->where('name', 'like', "%{$search}%")
          ->Orwhere('email', 'like', "%{$search}%");
      });
    }
    $users = $users->paginate($slimit);

    $data = [
      'authuser' => Auth::user(),
      'users'  => $users,
      'contentHeader' => 'Distributors',
      'statusArr' => $this->statusArr,
      'status' => $status,
      'search' => $search,
      'slimit' => $slimit,
      'issuperadmin' => $issuperadmin
    ];

    return view('admin.user.index')->with($data);
  }


  public function create()
  {
    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Distributors',
      'contentSubHeader' => 'Add Distributors',
      'statusArr' => $this->statusArr,
    ];

    return view('admin.user.create')->with($data);
  }

  public function store(Request $request)
  {
    $user = new User();
    $user->type = '2';
    $user->name = $request->input('name') ?? '';
    $user->email = strtolower($request->input('email')) ?? '';
    $user->password = md5($request->input('password'));
    $user->phone = $request->input('phone') ?? '';
    $user->phone2 = $request->input('phone2') ?? '';
    $user->added_by = Auth::id();
    $user->balence = $request->input('balence') ?? '0';
    $user->comm_type = $request->input('comm_type') ?? 'flat';
    $user->commission = $request->input('commission') ?? '0';
    $user->comm_plan = $request->input('comm_plan') ?? '0';
    $user->status = $request->input('status') ?? '1';
    $user->created_at = date('Y-m-d H:i:00');
    $user->updated_at = date('Y-m-d H:i:00');
    $user->save();

    $amount = new Amount();
    $amount->user_id = $user->id;
    $amount->user_type = $request->input('type') ?? '2';
    $amount->added_by = Auth::id();
    $amount->amount = $request->input('balence') ?? '0';
    $amount->created_at = date('Y-m-d H:i:00');
    $amount->updated_at = date('Y-m-d H:i:00');
    $amount->save();


   return redirect('/admin/user')->with('success', 'Distributor Added');
  }

  public function show($id)
  {
    $user = User::find($id);
    $data = [
      'authuser' => Auth::user(),
      'contentHeader' => 'Distributors',
      'contentSubHeader' => 'Edit Distributors',
      'statusArr' => $this->statusArr,
      'user' => $user
    ];

    return view('admin.user.edit')->with($data);
  }

  public function update(Request $request, $id)
  {
    $user = User::find($id);
    $user->type = '2';
    $user->name = $request->input('name') ?? '';
    $user->email = strtolower($request->input('email')) ?? '';
    $user->phone = $request->input('phone') ?? '';
    $user->phone2 = $request->input('phone2') ?? '';
    // $user->balence = $request->input('balence') ?? '0';
    $user->comm_type = $request->input('comm_type') ?? 'flat';
    $user->commission = $request->input('commission') ?? '0';
    $user->comm_plan = $request->input('comm_plan') ?? '0';
    $user->status = $request->input('status') ?? '1';
    $user->updated_at = date('Y-m-d H:i:00');
    $user->save();

    return redirect('/admin/user')->with('success', 'Distributor Updated');
  }


  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();

    return redirect('/admin/user')->with('success', 'Distributor Removed');
  }


  public static function getUserName($id)
  {
    return User::where('id', $id)->value('name');
  }


  public function change(Request $request)
  {
    $user = User::find($request->input('user_id'));
    $user->password = md5($request->input('password'));
    $user->save();

    return redirect('/admin/user')->with('success', 'Distributor Password Updated');
  }



  public function addAmount(Request $request)
  {
    $amount = new Amount();
    $amount->user_id = $request->input('user_id');
    $amount->user_type = $request->input('user_type');
    $amount->added_by = Auth::id();
    $amount->amount_type = 'Credit';
    $amount->amount = $request->input('amount');
    $amount->created_at = date('Y-m-d H:i:00');
    $amount->updated_at = date('Y-m-d H:i:00');
    $amount->save();

    $user = User::find($request->input('user_id'));
    $balence = $user->balence;
    $user->balence = $balence + $request->input('amount');
    $user->save();

    return redirect('/admin/user')->with('success', 'Distributor Amount Added');
  }

 
  public static function getCredit()
  {
    $date = date('Y-m-d').' 00:00:00';
    $Arr1 = [['user_type', '2'],['user_id', '=', Auth::id()],['created_at', '>=', $date],['amount_type','=', 'Credit']];
    $Arr2 = [['user_type', '2'],['user_id', '=', Auth::id()],['created_at', '>=', $date],['amount_type','=', 'Debit']];

    $credit = Amount::where($Arr1)->sum('amount');
    $debit = Amount::where($Arr2)->sum('amount');
    return round($credit - $debit, 2);
  }

  public static function getDebit()
  {
    $date = date('Y-m-d').' 00:00:00';
    $Arr1 = [['user_type', '3'],['added_by', '=', Auth::id()],['created_at', '>=', $date],['amount_type','=', 'Credit']];
    $Arr2 = [['user_type', '3'],['added_by', '=', Auth::id()],['created_at', '>=', $date],['amount_type','=', 'Debit']];

    $credit = Amount::where($Arr1)->sum('amount');
    $debit = Amount::where($Arr2)->sum('amount');
    return round($credit - $debit, 2);
  }

  public static function getBalence()
  {
    $Arr1 = [['user_type', '2'],['user_id', '=', Auth::id()],['amount_type','=', 'Credit']];
    $Arr2 = [['user_type', '2'],['user_id', '=', Auth::id()],['amount_type','=', 'Debit']];
    $credit = Amount::where($Arr1)->sum('amount');
    $debit = Amount::where($Arr2)->sum('amount');
    $creditamt = $credit - $debit;

    $Arr1 = [['user_type', '3'],['added_by', '=', Auth::id()],['amount_type','=', 'Credit']];
    $Arr2 = [['user_type', '3'],['added_by', '=', Auth::id()],['amount_type','=', 'Debit']];
    $credit = Amount::where($Arr1)->sum('amount');
    $debit = Amount::where($Arr2)->sum('amount');
    $debitamt = $credit - $debit;
    return round($creditamt - $debitamt, 2);
  }

  public static function getBalenceForAdmin($id)
  {
    $Arr1 = [['user_type', '2'],['user_id', '=', $id],['amount_type','=', 'Credit']];
    $Arr2 = [['user_type', '2'],['user_id', '=', $id],['amount_type','=', 'Debit']];
    $credit = Amount::where($Arr1)->sum('amount');
    $debit = Amount::where($Arr2)->sum('amount');
    $creditamt = $credit - $debit;

    $Arr1 = [['user_type', '3'],['added_by', '=', $id],['amount_type','=', 'Credit']];
    $Arr2 = [['user_type', '3'],['added_by', '=', $id],['amount_type','=', 'Debit']];

    $credit = Amount::where($Arr1)->sum('amount');
    $debit = Amount::where($Arr2)->sum('amount');
    $debitamt = $credit - $debit;
    return round($creditamt - $debitamt, 2);
  }
}
