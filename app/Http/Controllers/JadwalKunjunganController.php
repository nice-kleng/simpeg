<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class JadwalKunjunganController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JadwalKunjungan::whereHas('pic', function ($query) {
                $query->where('pic_id', Auth::id());
            })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jadwa', function ($row) {
                    return Carbon::parse($row->tanggal)->format('d F Y');
                })
                ->addColumn('mitra', function ($row) {
                    return $row->mitra->nama;
                })
                ->addColumn('pic', function ($row) {
                    return $row->pic->implode('name', ', ');
                })
                ->addColumn('status', function ($row) {
                    $status = '';
                    if ($row->pertanyaan->count() > 0) {
                        # code...
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-id="' . $row->id . '">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view();
    }
}
