<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Models\Lansia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class LansiaController extends Controller
{
    public function getLansia(): JsonResponse
    {
        $data = Lansia::select('id', 'nama')->orderBy('nama', 'asc')->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Lansia::select('*')->with('posko:id,rw,nama');
            return DataTables::of($data)
                ->filter(function (Builder $query) {
                    if (request()->has("posko_id")) {
                        $query->where("posko_id", request("posko_id"));
                    }

                    if (!empty(request()->has('search'))) {
                        $search = request("search");
                        $query->where(function ($query) use ($search) {
                            $model = new Lansia();
                            $columns = $model->getFillable();
                            foreach ($columns as $column) {
                                $query->orWhere($column, 'like', "%$search%");
                            }

                            $query->orWhereHas('posko', function ($query) use ($search) {
                                $query->where('nama', 'like', "%$search%");
                            });
                        });
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('lansia.index');
    }

    public function create()
    {
        return view('lansia.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required|unique:lansia',
            'jalan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'darah' => 'required',
            'tanggal_lahir' => 'required',
            'posko_id' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            FacadesAlert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $ibu = new Lansia();
            $ibu->nama = $request->nama;
            $ibu->nik = $request->nik;
            $ibu->tanggal_lahir = $request->tanggal_lahir;
            $ibu->darah = $request->darah;
            $ibu->jalan = $request->jalan;
            $ibu->rw = $request->rw;
            $ibu->rt = $request->rt;
            $ibu->posko_id = $request->posko_id;
            $ibu->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data lansia');
            return redirect()->route('lansia.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data lansia')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $lansia = Lansia::with(['posko:id'])->findOrFail($id);
        return view('lansia.edit', compact('lansia'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => ['required', function ($attribute, $value, $fail) use ($id) {
                $lansia = Lansia::findOrFail($id);

                if ($lansia->nik === $value) {
                    return;
                }

                $exists = Lansia::where('nik', $value)->where('id', '!=', $id)->exists();
                if ($exists) {
                    $fail('NIK telah digunakan');
                }
            }],
            'jalan' => 'required',
            'darah' => 'required',
            'tanggal_lahir' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'posko_id' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $lansia = Lansia::findOrFail($id);
            $lansia->nama = $request->nama;
            $lansia->nik = $request->nik;
            $lansia->jalan = $request->jalan;
            $lansia->darah = $request->darah;
            $lansia->tanggal_lahir = $request->tanggal_lahir;
            $lansia->rw = $request->rw;
            $lansia->rt = $request->rt;
            $lansia->posko_id = $request->posko_id;
            $lansia->save();
            DB::commit();

            Alert::success('Berhasil', 'Berhasil memperbaharui data lansia');
            return redirect()->route('lansia.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data lansia')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            Lansia::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data lansia');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data lansia')->autoclose(3000);
            return redirect()->back();
        }
    }
}
