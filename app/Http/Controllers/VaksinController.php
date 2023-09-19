<?php

namespace App\Http\Controllers;

use App\Models\Vaksin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class VaksinController extends Controller
{
    public function getVaksin()
    {
        $data = Vaksin::select('id', 'name')->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Vaksin::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('vaksin.index');
    }

    public function create()
    {
        return view('vaksin.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'variant' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $data = new Vaksin();
            $data->name = $request->name;
            $data->variant = $request->variant;
            $data->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data vaksin');
            return redirect()->route('vaksin.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data vaksin')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $data = Vaksin::findOrFail($id);
        return view('vaksin.edit', compact('data'), compact('id'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'variant' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $data = Vaksin::findOrFail($id);
            $data->name = $request->name;
            $data->variant = $request->variant;
            $data->update();

            Alert::success('Berhasil', 'Berhasil memperbaharui data vaksin');
            return redirect()->route('vaksin.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data vaksin')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        Vaksin::findOrFail($id)->delete();
        Alert::success('Berhasil', 'Berhasil menghapus data vaksin');
        return redirect()->back();
    }
}
