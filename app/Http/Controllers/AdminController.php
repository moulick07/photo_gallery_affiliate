<?php

namespace App\Http\Controllers;

use App\Notifications\DeleteImage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\AdminWallet;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\Image;

use DataTables;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $req)
    {
        if ($req->ajax()) {
            $sharks = User::with('images')->get();
            return Datatables::of($sharks)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        $amounts = DB::table('admin_wallets')->get();

        // load the view and pass the sharks

        return View('home')->with('amounts', $amounts);
    }
    public function search(Request $request)
    {
        if (request('search')) {
            $sharks = User::where('name', 'like', '%' . request('search') . '%')->get();
        } else {
            $sharks = User::all();
        }
        return view('search')->with('sharks', $sharks);
    }
    public function settings()
    {
        // $sharks = User::all();

        // load the view and pass the sharks

        return View('settings');
    }


    public function change(Request $request)
    {
        $posts = DB::table('admin_wallets')->get();
        $admin_update = DB::table('admin_wallets')->update(array('add_photo_coin' => $request->add_photo_coin, 'reference_coin' => $request->reference_coin));
        // dd($admin_update); 
        
        return response()->json(['message' => 'successfully uploaded image'],200);
    }
    public function update(Request $request, $id)
    {

        // dd($data);
        //  $postdata = ['add_data_coin' => $request->add_data_coin ,'reference_coin' => $request->reference_coin];
        // $data->update($postdata);
        return redirect('home');

    }
    public function transact(Request $request)
    {
        $wallet = Wallet::with('user')->get();
        // dd(auth::id());
        if ($request->ajax()) {
            $users = Transaction::with('user')

                ->where(function ($query) use ($request) {
                    if (Auth::user()->user_type == NULL) {
                        $query->where('user_id', '=', Auth::id());
                    }
                })->get();
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->editColumn('user_id', function ($users) {

                    return $users->user->name;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transact')->with('wallet', $wallet);
    }
    public function imagepage()
    {
        $images = Image::with('user')->paginate(10);
        return view('AdminImageView')->with('images', $images);
    }

    public function imageDelete($id)
    {
        $post = Image::find($id);
        $user = User::findOrFail($post->user_id);
        \Storage::delete(public_path('/images/' . $post->image));

        $sucess = $post->delete();
        if ($sucess) {

            // dd($post->public_path('/images/')),    
            //  dd($post);

            \Notification::send($user, new DeleteImage($post));
            
        }
        $images = Image::with('user')->paginate(10);

        return redirect('imageview')->with('images', $images)->with(['message' => 'photo deleted successfully!', 'status' => 'info']);
    }
}