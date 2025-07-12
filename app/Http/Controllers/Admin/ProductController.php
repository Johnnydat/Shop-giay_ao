<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tieude = 'Danh sách sản phẩm';
        $query = Product::with('category');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products', 'tieude'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm mới sản phẩm';
        $categories = Category::where('status', 1)->get();

        return view('admin.products.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'unique:products,name,|required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('image/products', 'public');
            $validatedData['image'] = $imgPath;
        }
        // Create the product
        Product::create($validatedData);
        // Redirect to the index page with success message
        return redirect()->route('admin.products.index')->with('success', 'Thêm mới sản phẩm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        
        $title = 'Chi tiết sản phẩm: ' . $product->name;

        return view('admin.products.show', compact('product', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);
        $title = 'Chỉnh sửa sản phẩm: ' . $product->name;
        $categories = Category::all();
        // $categories = Category::where('status', 1)->get();

        // Return the edit view with the product data
        return view('admin.products.edit', compact('product', 'title', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('image/products', 'public');
            $validatedData['image'] = $imgPath;
        }

        // Update the product
        $product->update($validatedData);

        // Redirect to the index page with success message
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
    }
}
