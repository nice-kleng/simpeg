<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Product', only: ['index']),
            new Middleware('permission:Create Product', only: ['store']),
            new Middleware('permission:Edit Product', only: ['update']),
            new Middleware('permission:Delete Product', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::all();
            return DataTables::of($products)
                ->addIndexColumn('DT_RowIndex')
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('product.edit', $row->kd_product) . '" class="edit btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteData(this)" data-url="' . route('product.destroy', $row->kd_product) . '" class="btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('superadmin.product.product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kd_product' => 'required|unique:products,kd_product',
            'nama_product' => 'required',
            'stock' => 'required',
        ], [
            'kd_product.required' => 'Kode Product harus diisi',
            'kd_product.unique' => 'Kode Product sudah ada',
            'nama_product.required' => 'Nama Product harus diisi',
            'stock.required' => 'Stock harus diisi',
        ]);

        Product::create($request->all());
        return redirect()->route('product.index')->with('message', 'Data berhasil ditambahkan')->with('title', 'Berhasil')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('superadmin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'kd_product' => 'required|unique:products,kd_product,' . $product->kd_product,
            'nama_product' => 'required',
            'stock' => 'required',
        ], [
            'kd_product.required' => 'Kode Product harus diisi',
            'kd_product.unique' => 'Kode Product sudah ada',
            'nama_product.required' => 'Nama Product harus diisi',
            'stock.required' => 'Stock harus diisi',
        ]);

        $product->update($request->all());
        return redirect()->route('product.index')->with('message', 'Data berhasil diupdate')->with('title', 'Berhasil')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('message', 'Data berhasil dihapus')->with('title', 'Berhasil')->with('type', 'success');
    }
}
