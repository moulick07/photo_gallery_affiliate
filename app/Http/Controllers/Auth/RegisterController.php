<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'min:10,max:10'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $ref = DB::table('users')->where('affiliate_id', $data['referred_id'])->first();
        
        if($data['referred_id']){
        $users = Wallet::where('user_id', $ref->id)->first();
        if ($users) {
            $current_balance = $users->balance;
            $photo_price = DB::table('admin_wallets')->get();
            foreach ($photo_price as $key => $value) {
                $addcoin = $value->reference_coin;
                
            }
            $wallet = $users->update(['balance' => $current_balance + $addcoin]);
            
        } else {
            $photo_price = DB::table('admin_wallets')->get();
            foreach ($photo_price as $key => $value) {
                $addcoin = $value->reference_coin;
                
            }
            $postData = ['balance' => $addcoin, 'user_id' =>$ref->id];
            $wallet = Wallet::create($postData);
        }}
        
       return  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'affiliate_id' => str::random(10),
            'referred_id' => $data['referred_id'],
        ]);
        
        // Auth::login($login->name);

        // return redirect()->route('welcome.guest');
    



        //  return view('')->with('user',$user);
        // $walletuser = Wallet::create(['balance' => 00.00,'user_id' => Auth::id()]);
        // dd($walletuser);
        // Auth::login();
        // return redirect('/');
    }
}