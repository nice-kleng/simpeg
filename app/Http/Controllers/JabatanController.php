<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JabatanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            new Middleware('permission:View Jabatan', only: ['index']),
            new Middleware('permission:Create Jabatan', only: ['store']),
            new Middleware('permission:Edit Jabatan', only: ['update']),
            new Middleware('permission:Delete Jabatan', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jabatan = Jabatan::all();
            return datatables()->of($jabatan)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" onclick="editData(' . $row->id . ')" class="edit btn btn-warning">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" onclick="deleteData(this)" data-url="' . route('jabatan.destroy', $row->id) . '" class="delete btn btn-danger">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('superadmin.jabatan');
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
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
        ]);

        $jabatan = new Jabatan();
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'title' => 'Berhasil',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        return response()->json($jabatan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
        ]);

        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'title' => 'Berhasil',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->back()->with('message', 'Data berhasil dihapus')->with('title', 'Berhasil')->with('type', 'success');
    }
}
