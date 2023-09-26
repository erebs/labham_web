<?php

namespace App\Http\Controllers;

use App\Notifications;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class AdminNotificationController extends Controller
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


  public function index()
  {
    $search = $_GET['q'] ?? '';

    $notifications = Notifications::orderBy('id', 'desc');
    if(isset($search) && $search != '') {
      $notifications = $notifications->where('title', 'like', "%{$search}%");
    }
    $notifications = $notifications->paginate(10);

    $data = [
      'authuser' => Auth::user(),
      'notifications'  => $notifications,
      'contentHeader' => 'Notifications',
      'search' => $search
    ];

    return view('admin.notifications')->with($data);
  }


  public function create(Request $req)
  {
    $notifications = new Notifications();
    $notifications->title = $req->input('heading') ?? '';
    $notifications->sub_title = $req->input('sub_heading') ?? '';
    $notifications->url = $req->input('url') ?? '';
    $notifications->created_at = date('Y-m-d H:i:00');
    $notifications->save();

    // $this->pushMessage($req->input('sub_heading'), 'global', $req->input('heading'));


    return redirect('/admin/notifications')->with('success', 'New Notifications Created');
  }


  public function pushMessage($message = '', $topics = 'global', $title = ''){
    $msgdata = array (
        "message" => $message,
        "title" => $title
    );
    $data = json_encode($msgdata);
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array (
        'to' => '/topics/'.$topics,
        'data' => ["data" => $data]
    );
    $fields = json_encode ( $fields );
    $headers = array (
        'Authorization: key=' . "AAAACTR6bJs:APA91bFCYM2_1sDWWxC30Y4aQmx2GNu1aztCFuEdKdHCnEf6Lpy8apLReebkl-D1AyPxgICF7GB-tX3HjreEDOOEJrU_T07sYJWNsnjPtcb1y8Q1fs77hp2Yr_clLS-jrUTKxu2Efx9s",
        'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    curl_close ( $ch );
  }


  public function destroy($id)
  {
    $notifications = Notifications::find($id);
    $notifications->delete();

    return redirect('/admin/notifications')->with('success', 'Notifications Deleted');
  }


  public static function getCount()
  {
    return Notifications::where('created_at', '>', date('Y-m-d'.' 00:00:00'))->count();
  }


}
