<?php

namespace App\Http\Controllers;

use App\Models\MenuServices;
use Illuminate\Http\Request;

class MenuServicesController extends Controller
{
    public function index()
    {
        $menuServices = MenuServices::get();

        return response()->json($menuServices);
    }
}
