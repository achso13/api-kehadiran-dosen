<?php

namespace App\Http\Controllers;

use App\Helpers\FormatHelpers;
use App\Http\Resources\AbsensiResource;
use App\Http\Resources\DosenResource;
use App\Models\Absensi;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function validateAbsensi()
    {
        return Validator::make(request()->all(), [
            'id_dosen' => 'required|exists:dosen,id',
            'status' => 'required|boolean',
            'waktu_hadir' => 'required',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absensi = AbsensiResource::collection(Absensi::all());

        return response()->json([
            'message' => 'success',
            'data' => $absensi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validateAbsensi();

        if ($validator->fails()) {
            return response()->json([
                'message' => "failed",
                'errors' => FormatHelpers::formatErrors($validator),
            ], 422);
        }

        $data = [
            'status' => $request->input('status'),
            'waktu_hadir' => $request->input('waktu_hadir'),
        ];

        // $absensi = Absensi::create($data);
        $dosen = Dosen::where('id', $request->input('id_dosen'))->update($data);

        $dosenUpdated = new DosenResource(Dosen::find($request->input('id_dosen')));

        return response()->json([
            'message' => "success",
            'data' => $dosenUpdated,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
