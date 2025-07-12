<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class NewsController extends Controller
{
    public function index()
    {
        $query = News::query();

        $news = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug',
            'content' => 'required|string',
            'thumbnail'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $imgPath = $request->file('thumbnail')->store('thumbnail/news', 'public');
            $validatedData['thumbnail'] = $imgPath;
        }

        News::create($validatedData);

        return redirect()->route('admin.news.index')->with('success', 'Thêm bài viết thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $new = News::findOrFail($id);

        return view('admin.news.edit', compact('new'));
    }


    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug,' . $news->id,
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

         $news->update([

            'slug' => Str::slug($request->name),
            
        ]);

        // Chỉ xử lý thumbnail khi có file mới được upload
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có
            if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)) {
                Storage::disk('public')->delete($news->thumbnail);
            }

            // Upload ảnh mới
            $imgPath = $request->file('thumbnail')->store('thumbnail/news', 'public');
            $validatedData['thumbnail'] = $imgPath;
        } else {
            // Nếu không có file mới, loại bỏ thumbnail khỏi validatedData
            // để giữ nguyên giá trị cũ trong database
            unset($validatedData['thumbnail']);
        }

        $news->update($validatedData);

        return redirect()->route('admin.news.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Xóa bài viết thành công.');
    }

    public function trash()
    {
        $news = News::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);

        return view('admin.news.trash', compact('news'));
    }

    public function restore($id)
    {
        $news = News::withTrashed()->findOrFail($id);
        $news->restore();

        return redirect()->route('admin.news.trash')->with('success', 'Khôi phục bài viết thành công.');
    }

    public function forceDelete($id)
    {
        $news = News::withTrashed()->findOrFail($id);

        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->forceDelete();

        return redirect()->route('admin.news.trash')->with('success', 'Xóa vĩnh viễn bài viết thành công.');
    }
}
