<?php

namespace App\Http\Controllers\Marketing;

use App\Exports\BrandExport;
use App\Http\Controllers\Controller;
use App\Imports\ImportMarketing;
use App\Models\FollowUpMarketing;
use App\Models\Marketing;
use App\Models\SumberMarketing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BrandController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Brand', only: ['index']),
            new Middleware('permission:Create Brand', only: ['store']),
            new Middleware('permission:Edit Brand', only: ['update']),
            new Middleware('permission:Delete Brand', only: ['destroy']),
            new Middleware('permission:Follow Up Brand', only: ['followUp', 'followUpStore', 'followUpEdit', 'followUpUpdate', 'followUpDestroy']),
        ];
    }

    public function index()
    {
        $sumberMarketings = SumberMarketing::where('label', 'Brand')
            ->withCount(['marketings' => function ($query) {
                $query->where('label', 'Brand');
            }])
            ->orderBy('nama_sumber_marketing', 'asc')
            ->get();

        return view('marketing.brand.brand', compact('sumberMarketings'));
    }

    public function detailBrandByArea($id)
    {
        $sumberMarketing = SumberMarketing::findOrFail($id);
        $pegawai = User::role('Marketing')->get();
        return view('marketing.brand.detailBrand', compact('sumberMarketing', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id',
        ]);

        $pics = $request->pics ?? [];
        $picsSign = $request->picSign ?? [];
        // if (!Auth::user()->hasRole('Super Admin') || !Auth::user()->hasPermissionTo('View Marketing Kadiv Dashboard')) {
        if (!Auth::user()->hasRole('Super Admin')) {
            $pics[] = Auth::user()->id;
            $picsSign[] = Auth::user()->id;
        }
        $pics = array_unique($pics);
        $picsSign = array_unique($picsSign);
        $request->merge(['akun_id' => Auth::user()->id]);
        $brand = Marketing::create($request->all());
        $brand->pics()->attach($pics);
        $brand->picSign()->attach($picsSign);

        return redirect()->route('brand.detailBrandByArea', $request->sumber_marketing_id)->with('message', 'Brand berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function edit($id)
    {
        $brand = Marketing::findOrFail($id);
        $brand->load('pics');
        $formattedData = $brand->toArray();
        $formattedData['pics'] = $brand->pics->pluck('id')->toArray();
        $formattedData['picSign'] = $brand->picSign->pluck('id')->toArray();
        $formattedData['rating_raw'] = $brand->getRawOriginal('rating');
        return response()->json($formattedData);
    }

    public function update(Request $request, $id)
    {
        $brand = Marketing::findOrFail($id);
        $brand->update($request->all());
        $brand->pics()->sync($request->pics);
        $brand->picSign()->sync($request->picSign);
        return redirect()->route('brand.detailBrandByArea', $request->sumber_marketing_id)->with('message', 'Brand berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function destroy($id)
    {
        $brand = Marketing::findOrFail($id);
        $brand->delete();
        return redirect()->route('brand.detailBrandByArea', $brand->sumber_marketing_id)->with('message', 'Brand berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUp($id)
    {
        $brand = Marketing::findOrFail($id);
        return view('marketing.brand.followUp', compact('brand'));
    }

    public function followUpStore(Request $request, $id)
    {
        $brand = Marketing::findOrFail($id);
        $brand->followUp()->create($request->all());
        return redirect()->route('brand.followUp', $id)->with('message', 'Follow Up berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUpEdit($id)
    {
        $followUp = FollowUpMarketing::findOrFail($id);
        $formattedData = $followUp->toArray();
        $formattedData['status_raw'] = $followUp->getRawOriginal('status');
        return response()->json($formattedData);
    }

    public function followUpUpdate(Request $request, $id)
    {
        $followUp = FollowUpMarketing::findOrFail($id);
        $followUp->update($request->all());
        return redirect()->route('brand.followUp', $followUp->marketing_id)->with('message', 'Follow Up berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUpDestroy($id)
    {
        $followUp = FollowUpMarketing::findOrFail($id);
        $followUp->delete();
        return redirect()->route('brand.followUp', $followUp->marketing_id)->with('message', 'Follow Up berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function tampilBrand()
    {
        $marketings = Marketing::where('label', 'Brand')->orderBy('tanggal', 'desc')->get();
        return view('marketing.brand.viewBrand', compact('marketings'));
    }

    public function preview(Request $request)
    {
        $query = Marketing::with(['followUp', 'pics', 'picSign'])
            ->where('label', 'brand');

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

        return view('marketing.brand.report_brand', compact('data'));
    }

    public function export(Request $request)
    {
        if ($request->isMethod('post')) {
            $fileName = 'brand_' . date('Y-m-d') . '.xlsx';
            return Excel::download(
                new BrandExport($request->s_date, $request->e_date),
                $fileName
            );
        }

        return redirect()->route('brand.preview');
    }

    public function unduhTemplateImport(string $id)
    {
        $inputFileName = storage_path('app/public/template_import.xlsx');
        $reader = IOFactory::createReader('Xlsx');
        $spreedsheet = $reader->load($inputFileName);
        $sheet = $spreedsheet->getActiveSheet();

        $sheet->setCellValue('A2', $id);
        $sheet->setCellValue('H2', 'Brand');

        $writer = IOFactory::createWriter($spreedsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_brand.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function importBrand(Request $request)
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
