<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use ProductWeb as GlobalProductWeb;

class ProductWebController extends Controller
{
    public function index()
    {
        $products = Product::paginate(20);
        // dd($products);
        return view('produk.index', compact('products'));
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        $produk = Product::find($id);
        if (!empty($produk)) {
            $produk->delete();
            return redirect(route('produk.index'))->with(['Success' => 'Produk Dihapus!']);
        }
        return redirect(route('produk.index'))->with(['Error' => 'Produk Ini Memiliki Anak Kategori!']);
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

            return view('produk.index', compact('product'));
        } catch (\Throwable $th) {
            return view('produk.index', compact('product'));
        }
    }
}
