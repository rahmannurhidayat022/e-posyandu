<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    protected $path = 'gallery/';

    public function publicGallery()
    {
        $galleries = Gallery::paginate(9);
        return view('galeri', compact('galleries'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::select('*')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('gallery.index');
    }

    public function add()
    {
        return view('gallery.add');
    }

    public function edit($id)
    {
        $data = Gallery::findOrFail($id);
        return view('gallery.edit', compact('data'), compact('id'));
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'caption' => 'nullable',
                'images' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validated->fails()) {
                $errors = $validated->errors();
                Alert::error('Gagal', $errors->first())->autoclose(3000);
                return redirect()->back()->withInput($request->all());
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $item) {
                    $ext = $item->getClientOriginalExtension();
                    $uniqueString = uniqid();
                    $filename = 'gallery-' . time() . '-' . $uniqueString . '.' . $ext;
                    Storage::disk('public')->putFileAs($this->path, $item, $filename);
                    Gallery::create([
                        'caption' => $request->caption,
                        'image' => $filename,
                    ]);
                }
            }
            Alert::success('Berhasil', 'Berhasil menambahkan data galeri');
            return redirect()->route('gallery.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data galeri')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = Validator::make($request->all(), [
                'caption' => 'nullable',
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validated->fails()) {
                $errors = $validated->errors();
                Alert::error('Gagal', $errors->first())->autoclose(3000);
                return redirect()->back()->withInput($request->all());
            }

            $data = Gallery::findOrFail($id);
            if ($request->hasFile('image')) {
                $path = $this->path . $data->image;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }

                $item = $request->file('image');
                $ext = $item->getClientOriginalExtension();
                $uniqueString = uniqid();
                $filename = 'gallery-' . time() . '-' . $uniqueString . '.' . $ext;
                Storage::disk('public')->putFileAs($this->path, $item, $filename);
                $data->image = $filename;
            }

            $data->caption = $request->caption;
            $data->update();

            Alert::success('Berhasil', 'Berhasil memperbaharui data galeri');
            return redirect()->route('gallery.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan memperbaharui data galeri')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Gallery::findOrFail($id);
            $url_path =  $this->path . $data->image;
            if (Storage::disk('public')->exists($url_path)) {
                Storage::disk('public')->delete($url_path);
            } else {
                throw new \Exception('File tidak ditemukan');
            }

            $data->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data galeri');
            return redirect()->route('gallery.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan menghapus data galeri')->autoclose(3000);
            return redirect()->route('gallery.index');
        }
    }
}
