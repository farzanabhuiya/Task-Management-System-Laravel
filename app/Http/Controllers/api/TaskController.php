<?php

namespace App\Http\Controllers\api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dotenv\Parser\Value;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{


    public function index(Request $request)
    {
        $allTask = Task::get();
        return response()->json([
            'status' => true,
            'message' => "Task create Successful",
            'data' => $allTask
        ]);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            // 'status' => 'required|in:Pending,In Progress,Completed',

        ]);
        $user = auth()->user()->id;
        Task::create([
            'user_id' => $user,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,

        ]);

        return response()->json([
            'status' => true,
            'data' => $request->all(),
            'user' => $user,
            'message' => "Task create Successful"
        ]);
    }

    // UpdateTask
    public function UpdateTask(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $tasks = Task::find($id);
        $tasks->title = $request->title;
        $tasks->description = $request->description;
        $tasks->status = $request->status;
        $tasks->save();
        return response()->json([
            'status' => true,
            'tasks' => $tasks,
            'message' => "Task Upadate successful"
        ]);
    }

    // destroy
    public function destroy($id)
    {
        Task::find($id)->delete();

        return response()->json([
            'status' => True,
            'message' => "Task deleted successful"

        ]);
    }
    // shorting
    public function shorting(Request $request, $value)
    {

        $data = Task::orderByRaw("FIELD(status, '$value') DESC")
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->json([
            'status' => True,
            'message' => "Task shorting by $value successful",
            'data' => $data
        ]);
    }
}
