<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskTestJsonResource;
use App\Models\TaskTestJson;
use Illuminate\Http\Request;


class JsonController extends MainController
{

    public function index(Request $request)
    {
        $tasks = TaskTestJson::all();

        if (isset($tasks)) {
            return $this->sendResponse(TaskTestJsonResource::collection($tasks));
        } else {
            return $this->sendError('not data');
        }

    }

    public function store(Request $request)
    {
        $json = $request->data;

        if ($request->method() == "POST") {

            $json = json_encode($json);
        }

        $start = microtime(true);
        $memory = memory_get_usage();

        $task = TaskTestJson::create([
            'json' => $json,
            'user_id' => auth()->user()->id
        ]);

        $time = microtime(true) - $start;
        $memory = memory_get_usage() - $memory;

        $data = [
            'request_bd_id' => $task->id,
            'time' => $time . " sec.",
            'memory' => $memory . " bytes"
        ];

        return $this->sendResponse($data);
    }

    public function edit(Request $request, $id)
    {
        $task = TaskTestJson::find($id);

        if ($task->user_id == auth()->user()->id) {
            if (isset($task)) {
                $data = [
                    'token_user' => $request->bearerToken(),
                    'items' => new TaskTestJsonResource($task)
                ];

                return $this->sendResponse($data);

            } else {
                return $this->sendError('Items not found', '404');
            }
        } else {
            return $this->sendError('Forbidden', '403');
        }
    }

    public function update(Request $request, $id)
    {
        $task = TaskTestJson::find($id);

        if ($task->user_id == auth()->user()->id) {

            $task->json = json_encode($request->data['items']);

            $task->save();

        } else {
            return $this->sendError('Forbidden', '403');
        }

        return $this->sendResponse(new TaskTestJsonResource($task));
    }

    public function destroy(Request $request, $id)
    {
        $task = TaskTestJson::find($id);

        if ($task->user_id == auth()->user()->id) {

            $task->delete();

        } else {
            return $this->sendError('Forbidden', '403');
        }

        return $this->sendResponse([]);
    }
}
