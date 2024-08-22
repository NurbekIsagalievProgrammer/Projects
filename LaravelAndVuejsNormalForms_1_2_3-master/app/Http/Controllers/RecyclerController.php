<?php

namespace App\Http\Controllers;

use App\Models\Recycler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecyclerController extends Controller
{
    public function index(): JsonResponse
    {
        $recyclers = Recycler::get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'recyclers' => $recyclers
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        Recycler::create([
            'status' => $request['status'],
            'system_id' => $request['system_id'],
            'address' => $request['address'],
            'serial_number' => $request['serial_number']
        ]);

        $recyclers = Recycler::get();
        return response()->json([
            'status' => true,
            'message' => 'Recycler successfully created',
            'recyclers' => $recyclers
        ], 200);
    }

    public function edit(Request $request): JsonResponse
    {
        Recycler::find($request['id'])
                ->update([
                    'status' => $request['status'],
                    'system_id' => $request['system_id'],
                    'address' => $request['address'],
                    'serial_number' => $request['serial_number']
                ]);
        
        $recyclers = Recycler::get();
        return response()->json([
            'status' => true,
            'message' => 'Recycler successfully updated',
            'recyclers' => $recyclers
        ], 200);
    }

    public function remove(Request $request): JsonResponse
    {
        Recycler::find($request['id'])->delete();

        $recyclers = Recycler::get();
        return response()->json([
            'status' => true,
            'message' => 'Recycler successfully deleted',
            'recyclers' => $recyclers
        ], 200);
    }
}
