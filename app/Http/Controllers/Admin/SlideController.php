<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index(Request $request)
    {
        $tieude = 'Danh sách slide';
        $slides = Slide::orderBy('id', 'DESC')->paginate(5);
        return view('admin.slides.index', compact('tieude', 'slides'));
    }

    public function create()
    {
        $tieude = 'Thêm mới slide';
        return view('admin.slides.create', compact('tieude'));
    }

    public function store(Request $request)
    {
        $validateData =  $request->validate([
            'name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('uploads/slides', 'public');
            $validateData['image'] = $imgPath;
        }

        Slide::create($validateData);

        return redirect()->route('admin.slides.index')->with('success', 'Slide đã được thêm thành công.');
    }

    public function edit($id)
    {
        $tieude = 'Chỉnh sửa slide';
        $slide = Slide::findOrFail($id);
        return view('admin.slides.edit', compact('tieude', 'slide'));
    }

    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);

        $validateData =  $request->validate([
            'name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/slides', 'public');
            $validateData['image'] = $imagePath;

            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
        }

        $slide->update($validateData);

        return redirect()->route('admin.slides.index')->with('success', 'Slide đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide đã được xóa thành công.');
    }

    public function show($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slides.show', compact('slide'));
    }
}
