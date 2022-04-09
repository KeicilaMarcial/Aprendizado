<?php
namespace App\Repository;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletRepository 
{
    public function updateBanlace($value, $user_id){
        DB::table('wallets')->where('user_id',$user_id)->update(['balance' => $value,]);
    }

    public function getCurrentBalance($user_id){
       $user_wallet = Wallet::where('user_id',$user_id)->first();

       return $user_wallet->balance;
    }
}