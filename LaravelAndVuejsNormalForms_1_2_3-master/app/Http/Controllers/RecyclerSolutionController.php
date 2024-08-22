<?php

namespace App\Http\Controllers;

use App\Models\RecyclerSolution;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecyclerSolutionController extends Controller
{
    public function index(): JsonResponse
    {
        $recyclerSolutions = RecyclerSolution::get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'recyclerSolutions' => $recyclerSolutions,
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        RecyclerSolution::create([
            'theme_id' => $request['theme_id'],
            'title' => $request['title'],
        ]);
        $recyclerSolutions = RecyclerSolution::get();
        return response()->json([
            'status' => true,
            'message' => 'RecyclerSolution successfully created',
            'recyclerSolutions' => $recyclerSolutions,
        ], 200);
    }

    public function edit(Request $request): JsonResponse
    {
        RecyclerSolution::find($request['id'])
                ->update([
                    'theme_id' => $request['theme_id'],
                    'title' => $request['title'],
                ]);
        
        $recyclerSolutions = RecyclerSolution::get();
        return response()->json([
            'status' => true,
            'message' => 'RecyclerSolution successfully updated',
            'recyclerSolutions' => $recyclerSolutions,
        ], 200);
    }

    public function remove(Request $request): JsonResponse
    {
        RecyclerSolution::find($request['id'])->delete();

        $recyclerSolutions = RecyclerSolution::get();
        return response()->json([
            'status' => true,
            'message' => 'RecyclerSolution successfully deleted',
            'recyclerSolutions' => $recyclerSolutions
        ], 200);
    } 
}
