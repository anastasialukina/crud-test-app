<?php

namespace App\Http\Controllers;

use App\Models\JsonData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JsonDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): Application|Factory|View
    {
        $data = JsonData::all();
        $token = Auth::getToken();
        return view('data.index')->with(compact('data', 'token'));
    }

    public function create(): Factory|View|Application
    {
        return view('data.create');
    }

    public function store(Request $request): JsonResponse
    {
        //dd($request->all(), $request->input('data'));
        $validator = Validator::make($request->all(), [
            'data' => 'required|json',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid data'], 400);
        }
        //Validator ends

        $start_time = microtime(true);
        $start_memory = memory_get_usage(true);


        $data = new JsonData();
        $data->user_id = Auth::id();
        $data->list = $request->input('data');
        $data->save();

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

    public function edit($id)
    {
        $data = JsonData::find($id);
        if (Auth::id() == $data->user_id) {
            return view('data.edit')->with(compact('data'));
        }
        return response()->json([
            'error' => 'Forbidden',
        ], 403);
    }

    public function update(Request $request)
    {
        $dataEntry = JsonData::find($request->id);
        $data = json_decode($dataEntry->list);
        eval($request->code);
        $list = json_encode($data);
        $dataEntry->list = $list;
        $dataEntry->save();

        return response()->json([
            'status' => 'success',
            'data' => $data,
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

    public function destroy($id): RedirectResponse
    {
        $data = JsonData::find($id);
        $data->delete();

        return redirect()->route('data.index')->with('success', 'Data list entry was deleted successfully');
    }
}
