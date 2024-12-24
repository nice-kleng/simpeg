<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\FollowUpMarketing;
use App\Models\Marketing;
use App\Models\SumberMarketing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class LeadsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Leads', only: ['index']),
            new Middleware('permission:Create Leads', only: ['store']),
            new Middleware('permission:Update Leads', only: ['update']),
            new Middleware('permission:Delete Leads', only: ['destroy']),
            new Middleware('permission:Follow Up Leads', only: ['followUp', 'followUpStore', 'followUpEdit', 'followUpUpdate', 'followUpDestroy']),
        ];
    }

    public function index()
    {
        $sumberMarketings = SumberMarketing::where('label', 'Leads')
            ->withCount(['marketings' => function ($query) {
                $query->where('label', 'Leads');
            }])
            ->orderBy('nama_sumber_marketing', 'asc')
            ->get();
        return view('marketing.leads.leads', compact('sumberMarketings'));
    }

    public function detailLeadsByArea($id)
    {
        $sumberMarketing = SumberMarketing::findOrFail($id);
        $pegawai = User::role('Marketing')->get();
        return view('marketing.leads.detailLeadsByArea', compact('sumberMarketing', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pics' => 'required|array',
            'pics.*' => 'exists:users,id',
        ]);

        $pics = $request->pics ?? [];
        $picSign = $request->pic_sign ?? [];
        // if (!Auth::user()->hasRole('Super Admin') || !Auth::user()->hasPermissionTo('View Marketing Kadiv Dashboard')) {
        if (!Auth::user()->hasRole('Super Admin')) {
            $pics[] = Auth::user()->id;
            $picSign[] = Auth::user()->id;
        }
        $pics = array_unique($pics);
        $picSign = array_unique($picSign);

        $request->merge(['akun_id' => Auth::user()->id]);
        $leads = Marketing::create($request->all());
        $leads->pics()->attach($pics);
        $leads->picSign()->attach($picSign);

        return redirect()->route('leads.detailLeadsByArea', $request->sumber_marketing_id)->with('message', 'Leads berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function edit($id)
    {
        $leads = Marketing::findOrFail($id);
        $leads->load('pics');
        $formattedData = $leads->toArray();
        $formattedData['pics'] = $leads->pics->pluck('id')->toArray();
        $formattedData['picSign'] = $leads->picSign->pluck('id')->toArray();
        $formattedData['rating_raw'] = $leads->getRawOriginal('rating');
        return response()->json($formattedData);
    }

    public function update(Request $request, $id)
    {
        $leads = Marketing::findOrFail($id);
        $leads->update($request->all());
        $leads->pics()->sync($request->pics);
        $leads->picSign()->sync($request->picSign);
        return redirect()->route('leads.detailLeadsByArea', $request->sumber_marketing_id)->with('message', 'Leads berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function destroy($id)
    {
        $leads = Marketing::findOrFail($id);
        $leads->delete();
        return redirect()->route('leads.detailLeadsByArea', $leads->sumber_marketing_id)->with('message', 'Leads berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUp($id)
    {
        $leads = Marketing::findOrFail($id);
        return view('marketing.leads.followUp', compact('leads'));
    }

    public function followUpStore(Request $request, $id)
    {
        $leads = Marketing::findOrFail($id);
        $leads->followUp()->create($request->all());
        return redirect()->route('leads.followUp', $id)->with('message', 'Follow Up berhasil ditambahkan')->with('type', 'success')->with('title', 'Berhasil');
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
        return redirect()->route('leads.followUp', $followUp->marketing_id)->with('message', 'Follow Up berhasil diubah')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function followUpDestroy($id)
    {
        $followUp = FollowUpMarketing::findOrFail($id);
        $followUp->delete();
        return redirect()->route('leads.followUp', $followUp->marketing_id)->with('message', 'Follow Up berhasil dihapus')->with('type', 'success')->with('title', 'Berhasil');
    }

    public function tampilLeads()
    {
        $marketings = Marketing::where('label', 'Leads')->orderBy('tanggal', 'desc')->get();
        return view('marketing.leads.viewLeads', compact('marketings'));
    }
}
