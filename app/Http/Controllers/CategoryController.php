<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::with(['parent'])->orderBy('created_at', 'DESC')->paginate(10);
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();

        return view('categories.index', compact('category', 'parent'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories'
        ]);

        $request->request->add(['slug' => $request->name]);
        Category::create($request->except('_token'));
        return redirect(route('category.index'))->with(['success' => 'Kategori Baru Ditambahkan!']);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();
        return view('categories.edit', compact('category', 'parent'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories,name,' . $id
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
        return redirect(route('category.index'))->with(['success' => 'Kategori Diperbaharui!']);
    }

    public function destroy($id)
    {
        $category = Category::withCount(['child', 'product'])->find($id);
        if ($category->child_count == 0 && $category->product_count == 0) {
            $category->delete();
            return redirect(route('category.index'))->with(['success' => 'Kategori Dihapus!']);
        }
        return redirect(route('category.index'))->with(['error' => 'Kategori Ini Memiliki Anak Kategori!']);
    }

    public function parent()
    {
        //KARENA RELASINYA DENGAN DIRINYA SENDIRI, MAKA CLASS MODEL DIDALM belongsTo() ADALAH NAMA CLASSNYA SENDIRI YAKNI CATEGORY
        //belongsTo DIGUNAKAN UNTUK REFLEKSI KE DATA INDUKNYA
        return $this->belongsTo(Category::class);
    }

    //UNTUK LOCAL SCOPE NAMA METHODNYA DIAWAL DENGAN KATA scope DAN DIIKUTI DENGAN NAMA METHOD YANG DIINGINKAN
    //CONTOH: scopeNamaMethod()
    public function scopeGetParent($query)
    {
        //SEMUA QUERY YANG MENGGUNAKAN LOCAL SCOPE INI AKAN SECARA OTOMATIS DITAMBAHKAN KONDISI whereNul('parent_id')
        return $query->whereNull('parent_id');
    }

    
}
