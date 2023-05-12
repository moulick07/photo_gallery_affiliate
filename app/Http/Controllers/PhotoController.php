<?php

namespace App\Http\Controllers;

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
    // dd($request->all()); 
    // $posts = DB::table('images')->paginate(3);
    // $filt = Input::get('columname');
    $posts = Image::with('user')
      // ->where(function ($query) use ($request) {
      //   if ($request->has('columname')) {
      //    ;
      //   }
      // })
      ->orderBy($request->columname ?? 'created_at', $request->sort ?? 'DESC')->paginate(8);

    // ->paginate(8);
    $wallet = Wallet::with('user')->get();
    $transactions = Transaction::with('user')->get();
    // dd($wallet);
    // dd($wallet);
    // dd($wallet);
    // dd($wallet);
    return view('welcome')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);
    // return view('welcome', compact('posts'));
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

    // $total= count($request->al());
    // dd($total);
    // dd('jhadfkasd');
    $image = $request['image'];
    // dd($image);

    // $request['image']->validate([
    //   'title' => 'required|',
    //   'price' => 'required|',
    //   'tag' => 'required|',
    //   // 'file' => 'required|mimes:png,jpg,jpeg|max:2048'
    // ]);

    // dd(count($request->all()));
    // dd($input);
    // $condition = $input['name'];
    // foreach ($input as $key => $condition) {
    // dd($request['image']);

    for ($i = 0; $i < count($image); $i++) {

      // dd($image[$i]['title']);
      # code...
      // dd($image->file[]);
      $imageName = time() . '.' . $image[$i]['file']->extension();
      # code...
      // print($image[$i]);
      $postData = ['title' => $image[$i]['title'], 'tags' => $image[$i]['tag'], 'price' => $image[$i]['price'], 'imagename' => $imageName, 'user_id' => Auth::id()];
      $saveimagepath = $image[$i]['file']->move(public_path('images/'), $imageName);
      $imagecreate = Image::create($postData);







      // dd($image);
      // $request->image->move(public_path('images'), $imageName);
      // $input = $request->all();

      if ($imagecreate) {
        if (Wallet::where('user_id', auth::user()->id)->first()) {
          $photo_price = DB::table('admin_wallets')->get();
          // dd($photo_price);

          foreach ($photo_price as $key => $value) {
            $addcoin = $value->add_photo_coin;

          }
          $id = auth::user()->id;

          $wallettable = DB::table('wallets')->get();
          foreach ($wallettable as $key => $value) {
            $addcoins = $value->balance;
          }
          // dd($addcoins);
          // $newbalance = $addcoin + $addcoins;
          // $id = auth::user()->id;
          // dd($newbalance);
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
    // $wallet=Wallet::with('user');

    // dd($id);

    return response()->json(['success'=> true,'message' => 'successfully uploaded image'], 200);


  }
  public function show(Request $request, $id)
  {
    // dd("sdfsdf");
    $posts = DB::table('images')->where('id', $id)->get();

    return view('show')->with('posts', $posts);
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
    // $posts = Image::with('user');
    $transactions = Transaction::with('user')->get();
    // dd($transactions);
    // dd($transactions);
    $price = DB::table('images')->where('id', $id)->get();
    foreach ($price as $key => $value) {
      $imageprice = $value->price;

    }
    // $wallet = DB::table('wallets')->get();
    // foreach ($wallet as $key => $value) {
    // $balance = $value->balance;
    // }
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
    // $ownerchange = Image::where('id', $id)->first();
    // $user_id = $ownerchange->user_id;
    // $updateowner = $ownerchange->update(array('user_id' => Auth::id()));

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
    // dd($request->search);
    // $image= Image::with('user')->paginate(8);
    // $posts = DB::table('users')->where('name', 'LIKE', '%' . $q . '%')->get()->toArray();
    // $posts = Image::with('user')->where('tags', 'LIKE', '%' . $q . '%')->whereOr('name','LIKE', '%' . $q . '%')->paginate(8);
    // dd($posts);
    $posts = Image::with('user')
      ->whereHas('user', function ($query) use ($request) {
        // if ($request->search == 'flower' || $request->search == 'animal' || $request->search == 'nature'|| $request->search == 'others') {
        // dd('jhasvjasd');
  
        $query->where('name', 'LIKE', '%' . $request->search . '%');
        // }
        // else{
        //   // dd('hhhh');
        // $query->whereOr('name', 'LIKE', '%' . $request->search  . '%');
        // }
      })->orWhere('tags', 'LIKE', '%' . $request->search . '%')->paginate(8);

    $wallet = Wallet::all();
    $transactions = Transaction::all();
    if ($posts == true) {

      return view('searchbyname')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);
    } else {
      return view('searchbyname')->with(['message' => 'sorry no search found!', 'status' => 'info']);
    }



    // return view('searchbyname')->with(['message' => 'sorry no search found!', 'status' => 'info']); 


    // return redirect('/')->with(['message' => 'sorry no user found', 'status' => 'info'])->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);

    // return view('searchbyname')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);

    // if ($request->ajax()) {
    //   $output = "";
    //   $products = DB::table('images')->where('tags', 'LIKE', '%' . $request->search . "%")->get();
    //   // if ($products) {
    //   //   foreach ($products as $key => $product) {
    //   //     $output .= '<tr>' .
    //   //       '<td>' . $product->id . '</td>' .
    //   //       '<td>' . $product->title . '</td>' .
    //   //       '<td>' . $product->tags . '</td>' .
    //   //       // '<td>' . $product->image. '</td>' .
    //   //       '</tr>';
    //   //   }
    //     return response()->json([$products]);
    //   }
  }


// public function products(Request $request,$col)
// {
//   // $posts= DB::table('images')->orderBy('price','desc')->get();
//   // dd($posts);
//   // $posts = Image::with('user')->orderBy('price', 'desc')->paginate(8);
//   $wallet = Wallet::with('user')->get();
//   $transactions = Transaction::with('user')->get();
//   // // dd($wallet);
//   // // dd($wallet);
//   // // dd($wallet);
//   // // dd($wallet);


//   $posts = Image::orderBy($columnname,$request->sort ?? 'ASC')->paginate(8);

//   // return view
//   return view('welcome')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);




// }
}

// public function sortasc()
// {
//   // $posts= DB::table('images')->orderBy('price','desc')->get();
//   // dd($posts);
//   $posts = Image::with('user')->orderBy('price', 'asc')->paginate(8);
//   $wallet = Wallet::with('user')->get();
//   $transactions = Transaction::with('user')->get();
//   // dd($wallet);
//   // dd($wallet);
//   // dd($wallet);
//   // dd($wallet);
//   return view('welcome')->with('posts', $posts)->with('wallet', $wallet)->with('transactions', $transactions);
// }
// }
