<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class PertanyaanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Pertanyaan', ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pertanyaan::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-id="' . $row->id . '">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('crm.pertanyaan.pertanyaan');
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
            'pertanyaan' => 'required|string|max:255',
        ]);

        try {
            Pertanyaan::updateOrCreate(
                ['id' => $request->id],
                ['pertanyaan' => $request->pertanyaan]
            );

            return response()->json([
                'success' => $request->id ? 'Pertanyaan updated successfully.' : 'Pertanyaan created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while saving the data.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pertanyaan $pertanyaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $pertanyaan = Pertanyaan::findOrFail($id);
            return response()->json($pertanyaan);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Pertanyaan not found.'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
        ]);

        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->update($request->all());

        return response()->json(['success' => 'Pertanyaan updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Pertanyaan::find($id)->delete();
        return response()->json(['success' => 'Pertanyaan deleted successfully.']);
    }
}
