<?php


namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB as FacadesDB;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');

        if (request()->q != '') {
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }
        $product = $product->paginate(10);
        return response()->json([
            $product
        ]);
    }

    public function show($id)
    {
        $product = Product::where('user_id', $id)->get();
        
        return $this->sendResponse('Success', 'Tampilan', $product, 200);
    }

    // public function watch($id)
    // {
    //     $product = product::find($id);
    //     if (!$product) {

    //         return $this->sendResponse('Error', 'Gagal mengambil data', null, 500);
    //     }
    //     return $this->sendResponse('Success', 'Berhasil mengambil data', $product, 200);
    // }

    public function create()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.create', compact('category'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            // 'user_id' => 'required',
            'description' => 'required',
            'category_id' => '|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg' 
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');

        //     $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
        //     // $file->storeAs('public/products', $filename);
        //     $request->image->move(public_path('product'), $filename);
        // }

        $filename = null;

        if ($request->image) {
            // $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
            // $request->image->move(public_path('img'), $image);

            $img = base64_encode(file_get_contents($request->image));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            // dd($array);
            $filename = $array->image->file->resource->chain->image;

            // dd($filename);
        }
        
        $product = Product::create([
            'name' => $request->name,
            // 'user_id' => $request->user_id,
            'slug' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $filename,
            'price' => $request->price,
            'weight' => $request->weight,
            'status' => $request->status
        ]);
        try {
            $product->save();
            $product = Product::all();

            return $this->sendResponse('Success', 'berhasil menambah data', $product, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal menambah data', null, 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            File::delete(public_path('product/' . $product->image));
            return $this->sendResponse('Success', 'Berhasil menghapus data', $product, 200);
        }
        return $this->sendResponse('Error', 'Gagal menghapus data', null, 500);
    }


    public function edit($id)
    {
        $product = product::find($id);
        if (!$product) {

            return $this->sendResponse('Error', 'Gagal mengambil data', null, 500);
        }
        return $this->sendResponse('Success', 'Berhasil mengambil data', $product, 200);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id', 
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }

        $product = Product::find($id); 
        // $filename = $product->image; 

        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
        //     // $file->storeAs('public/products', $filename);
        //     $request->image->move(public_path('product'), $filename);
        //     File::delete(storage_path('product/' . $product->image));
        // }

        $filename = null;

        if ($request->image) {
            // $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
            // $request->image->move(public_path('img'), $image);

            $img = base64_encode(file_get_contents($request->image));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            // dd($array);
            $filename = $array->image->file->resource->chain->image;

            // dd($filename);
        }

        //KEMUDIAN UPDATE PRODUK TERSEBUT
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'image' => $filename
        ]);
        try {
            $product->save();
            $product = Product::all();

            return $this->sendResponse('Success', 'berhasil mengganti data', $product, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal mengganti data', null, 500);
        }
    }

    public function cari(Request $request)
    {
        $search = $request->get('search');
        $products = DB::table('product')->where('name', 'LIKE', '%' . $search . '%')->paginate();

        if (!$products) {
            return $this->sendResponse('Error', 'Barang tidak ada', NULL, 404);
        }

    }
    public function getSeller()
    {
        $products = Product::where('customer_id', Auth::user()->id)->get();
        if (empty($products)) {
            return $this->sendResponse('Error', 'tidak ada product', NULL, 404);
        }
        return $this->sendResponse('Success', 'product tersedia', $products, 200);
    }
}