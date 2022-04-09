<?php
namespace App\Service;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;
use App\Repository\WalletRepository ;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class TransectionService
{   
    public function __construct(WalletRepository $walletRepository, Response $response){
		$this->walletRepository = $walletRepository;
        $this->response = $response;
	}
    
    public function checkBalance($value, $payer_id){
        $payer_balance = DB::table('wallets')->where('user_id',$payer_id)->first();     
       
        if( $payer_balance->balance >= $value) return true ; 
    
        return false;  
    }

    public function registerTransactionLog(array $data){

       $log = TransactionLog::create([
        'amount_sent' => $data['amount_sent'],
        'previous_amount' => $data['previous_amount'],
        'actual_amount' => $data['current_amount'],
        'payee_id'=> $data['payee_id'],
        'user_id' => $data['user_id']
        
       ]);

       if($log){
        return response()->json(['Log'=> $data], 200);
       }
       return response()->json(['Erro' => 'Ops somethings went wrong'], 400);
    }

    public function transaction(array $data){
       if(!$this->checkBalance($data['value'],$data['common_user'])){
            return response()->json(['message' => 'Not enough balance'], 400);
        }
        DB::transaction(function() use ($data) {

            $current_payer_balance = $this->walletRepository->getCurrentBalance($data['common_user']);
            $current_payee_balance = $this->walletRepository->getCurrentBalance($data['payee']);
            

            $payer_balance = $current_payer_balance - $data['value'];
            $payee_balance = $current_payee_balance + $data['value'];
            
            $response = Http::acceptJson()->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
 
            $obj = json_decode($response);

            if (!$obj->{'message'} =='Autorizado') return  $this->response->json(['message' => 'Unauthorized'], 400);

            $this->walletRepository->updateBanlace($payer_balance,$data['common_user']);
            $this->walletRepository->updateBanlace($payee_balance,$data['payee']);
            
            $completData=[
                'amount_sent' => $data['value'],
                'previous_amount' => $current_payer_balance,
                'current_amount' => $payer_balance,
                'payee_id'=> $data['payee'],
                'user_id' => $data['common_user'],
            ];

            $this->registerTransactionLog($completData);
            $payeer_warning = Http::acceptJson()->get('http://o4d9z.mocklab.io/notify');
            
        });
    }
}