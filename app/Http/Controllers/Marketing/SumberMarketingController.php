<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\SumberMarketing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SumberMarketingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Sumber Marketing', only: ['index']),
            new Middleware('permission:Create Sumber Marketing', only: ['store']),
            new Middleware('permission:Edit Sumber Marketing', only: ['update']),
            new Middleware('permission:Delete Sumber Marketing', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'nama_sumber_marketing' => 'required',
        ]);

        SumberMarketing::create($request->all());

        return redirect()->back()->with('message', 'Data berhasil ditambahkan')->with('title', 'Berhasil')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(SumberMarketing $sumberMarketing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SumberMarketing $sumberMarketing)
    {
        return response()->json($sumberMarketing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SumberMarketing $sumberMarketing)
    {
        $request->validate([
            'nama_sumber_marketing' => 'required|string|max:255|unique:sumber_marketings,nama_sumber_marketing,' . $sumberMarketing->id,
        ]);

        $sumberMarketing->update($request->all());
        return redirect()->back()->with('message', 'Data berhasil diubah')->with('title', 'Berhasil')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SumberMarketing $sumberMarketing)
    {
        $sumberMarketing->delete();
        return redirect()->back()->with('message', 'Data berhasil dihapus')->with('title', 'Berhasil')->with('type', 'success');
    }
}
