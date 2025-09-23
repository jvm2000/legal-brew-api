<?php

namespace App\Http\Controllers;

use App\Models\SubService;
use App\Models\MenuServices;
use Illuminate\Http\Request;

class MenuServicesController extends Controller
{
    public function index()
    {
        $menuServices = MenuServices::with('subServices')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($menuServices);
    }

    public function update(Request $request, SubService $subservice)
    {
        $form = $request->validate([
            'details' => 'string',
        ]);

        $subservice->update($form);

        return response()->json($subservice, 200);
    }
}
