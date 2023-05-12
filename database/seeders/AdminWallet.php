<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminWallet;

class admin_wallets extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminWallet::create([
            'add_photo_coin'=>'10',
            'reference_coin'=>'10'
        ]);
    }
}
