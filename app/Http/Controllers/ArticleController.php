<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ArticleController extends Controller
{
    protected $path = 'article/';

    public function publicArticle(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $data = Article::where('title', 'like', '%' . $search . '%')->paginate(5);
        } else {
            $data = Article::paginate(5);
        }
        return view('article', compact('data'));
    }

    public function publicArticleDetail($slug)
    {
        $data = Article::where('slug', $slug)->first();
        $articles = Article::where('slug', '!=', $slug)->limit(5)->get();
        return view('article_detail', compact('data'), compact('articles'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Article::select('*')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('article.index');
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            if ($validated->fails()) {
                $errors = $validated->errors();
                Alert::error('Gagal', $errors->first())->autoclose(3000);
                return redirect()->back()->withInput($request->all());
            }

            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;

            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $article = new Article();
            if ($request->hasFile('image')) {
                $item = $request->file('image');
                $ext = $item->getClientOriginalExtension();
                $uniqueString = uniqid();
                $filename = 'article-' . time() . '-' . $uniqueString . '.' . $ext;
                Storage::disk('public')->putFileAs($this->path, $item, $filename);
                $article->image = $filename;
            }
            $article->title = $request->title;
            $article->slug = $slug;
            $article->content = $request->content;
            $article->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data artikel')->autoclose(5000);
            return redirect()->route('article.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal ', 'Gagal menambahkan atikel')->autoclose(5000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $data = Article::findOrFail($id);
        return view('article.edit', compact('data'), compact('id'));
    }

    public function preview($slug)
    {
        $data = Article::where('slug', $slug)->first();
        return view('article.preview', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
            ]);

            if ($validated->fails()) {
                $errors = $validated->errors();
                Alert::error('Gagal', $errors->first())->autoclose(3000);
                return redirect()->back()->withInput($request->all());
            }

            $article = Article::findOrFail($id);
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($this->path . $article->image)) {
                    Storage::disk('public')->delete($this->path . $article->image);
                }

                $item = $request->file('image');
                $ext = $item->getClientOriginalExtension();
                $uniqueString = uniqid();
                $filename = 'article-' . time() . '-' . $uniqueString . '.' . $ext;
                Storage::disk('public')->putFileAs($this->path, $item, $filename);
                $article->image = $filename;
            }

            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;

            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $article->title = $request->title;
            $article->slug = $slug;
            $article->content = $request->content;
            $article->update();

            Alert::success('Berhasil', 'Berhasil memperbaharui data artikel')->autoclose(5000);
            return redirect()->route('article.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data artikel')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            if ($article->image && Storage::disk('public')->exists($this->path . $article->image)) {
                Storage::disk('public')->delete($this->path . $article->image);
            }
            $article->delete();

            Alert::success('Berhasil', 'Berhasil menghapus data artikel')->autoclose(5000);
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Berhasil menghapus data artikel')->autoclose(5000);
            return redirect()->back();
        }
    }
}
