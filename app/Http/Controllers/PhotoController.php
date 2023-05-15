<?php

namespace App\Http\Controllers;

use App\Notifications\CreatePhoto;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\download;
// use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;



use Auth;

class PhotoController extends Controller
{
  // this function wil run in single route for sorting the data acording to price high low and sorting with title
  public function index(Request $request)
  {
   
    $posts = Image::with('user')
     
      ->orderBy($request->columname ?? 'created_at', $request->sort ?? 'DESC')->paginate(12);

   
    $wallet = Wallet::with('user')->get();
    $transactions = Transaction::with('user')->get();
   
    return view('welcome')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);
  }
  public function create()
  {
    $wallet = Wallet::with('user')->get();
    $transactions = Transaction::with('user')->get();
    return view('create')->with('wallet', $wallet)->with('transactions', $transactions);
  }

  /*
  |--------------------------------------------------------------------------
  | store function 
  |--------------------------------------------------------------------------
  |
  | this function will store the image with affecting the wallet balance 
  | if the user has wallet then wallet will be update with new balance 
  | else it will create wallet because user might now have not credited any refernece or photo upload bonus
  |
  */
  public function store(UserStoreRequest $request)
  {

  
    $image = $request['image'];
   

    for ($i = 0; $i < count($image); $i++) {

     
      $imageName = time() . '.' . $image[$i]['file']->extension();
      # code...
      // print($image[$i]);
      $postData = ['title' => $image[$i]['title'], 'tags' => $image[$i]['tag'], 'price' => $image[$i]['price'], 'imagename' => $imageName, 'user_id' => Auth::id()];
      $saveimagepath = $image[$i]['file']->move(public_path('images/'), $imageName);
      $imagecreate = Image::create($postData);





    $user = User::findOrFail($imagecreate->user_id);

      if ($imagecreate) {
        \Notification::send($user, new CreatePhoto($image));
        if (Wallet::where('user_id', auth::user()->id)->first()) {
          $photo_price = DB::table('admin_wallets')->get();
        

          foreach ($photo_price as $key => $value) {
            $addcoin = $value->add_photo_coin;

          }
          $id = auth::user()->id;

          $wallettable = DB::table('wallets')->get();
          foreach ($wallettable as $key => $value) {
            $addcoins = $value->balance;
          }
         
          $users = Wallet::where('user_id', auth::user()->id)->first();
          $current_balance = $users->balance;
          // dd($users->balance);
          // $users = DB::table('wallets')->where('user_id', $id);
          // dd($users);
          $wallet = $users->update(['balance' => $current_balance + $addcoin]);
        } else {
          $photo_price = DB::table('admin_wallets')->get();
          // dd($photo_price);

          foreach ($photo_price as $key => $value) {
            $addcoin = $value->add_photo_coin;

          }
          $postData = ['balance' => $addcoin, 'user_id' => auth::id()];
          $wallet = Wallet::create($postData);

        }

      }
      // dd($wallet);
    }

    $posts = Image::with('user')->paginate(4);
   
    return response()->json(['success'=> true,'message' => 'successfully uploaded image'], 200);


  }
  public function show(Request $request, $id)
  {
    // dd("sdfsdf");
    $posts = DB::table('images')->where('id', $id)->get();
    $wallet = Image::with('user')->get();
    return view('show')->with('posts', $posts)->with('wallet',$wallet);
  }
  public function edit($id)
  {
    $posts = DB::table('images')->where('id', $id)->get();

    return view('edit')->with('posts', $posts);
  }
  public function update(Request $request, $id)
  {
    $posts = Image::find($id);
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = time() . '.' . $request->file->extension();
      $image->move(public_path('images/'), $imageName);
      $image = $request->file('image')->getClientOriginalName();

      $postData = ['title' => $request->title, 'price' => $request->price, 'tags' => $request->tags, 'imagename' => $imageName, 'user_id' => Auth::id()];

      $posts->update($postData);
    }
    return redirect('/')->with(['message' => 'photo updated successfully!', 'status' => 'info']);
  }


  public function destroy($id)
  {
    $post = Image::find($id);
    Storage::delete('/images/' . $post->image);
    $post->delete();
    return redirect('/')->with(['message' => 'photo deleted successfully!', 'status' => 'info']);
  }


  public function wallet($id)
  {

    $posts = DB::table('images')->where('id', $id)->get();

    return view('purchase')->with('posts', $posts);
  }
  public function transaction(Request $request, $id)
  {
    
    $transactions = Transaction::with('user')->get();
   
    $price = DB::table('images')->where('id', $id)->get();
    foreach ($price as $key => $value) {
      $imageprice = $value->price;

    }
   
    $users = Wallet::where('user_id', auth::user()->id)->first();
    $current_balance = $users->balance;
    if ($current_balance > $imageprice) {

      $transaction = ['amount' => $imageprice, 'user_id' => Auth::id(), 'image_id' => $id, 'type' => 'debit'];
      $success_debit = Transaction::create($transaction);
      if ($success_debit) {
        $image_id = Image::with('user')->where('id', $id)->first();
        $username = User::where('id', $image_id->user_id)->first();
        $wallet_balance = Wallet::where('user_id', $username->id)->first();
        $walletbalance = $wallet_balance->balance;
        $wallet = $wallet_balance->update(['balance' => $walletbalance + $imageprice]);
        // dd($image_id->user_id);
        if ($wallet) {
          $transactions = ['amount' => $imageprice, 'user_id' => $image_id->user->id, 'image_id' => $id, 'type' => 'credit'];
          $success = Transaction::create($transactions);
          
          
          $newbalance = $current_balance - $imageprice;
          $wallet_update = DB::table('wallets')->where('user_id', Auth::id())->update(array('balance' => $newbalance));
          // dd($wallet_update);
          if($wallet_update){
          $ownerchange = Image::where('id', $id)->first();
          $user_id = $ownerchange->user_id;
          $updateowner = $ownerchange->update(array('user_id' => Auth::id()));
          // dd($updateowner);
          }
        // if($success){
        // dd($wallet);
        }
      }
      return redirect('/')->with('wallet', $wallet)->with('success', $success)->with('transactions', $transactions);
    }

     else {

      return redirect('/')->with(['message' => 'sorry you dont have enough coin to buy!', 'status' => 'info']);


    }
  

  }
  public function download($id)
  {
    $imagename = Image::where('id', $id)->first();

    $filepath = public_path('/images/') . $imagename->imagename;
    return response()->download($filepath);
  }

  // search function for searching from two tables user and image table with tag and name both in single route
  public function search(Request $request)
  {
    $q = $request->search;
   
    $posts = Image::with('user')
      ->whereHas('user', function ($query) use ($request) {
       
        $query->where('name', 'LIKE', '%' . $request->search . '%');
       
      })->orWhere('tags', 'LIKE', '%' . $request->search . '%')->paginate(8);

    $wallet = Wallet::all();
    $transactions = Transaction::all();
    if ($posts == true) {

      return view('searchbyname')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);
    } else {
      return view('searchbyname')->with(['message' => 'sorry no search found!', 'status' => 'info']);
    }



   
  }



}

