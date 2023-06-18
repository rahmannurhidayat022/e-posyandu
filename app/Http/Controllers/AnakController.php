<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Models\Anak;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class AnakController extends Controller
{
    public function getAnak()
    {
        $data = Anak::select('id', 'nama')->with('ibu:nama')->orderBy('nama', 'asc')->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Anak::select('*')->with('ibu:id,nama,ayah')->with('posko:id,nama,rw');
            return DataTables::of($data)
                ->filter(function (Builder $query) {
                    if (request()->has("posko_id")) {
                        $query->where("posko_id", request("posko_id"));
                    }

                    if (!empty(request()->has('search'))) {
                        $search = request("search");
                        $query->where(function ($query) use ($search) {
                            $model = new Anak();
                            $columns = $model->getFillable();
                            foreach ($columns as $column) {
                                $query->orWhere($column, 'like', "%$search%");
                            }

                            $query->orWhereHas('ibu', function ($query) use ($search) {
                                $query->where('nama', 'like', "%$search%");
                            });

                            $query->orWhereHas('posko', function ($query) use ($search) {
                                $query->where('nama', 'like', "%$search%");
                            });
                        });
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('anak.index');
    }

    public function create()
    {
        return view('anak.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'nullable|unique:anak',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'bb' => 'required',
            'tb' => 'required',
            'posko_id' => 'required',
            'ibu_id' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            FacadesAlert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $anak = new Anak();
            $anak->nama = $request->nama;
            $anak->nik = $request->nik;
            $anak->jenis_kelamin = $request->jenis_kelamin;
            $anak->tanggal_lahir = $request->tanggal_lahir;
            $anak->bb = $request->bb;
            $anak->tb = $request->tb;
            $anak->posko_id = $request->posko_id;
            $anak->ibu_id = $request->ibu_id;
            $anak->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data anak');
            return redirect()->route('anak.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $anak = Anak::with(['posko:id', 'ibu:id,nama,ayah'])->findOrFail($id);
        return view('anak.edit', compact('anak'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => ['nullable', function ($attribute, $value, $fail) use ($id) {
                $anak = Anak::findOrFail($id);

                if ($anak->nik === $value) {
                    return;
                }

                $exists = Anak::where('nik', $value)->where('id', '!=', $id)->exists();
                if ($exists) {
                    $fail('NIK telah digunakan');
                }
            }],
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'bb' => 'nullable',
            'tb' => 'nullable',
            'ibu_id' => 'required',
            'posko_id' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $anak = Anak::findOrFail($id);
            $anak->nama = $request->nama;
            $anak->nik = $request->nik;
            $anak->jenis_kelamin = $request->jenis_kelamin;
            $anak->tanggal_lahir = $request->tanggal_lahir;
            $anak->bb = $request->bb;
            $anak->tb = $request->tb;
            $anak->posko_id = $request->posko_id;
            $anak->ibu_id = $request->ibu_id;
            $anak->save();

            Alert::success('Berhasil', 'Berhasil memperbaharui data anak');
            return redirect()->route('anak.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            Anak::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data anak');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data anak')->autoclose(3000);
            return redirect()->back();
        }
    }
}
