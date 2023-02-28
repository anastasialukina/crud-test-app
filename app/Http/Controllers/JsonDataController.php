<?php

namespace App\Http\Controllers;

use App\Models\JsonData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JsonDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $data = JsonData::all();
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function create(): Factory|View|Application
    {
        return view('data.create');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|json'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid data'], 400);
        }
        //Validator ends

        $start_time = microtime(true);
        $start_memory = memory_get_usage(true);


        $data = JsonData::create([
            'user_id' => Auth::id(),
            'list' => $request->input('data')
        ]);

        $end_time = microtime(true);
        $end_memory = memory_get_usage(true);

        return response()->json([
            'status' => 'success',
            'message' => 'Data list created successfully',
            'data_id' => $data->id,
            'time' => $end_time - $start_time,
            'memory' => $end_memory - $start_memory
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = JsonData::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $data = JsonData::find($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data list entry was deleted successfully',
            'data' => $data,
        ]);
    }
}
