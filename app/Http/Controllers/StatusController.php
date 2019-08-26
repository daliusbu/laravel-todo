<?php

namespace App\Http\Controllers;

use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\Request;
use App\Status;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::orderBy('name', 'asc')->get();
        var_dump($statuses);
    }

    public function view($id)
    {
        $status = Status::findOrFail($id);
        var_dump($status);
    }

    public function add()
    {
        //return view('crud.status.add');
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);
        var_dump($status);
    }

    public function save($id = null, Request $request)
    {
        // Simple input sanitizer
        $request->merge([
            'name' => Purifier::clean($request->name),
        ]);

        // Simple input validator
        $validated = $request->validate([
            'name' => 'string|required|max:255',
        ]);

        if ($validated) {
            try {
                Status::updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('status.index'));
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
            Status::destroy($delete);
        }

        return redirect()->to(route('status.index'));
    }
}
