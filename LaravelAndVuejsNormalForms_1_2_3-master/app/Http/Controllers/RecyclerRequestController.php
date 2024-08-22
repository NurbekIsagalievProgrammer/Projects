<?php

namespace App\Http\Controllers;

use App\Models\RecyclerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Recycler;
use App\Models\RecyclerTheme;
use App\Models\RecyclerSolution;

class RecyclerRequestController extends Controller
{
    public function index(): JsonResponse
    {
        $recyclerRequests = RecyclerRequest::with(['recyclers', 'themes', 'solutions'])->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'recyclerRequests' => $recyclerRequests,
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        RecyclerRequest::create([
            'recycler_id' => $request['recycler_id'],
            'theme_id' => $request['theme_id'],
            'solution_id' => $request['solution_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $recyclerRequests = RecyclerRequest::get();

        return response()->json([
            'status' => true,
            'message' => 'RecyclerRequest successfully created',
            'recyclerRequests' => $recyclerRequests,
        ], 200);
    }

    public function updateRequest(Request $request): JsonResponse
    {
        $recyclerRequest = RecyclerRequest::findOrFail($request['id']);

        if (!$recyclerRequest) {
            return response()->json([
                'status' => false,
                'message' => 'RecyclerRequest not found',
                'requestData' => $request->all(),
            ], 404);
        }

        // Обновляем статус, решение и дату изменения
        $recyclerRequest->update([
            'status' => $request['status'], // Используем переданное значение для обновления статуса
            'solution_id' => $request['solution_id'], // Предполагается, что вы передаете новое решение
            'updated_at' => now(), // Обновляем дату изменения
        ]);

        $recyclerRequests = RecyclerRequest::get();

        return response()->json([
            'status' => true,
            'message' => 'RecyclerRequest successfully updated',
            'recyclerRequests' => $recyclerRequests,
            'updated_at' => $recyclerRequest->fresh()->updated_at, // Возвращаем обновленное время изменения
        ], 200);
    }

    public function getAllRecyclerSerialNumbers()
    {
        $serialNumbers = Recycler::all(); // Выбираем все столбцы из таблицы Recycler
        return response()->json(['status' => true, 'serialNumbers' => $serialNumbers]);
    }

    public function getAllRecyclerThemeTitles()
    {
        $titles = RecyclerTheme::all(); // Выбираем все столбцы из таблицы RecyclerTheme
        return response()->json(['status' => true, 'titles' => $titles]);
    }

    public function getAllRecyclerSolutionTitles()
    {
        $titles = RecyclerSolution::all(); // Выбираем все столбцы из таблицы RecyclerSolution
        return response()->json(['status' => true, 'titles' => $titles]);
    }
}
