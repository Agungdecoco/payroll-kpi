<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use App\Models\Segment;

class SegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = Segment::with('division')->get();
        return view('master.segmen.index', compact('segments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::all();
        return view('master.segmen.create', compact('divisions'));
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
            'division' => 'required|exists:divisions,id',
        ]);

        if ($validated === false) {
            return redirect()->back()->with('failed', 'Segmen gagal ditambahkan.');
        }

        $segment = Segment::create([
            'segment' => $request->nama,
            'division_id' => $request->division
        ]);

        return redirect()->route('segmen.index')->with('success', 'Segmen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $divisions = Division::all();
        $segment = Segment::with('division')->findOrFail($id);
        return view('master.segmen.edit', compact('segment', 'divisions'));
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
            'division' => 'required|exists:divisions,id'
        ]);

        $segment = Segment::findOrFail($id);
        $segment->segment = $request->nama;
        $segment->division_id = $request->division;
        $segment->save();

        return redirect()->route('segmen.index')->with('success', 'Segmen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $segment = Segment::findOrFail($id);
        $segment->delete();

        return redirect()->route('segmen.index')->with('success', 'Segmen berhasil dihapus');
    }

    public function getSegmentsByDivision($divisionId)
    {
        $segments = Segment::where('division_id', $divisionId)->get();
        return response()->json($segments->pluck('segment', 'id'));
    }
}
