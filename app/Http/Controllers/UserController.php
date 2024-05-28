<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('level', 'segment')->get();
        return view('master.karyawan.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::all();
        $divisions = Division::all();
        return view('master.karyawan.create', compact('levels', 'divisions'));
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
            'email' => 'required|email|unique:users,email',
            'telp' => 'required|unique:users,telephone',
            'address' => 'required',
            'password' => 'required',
            'level' => 'required|exists:levels,id',
            'segment' => 'required|exists:segments,id',
            'salary' => 'required',
        ]);

        if ($validated === false) {
            return redirect()->back()->with('failed', 'Karyawan gagal ditambahkan.');
        }

        $password = Hash::make($validated['password']);
        $secret = $request->password;

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'telephone' => $request->telp,
            'address' => $request->address,
            'password' => $password,
            'secret' => $secret,
            'level_id' => $request->level,
            'segment_id' => $request->segment,
            'salary' => $request->salary
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('master.karyawan.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $levels = Level::all();
        $divisions = Division::all();
        $user = User::with('segment')->findOrFail($id);
        return view('master.karyawan.edit', compact('user', 'levels', 'divisions'));
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
            'email' => 'required|email|unique:users,email,' . $id,
            'telp' => 'required|unique:users,telephone,' . $id,
            'address' => 'required',
            'password' => 'sometimes',
            'level' => 'required|exists:levels,id',
            'segment' => 'required|exists:segments,id',
            'salary' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->telephone = $request->telp;
        $user->level_id = $request->level;
        $user->segment_id = $request->segment;
        $user->salary = $request->salary;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->secret = $request->password;
        }

        $user->save();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
