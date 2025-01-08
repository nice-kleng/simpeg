<?php

namespace App\Http\Controllers\Marketing;

use App\Exports\TurlapExport;
use App\Http\Controllers\Controller;
use App\Imports\ImportMarketing;
use App\Models\FollowUpMarketing;
use App\Models\Marketing;
use App\Models\SumberMarketing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TurlapController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Turlap', only: ['index', 'tampilTurlap']),
            new Middleware('permission:Create Turlap', only: ['store']),
            new Middleware('permission:Edit Turlap', only: ['update']),
            new Middleware('permission:Delete Turlap', only: ['destroy']),
            new Middleware('permission:Follow Up Turlap', only: ['followUp', 'followUpStore', 'followUpEdit', 'followUpUpdate', 'followUpDestroy']),
        ];
    }

    public function index()
    {
        $sumberMarketings = SumberMarketing::where('label', 'Turlap')
            ->withCount(['marketings' => function ($query) {
                $query->where('label', 'Turlap');
            }])
            ->orderBy('nama_sumber_marketing', 'asc')
            ->get();

        return view('marketing.turlap.turlap', compact('sumberMarketings'));
    }

    public function detailTurlapByArea($id)
    {
        $sumberMarketing = SumberMarketing::findOrFail($id);
        $pegawai = User::role('Marketing')->get();
        return view('marketing.turlap.detailTurlap', compact('sumberMarketing', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id',
        ]);

        $pics = $request->pics ?? [];
        $picSign = $request->picSign ?? [];
        // if (!Auth::user()->hasRole('Super Admin') || !Auth::user()->hasPermissionTo('View Marketing Kadiv Dashboard')) {
        if (!Auth::user()->hasRole('Super Admin')) {
            $pics[] = Auth::user()->id;
            $picSign[] = Auth::user()->id;
        }
        $pics = array_unique($pics);
        $picSign = array_unique($picSign);

        $request->merge(['akun_id' => Auth::user()->id]);
        $turlap = Marketing::create($request->all());
        $turlap->pics()->attach($pics);
        $turlap->picSign()->attach($picSign);

        return redirect()->route('turlap.detailTurlapByArea', $request->sumber_marketing_id)->with('message', 'Turlap berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function edit($id)
    {
        $turlap = Marketing::findOrFail($id);
        $turlap->load('pics', 'picSign');
        $formattedData = $turlap->toArray();
        $formattedData['pics'] = $turlap->pics->pluck('id')->toArray();
        $formattedData['picSign'] = $turlap->picSign->pluck('id')->toArray();
        $formattedData['rating_raw'] = $turlap->getRawOriginal('rating');
        return response()->json($formattedData);
    }

    public function update(Request $request, $id)
    {
        $turlap = Marketing::findOrFail($id);
        $turlap->update($request->all());
        $turlap->pics()->sync($request->pics);
        $turlap->picSign()->sync($request->picSign);
        return redirect()->route('turlap.detailTurlapByArea', $request->sumber_marketing_id)->with('message', 'Turlap berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function destroy($id)
    {
        $turlap = Marketing::findOrFail($id);
        $turlap->delete();
        return redirect()->route('turlap.detailTurlapByArea', $turlap->sumber_marketing_id)->with('message', 'Turlap berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUp($id)
    {
        $turlap = Marketing::findOrFail($id);
        return view('marketing.turlap.followUp', compact('turlap'));
    }

    public function followUpStore(Request $request, $id)
    {
        $turlap = Marketing::findOrFail($id);
        $turlap->followUp()->create($request->all());
        return redirect()->route('turlap.detailTurlapByArea', $turlap->sumber_marketing_id)->with('message', 'Follow Up berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUpEdit($id)
    {
        $followUp = FollowUpMarketing::find($id);
        return response()->json([
            'status' => $followUp->status,
            'status_raw' => $followUp->getRawOriginal('status'),
            'keterangan' => $followUp->keterangan,
            'followup' => $followUp->followup,
            'tanggal' => $followUp->tanggal,
        ]);
    }

    public function followUpUpdate(Request $request, $id)
    {
        $followUp = FollowUpMarketing::findOrFail($id);
        $followUp->update($request->all());
        return redirect()->route('turlap.followUp', $followUp->marketing_id)->with('message', 'Follow Up berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUpDestroy($id)
    {
        $followUp = FollowUpMarketing::findOrFail($id);
        $followUp->delete();
        return redirect()->route('turlap.followUp', $followUp->marketing_id)->with('message', 'Follow Up berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function tampilTurlap()
    {
        $marketings = Marketing::where('label', 'Turlap')->orderBy('tanggal', 'desc')->get();
        return view('marketing.turlap.viewTurlap', compact('marketings'));
    }

    public function preview(Request $request)
    {
        $query = Marketing::with(['followUp', 'pics', 'picSign'])
            ->where('label', 'Turlap');

        if ($request->s_date && $request->e_date) {
            $query->whereBetween('tanggal', [$request->s_date, $request->e_date]);
        }

        $data = $query->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data,
                'maxFollowUps' => $data->max(function ($item) {
                    return $item->followUp->count();
                })
            ]);
        }

        return view('marketing.turlap.report_turlap', compact('data'));
    }

    public function export(Request $request)
    {
        if ($request->isMethod('post')) {
            $fileName = 'turlap_' . date('Y-m-d') . '.xlsx';
            return Excel::download(
                new TurlapExport($request->s_date, $request->e_date),
                $fileName
            );
        }

        return redirect()->route('turlap.preview');
    }

    public function unduhTemplateImport(string $id)
    {
        $inputFileName = storage_path('app/public/template_import.xlsx');
        $reader = IOFactory::createReader('Xlsx');
        $spreedsheet = $reader->load($inputFileName);
        $sheet = $spreedsheet->getActiveSheet();

        $sheet->setCellValue('A2', $id);
        $sheet->setCellValue('H2', 'Turlap');

        $writer = IOFactory::createWriter($spreedsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_turlap.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function importTurlap(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new ImportMarketing, $file);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('message', 'Terjadi kesalahan saat mengimport data. Pastikan file yang diupload sesuai dengan template yang telah disediakan.')->with('type', 'danger')->with('title', 'Gagal');
        }
    }
}
