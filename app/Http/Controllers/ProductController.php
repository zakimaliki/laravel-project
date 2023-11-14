<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;




class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan parameter dari request
        $query = $request->input('query');
        $order = $request->input('order', 'name');
        $sort = $request->input('sort', 'asc');

        $ipAddress = $request->ip(); // Mendapatkan alamat IP dari request
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang terotentikasi
        // Menulis pesan log
        Log::info('User Name ' . $user->name . ' accessed: ' . $request->url());
        Log::info('Index method called with query: ' . $query . ', order: ' . $order . ', sort: ' . $sort. 'user IP:'.$ipAddress);

        // Mengambil data produk dan melakukan operasi lainnya
        $products = Product::where($order, 'like', '%' . $query . '%')
                        ->orderBy($order, $sort)
                        ->paginate(5);

        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Menulis pesan log
        Log::info('Search method called with query: ' . $query);

        // Mencari produk berdasarkan query
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(5);

        return view('products.index', compact('products'));
    }

        public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $user = Auth::user();

        // Menulis pesan log
        Log::info('User Name ' . $user->name . ' accessed: ' . $request->url());

        // Menulis pesan log
        Log::info('Product created: ' . $request->name);

        // Simpan produk ke database
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
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Mengambil produk berdasarkan ID
        $product = Product::find($id);

        // Update produk
        $product->update($request->all());
        $user = Auth::user();

        // Menulis pesan log
        Log::info('User Name ' . $user->name . ' accessed: ' . $request->url());
        // Menulis pesan log
        Log::info('Product updated: ' . $request->name);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        // Mengambil produk berdasarkan ID
        $product = Product::find($id);
        
        // Hapus produk
        $product->delete();

        $user = Auth::user();

        // Menulis pesan log
        Log::info('User Name ' . $user->name . ' accessed: ' . $request->url());

        // Menulis pesan log
        Log::info('Product deleted: ' . $id);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function list_product()
    {
        // Mengambil daftar produk
        $products = Product::all();

        // Menulis pesan log
        Log::info('Listed all products');

        return response()->json($products);
    }

    public function detail_product($id)
    {
        // Mengambil produk berdasarkan ID
        $product = Product::find($id);

        // Menulis pesan log
        if (!$product) {
            Log::warning('Product not found with ID: ' . $id);
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        Log::info('Viewed product with ID: ' . $id);

        return response()->json($product);
    }

    public function create_product(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Menulis pesan log
        Log::info('Product created: ' . $request->name);

        // Simpan produk ke database
        Product::create($request->all());

        return response()->json(['message' => 'Produk berhasil disimpan'], 201);
    }

    public function update_product(Request $request, $id)
    {
        // Mengambil produk berdasarkan ID
        $product = Product::find($id);
        if (!$product) {
            // Menulis pesan log
            Log::warning('Product not found with ID: ' . $id);
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Update produk
        $product->update($request->all());

        // Menulis pesan log
        Log::info('Product updated: ' . $request->name);

        return response()->json(['message' => 'Produk berhasil diupdate'], 200);
    }

    public function delete_product($id)
    {
        // Mengambil produk berdasarkan ID
        $product = Product::find($id);
        if (!$product) {
            // Menulis pesan log
            Log::warning('Product not found with ID: ' . $id);
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus produk
        $product->delete();

        // Menulis pesan log
        Log::info('Product deleted with ID: ' . $id);

        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }

 public function upload(Request $request)
    {
        // Periksa apakah file ada dalam permintaan
        if ($request->hasFile('file')) {
            // Dapatkan file dari permintaan
            $file = $request->file('file');

            // Tentukan direktori penyimpanan di dalam storage/app/public
            $uploadPath = storage_path('app/public/uploads');

            // Bangun nama unik untuk file
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Pindahkan file ke direktori penyimpanan
            $file->move($uploadPath, $fileName);

            // Proses lain yang mungkin Anda perlukan

            // Simpan path file di dalam storage
            $filePath = 'uploads/' . $fileName;

            return response()->json(['message' => 'File uploaded successfully', 'file_path' => $filePath]);
        }

        return response()->json(['message' => 'No file provided'], 400);
    }
}