<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Parameter::with('division')->get();
        return view('master.parameter.index', compact('parameters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::all();
        return view('master.parameter.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'division' => 'required|exists:divisions,id',
            'category' => 'required',
            'nama' => 'required',
            'description' => 'required',
            'weight' => 'required'
        ]);

        if (!$validated) return redirect()->back()->with('failed', 'Parameter gagal ditambahkan.');

        $insert = Parameter::create([
            'division_id' => $request->division,
            'category' => $request->category,
            'parameter' => $request->nama,
            'weight' => $request->weight,
            'description' => $request->description
        ]);

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameter = Parameter::with('division')->findOrFail($id);
        $divisions = Division::all();
        return view('master.parameter.edit', compact('parameter', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'division' => 'required|exists:divisions,id',
            'category' => 'required',
            'nama' => 'required',
            'description' => 'required',
            'weight' => 'required'
        ]);

        if (!$validated) return redirect()->back()->with('failed', 'Parameter gagal diperbarui.');

        $parameter = Parameter::findOrFail($id);
        $parameter->division_id = $request->division;
        $parameter->category = $request->category;
        $parameter->parameter = $request->nama;
        $parameter->description = $request->description;
        $parameter->weight = $request->weight;
        $parameter->save();

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameter = Parameter::findOrFail($id);
        $parameter->delete();
        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil dihapus.');
    }
}
