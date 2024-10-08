<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class todocontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $max_data = 5;

        if(request('search')){
            $data = Todo::where('task', 'like', '%' . request('search') . '%')->paginate($max_data);
        }else{
            $data = Todo::orderBy('task', 'asc')->paginate($max_data);
        }

        return view('todo.app', compact('data')); // compact sama kaya gini = ['data' => $data]
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'task' => 'required|min:3|max:25',
            ],
            [
                'task.required' => 'task harus diisi',
                'task.min' => 'task minimal 3 karakter',
                'task.max' => 'task maksimal 25 karakter',
            ]
        );

        $data = [
            'task' => $request->input('task'),
        ];

        Todo::create($data);

        return redirect()->route('todo.post')->with('success', 'Data Berhasil di simpan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
            'task' => 'required|min:3|max:25',
            ],
            [
                'task.required' => 'task harus diisi',
                'task.min' => 'task minimal 3 karakter',
                'task.max' => 'task maksimal 25 karakter',
            ]
        );

        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done'),
        ];

        Todo::where('id', $id)->update($data);

        return redirect()->route('todo')->with('success', 'Data Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::where('id', $id)->delete();

        return redirect()->route('todo')->with('success', 'Data Berhasil di hapus');
    }
}
