<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller

{
    private $user;

	public function __construct(User $user){
		$this->user = $user;
	}
}
