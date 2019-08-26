<?php

namespace App\Http\Controllers;

use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\Request;
use App\Status;
use App\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('status_filter', $request->session()->get('status_filter', ''));

        // Remember current filter settings
        $request->session()->put('status_filter', $filter);

        $statuses = Status::all();

        $tasks = Task::orderBy('created_at', 'desc')
            ->with('status')
            ->when($filter, function($query) use ($filter) {
                $query->where('status_id', $filter);
            })->paginate();
//        var_dump($tasks);
        return view('task.index', ['tasks' => $tasks, 'statuses' => $statuses]);
    }

    public function view($id)
    {
        $task = Task::with('status')->findOrFail($id);
        var_dump($task);
    }

    public function add()
    {
        $statuses = Status::orderBy('name', 'asc')->get();
        return view('task.add', ['statuses'=>$statuses,]);
        var_dump($statuses);
    }

    public function edit($id)
    {
        $statuses = Status::orderBy('name', 'asc')->get();
        $task = Task::with('status')->findOrFail($id);
        var_dump($statuses, $task);
    }

    public function save($id = null, Request $request)
    {
        // Simple input sanitizer
        $request->merge([
            'task_name' => Purifier::clean($request->task_name),
            'task_description' => Purifier::clean($request->task_description),
            'status_id' => Purifier::clean($request->status_id),
        ]);


//        HTMLE kad matytusi kintamasis kai jis neuzcekntas
//        <input type="hidden" name="is_completed" value=0>
//        <input type="checkbox" name="is_completed" value=1>

        $isCompleted = $request->input('is_completed', false);
        if($isCompleted){
            $validated['completed_date'] = now();
        }else{
            $validated['completed_date'] = null;

        }

//        dump ($request->status_id); die();
        // Simple input validator
        $validated = $request->validate([
            'task_name' => 'string|required|max:255',
            'task_description' => 'string|nullable',
            'status_id' => 'integer|nullable',
        ]);


        if ($validated) {
            try {
                Task::updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('task.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
            return redirect()->back()->with('danger', 'Uncatchable exception');
        }
        return redirect()->back()->withInput();

    }

    public function delete(Request $request)
    {
        $delete = collect($request->input('selected', []));

        if ($delete->isNotEmpty()) {
            Task::destroy($delete);
        }

        return redirect()->to(route('task.index'));
    }
}
