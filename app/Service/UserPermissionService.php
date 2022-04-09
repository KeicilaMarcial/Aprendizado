<?php
namespace App\Service;
use App\Repository\UserRepository ;
use App\Models\User;

class UserPermissionService
{  
    public function __construct(UserRepository $userRepository){
		$this->userRepository = $userRepository;
	}

    public function verifyUserType($user_id){
        $is_shopkeeper =$this->userRepository->getUsertype($user_id);

        if ($is_shopkeeper === 1){
            return true;
        }

        return false;
    }
}