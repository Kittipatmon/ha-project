<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\datacenter\News;
use Illuminate\Support\Facades\File; // เรียกใช้ Facade File เพื่อใช้ลบไฟล์

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = News::orderBy('published_date', 'desc')->get();
        return view('backend.news.index', compact('newsItems'));
    }

    public function newsAll()
    {
        $newsItems = News::where('is_active', true)
            ->orderBy('published_date', 'desc')
            ->get();

        return view('backend.news.newsall', compact('newsItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'link_news' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file_news' => 'nullable|array',
            'file_news.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5120',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid('img_') . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/news'), $filename);
                $imagePaths[] = 'images/news/' . $filename;
            }
        }

        $fileNewsPaths = [];
        if ($request->hasFile('file_news')) {
            foreach ($request->file('file_news') as $file) {
                $filename = time() . '_' . uniqid('file_') . '_' . $file->getClientOriginalName();
                $file->move(public_path('files/news'), $filename);
                $fileNewsPaths[] = 'files/news/' . $filename;
            }
        }

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'published_date' => $request->published_date,
            'is_active' => $request->has('is_active'),
            'image_path' => $imagePaths,
            'file_news' => $fileNewsPaths,
            'link_news' => $request->link_news,
        ]);

        return response()->json($news);
    }

    public function edit(News $news)
    {
        return response()->json($news);
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'link_news' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file_news' => 'nullable|array',
            'file_news.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5120',
        ]);

        // Normalize existing paths to arrays
        $existingImages = is_array($news->image_path) ? $news->image_path : ($news->image_path ? [$news->image_path] : []);
        $existingFiles = is_array($news->file_news) ? $news->file_news : ($news->file_news ? [$news->file_news] : []);

        $newImagePaths = $existingImages;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid('img_') . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/news'), $filename);
                $newImagePaths[] = 'images/news/' . $filename;
            }
        }

        $newFilePaths = $existingFiles;
        if ($request->hasFile('file_news')) {
            foreach ($request->file('file_news') as $file) {
                $filename = time() . '_' . uniqid('file_') . '_' . $file->getClientOriginalName();
                $file->move(public_path('files/news'), $filename);
                $newFilePaths[] = 'files/news/' . $filename;
            }
        }

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'published_date' => $request->published_date,
            'is_active' => $request->has('is_active'),
            'image_path' => $newImagePaths,
            'file_news' => $newFilePaths,
            'link_news' => $request->link_news,
        ]);

        return response()->json($news);
    }

    public function destroy(News $news)
    {
        // ลบรูป (รองรับหลายไฟล์)
        $imagePaths = is_array($news->image_path) ? $news->image_path : ($news->image_path ? [$news->image_path] : []);
        foreach ($imagePaths as $img) {
            if ($img && File::exists(public_path($img))) {
                File::delete(public_path($img));
            }
        }

        // ลบไฟล์แนบ (รองรับหลายไฟล์)
        $filePaths = is_array($news->file_news) ? $news->file_news : ($news->file_news ? [$news->file_news] : []);
        foreach ($filePaths as $fp) {
            if ($fp && File::exists(public_path($fp))) {
                File::delete(public_path($fp));
            }
        }
        
        $news->delete();
        return response()->json(['success' => 'News deleted successfully.']);
    }

    public function detail($id)
    {
        $news = News::findOrFail($id);
        return view('backend.news.detail', compact('news'));
    }
}