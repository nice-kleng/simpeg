<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PegawaiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Pegawai', only: ['index']),
            new Middleware('permission:Create Pegawai', only: ['store']),
            new Middleware('permission:Edit Pegawai', only: ['update']),
            new Middleware('permission:Delete Pegawai', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pegawai = Pegawai::with('jabatan')->get();
            return datatables()->of($pegawai)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('email', function ($row) {
                    return $row->akun->email;
                })
                ->addColumn('jabatan', function ($row) {
                    return $row->jabatan->nama_jabatan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('pegawai.edit', $row->id) . '" class="edit btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deleteData(this)" data-url="' . route('pegawai.destroy', $row->id) . '">Hapus</a>';
                    return $btn;
                })
                ->addColumn('foto', function ($row) {
                    return '<img src="' . asset('storage/' . $row->foto) . '" width="100">';
                })
                ->rawColumns(['action', 'foto'])
                ->make(true);
        }
        return view('superadmin.pegawai.pegawai');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatan = Jabatan::all();
        $roles = Role::all();
        return view('superadmin.pegawai.create', compact('jabatan', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'jabatan_id' => 'required',
                'nik' => 'required|unique:pegawais,nik|numeric|digits:16',
                'nama' => 'required',
                'wa' => 'required|numeric|max_digits:13',
                'ttl' => 'required',
                'alamat' => 'required',
                'jenkel' => 'required',
                'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'email' => 'required|email|unique:users,email',
            ]);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $foto = $foto->storeAs('pegawai', $foto->hashName());
            }

            $akun = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);

            $akun->assignRole($request->role);

            Pegawai::create([
                'akun_id' => $akun->id,
                'jabatan_id' => $request->jabatan_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'wa' => $request->wa,
                'ttl' => $request->ttl,
                'alamat' => $request->alamat,
                'jenkel' => $request->jenkel,
                'foto' => $foto,
            ]);

            DB::commit();
            return redirect()->route('pegawai.index')->with('message', 'Pegawai Berhasil Ditambahkan')->with('title', 'Success')->with('type', 'success');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->route('pegawai.index')->with('message', 'Pegawai Gagal Ditambahkan')->with('title', 'Failed')->with('type', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $jabatan = Jabatan::all();
        return view('superadmin.pegawai.edit', compact('pegawai', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'jabatan_id' => 'required',
                'nik' => 'required|unique:pegawais,nik,' . $pegawai->id . '|numeric|digits:16',
                'nama' => 'required',
                'wa' => 'required|numeric|max_digits:13',
                'ttl' => 'required',
                'alamat' => 'required',
                'foto' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
                'email' => 'required|email|unique:users,email,' . $pegawai->akun->id,
            ]);

            $foto = $pegawai->foto; // Default to the existing photo

            if ($request->hasFile('foto')) {
                $newFoto = $request->file('foto');
                $foto = $newFoto->storeAs('pegawai', $newFoto->hashName());

                if ($pegawai->foto && Storage::exists($pegawai->foto)) {
                    Storage::delete($pegawai->foto);
                }
            }

            // Check if email or name has changed
            if ($request->email !== $pegawai->akun->email || $request->nama !== $pegawai->nama) {
                $pegawai->akun->update([
                    'email' => $request->email,
                    'name' => $request->nama,
                ]);
            }

            $pegawai->update([
                'jabatan_id' => $request->jabatan_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'wa' => $request->wa,
                'ttl' => $request->ttl,
                'alamat' => $request->alamat,
                'foto' => $foto,
            ]);

            DB::commit();
            return redirect()->route('pegawai.index')->with('message', 'Pegawai Berhasil Diubah')->with('title', 'Success')->with('type', 'success');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->route('pegawai.index')->with('message', 'Pegawai Gagal Diubah')->with('title', 'Failed')->with('type', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        DB::beginTransaction();
        try {
            if ($pegawai->foto && Storage::exists($pegawai->foto)) {
                Storage::delete($pegawai->foto);
            }

            $pegawai->akun->delete();
            $pegawai->delete();

            DB::commit();
            return redirect()->route('pegawai.index')->with('message', 'Pegawai Berhasil Dihapus')->with('title', 'Success')->with('type', 'success');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->route('pegawai.index')->with('message', 'Pegawai Gagal Dihapus')->with('title', 'Failed')->with('type', 'error');
        }
    }
}
