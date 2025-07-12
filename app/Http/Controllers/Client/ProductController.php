<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách sản phẩm';

        $query = Product::with(['category' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $categories = Category::where('status', 1)->get();

        $slides = Slide::where('status', 1)->orderByDesc('id')->get();

        $mostViewedProducts = Product::where('status', 1)
            ->orderByDesc('views')
            ->take(10)
            ->get();

        $products = $query->orderByDesc('id')->paginate(12);

        return view('client.home', compact(
            'title',
            'products',
            'categories',
            'slides',
            'mostViewedProducts'
        ));
    }


    public function show(Product $product)
    {
        $product->increment('views');

        // if ($product->status != 1 || $product->category->status != 1) {
        //     abort(404);
        // }
        $title = 'Trang chi tiết sản phẩm';

        // Lấy các sản phẩm cùng danh mục
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('status', 1)
            ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
            ->get();

        // Lấy các bình luận của sản phẩm
        $comments = $product->comments()
            ->with([
                'user',
                'replies' => function ($query) {
                    $query->with('user')->where('status', 'active');
                }
            ])
            ->where('status', 'active')
            ->whereNull('parent_id')
            ->latest()
            ->get();
        return view('client.detail', compact(
            'title',
            'product',
            'relatedProducts',
            'comments'
        ));
    }

    public function storeComment(Request $request, Product $product)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = new Comment([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'status' => 'active',
        ]);

        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã được đăng thành công.');
    }


    public function search(Request $request)
    {
        $searchTerm = $request->input('querry');
        $selectedCategory = $request->input('category_id');

        if (empty($searchTerm)) {
            return redirect()->route('shop');
        }

        $defaultMaxprice = 10000000; // Giá tối đa mặc định
        $maxPrice = $request->input('max_price', $defaultMaxprice);
        $minPrice = $request->input('min_price', 0);

        // các mức lọc giá mới theo yêu cầu
        $priceRanges = [
            'duoi-500k' => ['min' => 0, 'max' => 500000],
            '500k-1tr' => ['min' => 500000, 'max' => 1000000],
            '1tr-5tr' => ['min' => 1000000, 'max' => 5000000],
            'tren-5tr' => ['min' => 5000000, 'max' => $defaultMaxprice],
        ];

        //áp dụng bộ lọc giá nếu có
        if ($request->has('price_range') && array_key_exists($request->price_range, $priceRanges)) {
            $range = $priceRanges[$request->price_range];
            $minPrice = $range['min'];
            $maxPrice = $range['max'];
        }

        // Chỉ tìm kiếm sản phẩm và danh mục đang hoạt động
        $query = Product::with([
            'category' => function ($q) {
                $q->where('status', 1);
            }
        ])
            ->where('status', 1)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($q) use ($searchTerm) {
                        $q->where('status', 1)
                            ->where('name', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->whereBetween('price', [$minPrice, $maxPrice]);

        if (!empty($selectedCategory)) {
            $query->whereIn('category_id', $selectedCategory);
        }

        $query->orderByDesc('id');
        $products = $query->latest()->paginate(12);

        $categories = Category::where('status', 1)->get();

        return view('client.search', [
            'products' => $products,
            'searchTerm' => $searchTerm,
            'categories' => $categories,
            'title' => $searchTerm . " - Tìm kiếm trên SoleMate",
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'priceRanges' => $priceRanges,
            'selectedPriceRange' => $request->price_range,
            'selectedCategories' => $selectedCategory,
            'isSearchPage' => true,
        ]);
    }


    public function shop(Request $request)
    {
        // chỉ lấy sản phẩm và danh mục đang hoạt động

        $query = Product::with(['category' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1);

        //Lọc theo khoảng giá nếu có
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 10000000); // Giá tối đa mặc định
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        // Lọc theo danh mục nếu có   
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->input('categories', []));
        }

        $query->orderByDesc('id');

        // Tính lại max price cho thanh lọc
        $defaultMaxPrice = 10000000;
        $maxPriceInResults = (float)$query->max('price') ?? $defaultMaxPrice;

        $products = $query->paginate(12);

        // Các mức lọc giá mới theo yêu cầu
        $priceRanges = [
            'duoi-500k' => ['min' => 0, 'max' => 500000],
            '500k-1m' => ['min' => 500000, 'max' => 1000000],
            '1m-5m' => ['min' => 1000000, 'max' => 5000000],
            'tren-5m' => ['min' => 5000000, 'max' => 100000000],
        ];

        // Xác định khoảng giá được chọn
        $selectedPriceRange = $request->input('price_range');

        // Chỉ lấy danh mục đang hoạt động
        $categories = Category::where('status', 1)->get();

        return view('client.shop', [
            'products' => $products,
            'categories' => $categories,
            'title' => 'Cửa hàng',
            'minPrice' => $request->input('min_price', 0),
            'maxPrice' => $request->input('max_price', $maxPriceInResults),
            'priceRanges' => $priceRanges,
            'selectedPriceRange' => $selectedPriceRange,
            'selectedCategories' => $request->input('categories', []),
            'isSearchPage' => false,
        ]);
    }
}
