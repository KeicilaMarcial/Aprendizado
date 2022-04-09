<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\TransactionService;
use App\Service\UserPermissionService;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $wallet;

    public function __construct(TransactionService $transactionService, UserPermissionService $userPermissionService){
        $this->transactionService = $transactionService;
        $this->userPermissionService = $userPermissionService;    
	}

    public function transaction(Request $request){   
        if(($this->userPermissionService->verifyUserType($request->common_user))==true) {
            return response()->json([
                'Erro' => 'Unauthorized'
            ], 400);
        }
        $this->transactionService->transaction($request->all());
        
    }
}
