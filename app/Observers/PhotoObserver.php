<?php

namespace App\Observers;

use App\Models\Image;
use App\Models\Wallet;
use Auth;
use Notification;
use App\Notifications\CreatePhoto;
use App\Models\User;


class PhotoObserver
{
    /**
     * Handle the Image "created" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function created(Image $image)
    {   
        // $balances = \DB::table('Image')->find('user_id');
       
        $user = User::findOrFail($image->user_id);
        Notification::send($user, new CreatePhoto($image));
    //  $data = $balances;
    //  dd($data);
        
       

    }

    /**
     * Handle the Image "updated" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function updated(Image $image)
    {
        //
    }

    /**
     * Handle the Image "deleted" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function deleted(Image $image)
    {
        
    }

    /**
     * Handle the Image "restored" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function restored(Image $image)
    {
        //
    }

    /**
     * Handle the Image "force deleted" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function forceDeleted(Image $image)
    {
        //
    }
}
