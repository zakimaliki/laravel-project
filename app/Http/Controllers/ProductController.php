<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    $products = Product::paginate(5); // Menampilkan 10 produk per halaman
    return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::find($id); // Mengambil produk berdasarkan ID
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id); // Mengambil produk berdasarkan ID
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::find($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
        // Menampilkan daftar produk
        public function list_product()
        {
            $products = Product::all();
            return response()->json($products);
        }
    
        // Menampilkan detail produk berdasarkan ID
        public function detail_product($id)
        {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }
            return response()->json($product);
        }
    
        // Menyimpan produk baru
        public function create_product(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
            ]);
    
            Product::create($request->all());
    
            return response()->json(['message' => 'Produk berhasil disimpan'], 201);
        }
    
        // Mengupdate produk berdasarkan ID
        public function update_product(Request $request, $id)
        {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
            ]);

            $product->update($request->all());
    
            return response()->json(['message' => 'Produk berhasil diupdate'], 200);
        }
    
        // Menghapus produk berdasarkan ID
        public function delete_product($id)
        {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            }
    
            $product->delete();
    
            return response()->json(['message' => 'Produk berhasil dihapus'], 200);
        }
}