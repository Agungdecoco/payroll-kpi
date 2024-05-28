<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allowances = Allowance::all();
        return view('master.tunjangan.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.tunjangan.create');
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
            'nama' => 'required',
            'amount' => 'required'
        ]);

        if (!$validated) return redirect()->back()->with('failed', 'Tunjangan gagal ditambahkan.');

        $insert = Allowance::create([
            'allowance' => $request->nama,
            'amount' => $request->amount,
        ]);

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil ditambahkan.');
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
        $allowance = Allowance::findOrFail($id);
        return view('master.tunjangan.edit', compact('allowance'));
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
            'nama' => 'required',
            'amount' => 'required',
        ]);

        if (!$validated) return redirect()->back()->with('failed', 'Tunjangan gagal diperbarui.');

        $allowance = Allowance::findOrFail($id);
        $allowance->allowance = $request->nama;
        $allowance->amount = $request->amount;
        $allowance->save();

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $allowance = Allowance::find($id);
        $allowance->delete();
        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil dihapus.');
    }
}
