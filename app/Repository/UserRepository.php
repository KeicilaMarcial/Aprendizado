<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserRepository 
{
    public function getUsertype($user_id){
        $user_type = User::where('id',$user_id)->first();

        return $user_type->shopkeeper_user;
    }
}