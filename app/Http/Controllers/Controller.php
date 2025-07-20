<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    private $loggedUser;
    public function __construct()
    {
        $this->loggedUser = Auth::user();
    }
    public function getLoggedUser()
    {
        return $this->loggedUser;
    }
}
