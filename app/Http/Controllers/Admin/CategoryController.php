<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tieude = 'Danh sách danh mục giày/áo';
        $query  = Category::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.categories.index', compact('categories', 'tieude'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm mới danh mục giày/áo';
        return view('admin.categories.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'unique:categories,name,|required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('image/categories', 'public');

            $validatedData['image'] = $imgPath;
        }


        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm mới danh mục thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        $title = 'Chi tiết danh mục: ' . $category->name;

        return view('admin.categories.show', compact('category', 'title')) ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $title = 'Chỉnh sửa danh mục: ' . $category->name;

        return view('admin.categories.edit', compact('category', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $imgPath = $request->file('image')->store('image/categories', 'public');
            $validatedData['image'] = $imgPath;
        }

        // Cập nhật dữ liệu
        $category->update($validatedData);


        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        // Xóa ảnh nếu có
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công.');
    }
}
