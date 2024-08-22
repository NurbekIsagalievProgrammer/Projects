<?php

namespace App\Http\Controllers;

use App\Models\RecyclerTheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecyclerThemeController extends Controller
{
    public function index(): JsonResponse
    {
        $recyclerThemes = RecyclerTheme::get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'recyclerThemes' => $recyclerThemes,
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        RecyclerTheme::create([
            'title' => $request['title'],
            'description' => $request['description'],
        ]);

        $recyclerThemes = RecyclerTheme::get();
        return response()->json([
            'status' => true,
            'message' => 'RecyclerTheme successfully created',
            'recyclerThemes' => $recyclerThemes,
        ], 200);
    }

    public function edit(Request $request): JsonResponse
    {
        RecyclerTheme::find($request['id'])
                ->update([
                    'title' => $request['title'],
                    'description' => $request['description'],  
                ]);
        
        $recyclerThemes = RecyclerTheme::get();
        return response()->json([
            'status' => true,
            'message' => 'RecyclerTheme successfully updated',
            'recyclerThemes' => $recyclerThemes,
        ], 200);
    }

    public function remove(Request $request): JsonResponse
    {
        RecyclerTheme::find($request['id'])->delete();

        $recyclerThemes = RecyclerTheme::get();
        return response()->json([
            'status' => true,
            'message' => 'RecyclerTheme successfully deleted',
            'recyclerThemes' => $recyclerThemes,
        ], 200);
    } 
}
