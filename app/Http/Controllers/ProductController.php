<?php

// namespace App\Http\Controllers;

// use App\Product;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

// class ProductController extends Controller
// {
//     public function index()
//     {
//         $product = Product::all();
//         if (!$product) {
//             # code...
//             return $this->sendResponse('Error', 'Not Found', NULL, 404);
//         }
//         return $this->sendResponse('Success', 'data found', $product, 200);
//     }

//     public function store(Request $request, Product $products)
//     {
//         $validator = Validator::make($request->all(), [
//             'name' => 'required|string|max:100',
//             'category_id' => 'required|exists:category,id',
//             'description' => 'required|string',
//             'image' => 'required|mimes:png,jpeg,jpg',
//             'price' => 'required|integer',
//             'weight' => 'required|integer'
//         ]);

//         if ($validator->fails()) {
//             # code...
//             return response($validator->errors());
//         }
//         $products->name = $request->name;
//         $products->category_id = $request->category_id;
//         $products->description = $request->description;
//         $products->image = $request->image;
//         $products->price = $request->price;
//         $products->weight = $request->weight;

//         try {
//             $products->save();
            
//             return $this->sendResponse('Success', 'Data Found', $products, 200);
//         } catch (\Throwable $th) {
//             //throw $th;
//             return $this->sendResponse('Error', 'Data not found', NULL, 404);
//         }
//     }

//     public function show($id)
//     {
//         $product = Product::find($id);

//         if (!$product) {
//             # code...
//             return $this->sendResponse('Error', 'Not Found', NULL, 404);
//         }
//         return $this->sendResponse('Success', 'Data ditampilkan', $product, 200);
//     }

//     public function destroy($id)
//     {
//         $product = Product::find($id);

//         if ($product) {
//             # code...
//             $product->delete();
//             return $this->sendResponse('Success', 'deleted successfully', $product, 200);
//         }
//         return $this->sendResponse('Error', 'not erased', NULL, 404);
//     }

//     public function update(Request $request, $id)
//     {
//         $validator = Validator::make($request->all(),[
//             'name' => 'required|string|max:100',
//             'category_id' => 'required|exists:categories,id',
//             'description' => 'required|text',
//             'image' => 'required|mimes:png,jpeg,jpg',
//             'price' => 'required|integer',
//             'weight' => 'required|integer'
//         ]);

//         if ($validator->fails()) {
//             # code...
//             return response($validator->errors());
//         }

//         $products = Product::find($id);

//         if (!$products) {
//             # code...
//             return $this->sendResponse('Error', 'ID tidak ditemukan', NULL, 404);
//         }

//         $products->name = $request->name;
//         $products->category_id = $request->category_id;
//         $products->description = $request->description;
//         $products->image = $request->image;
//         $products->price = $request->price;
//         $products->weight = $request->weight;

//         try {
//             $products->save();

//             return $this->sendResponse('Success', 'Berhasil di Update', $products, 200);
//         } catch (\Throwable $th) {
//             return $this->sendResponse('Error', 'Gagal TERUPDATE', NULL, 404);
//         }
//     }
// }



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

    public function create()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.create', compact('category'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
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
    
    public function search(Request $request)
    {

        $search = $request->get('search');
        $product = DB::table('product')->where('name', 'LIKE', '%' . $search . '%')->paginate();
        // return view('welcome', compact('blog'));
    }
}