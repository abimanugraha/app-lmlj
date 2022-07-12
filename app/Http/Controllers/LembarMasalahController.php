<?php

namespace App\Http\Controllers;

use App\Models\LembarMasalah;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class LembarMasalahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lembarmasalah = LembarMasalah::orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'message' => 'Data lembarmasalah',
            'data' => $lembarmasalah,
        ];
        return response()->json($response, HttpFoundationResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nolmlj' => 'required',
            'namaproduk' => 'required',
            'nomorproduk' => 'required',
            'unittujuan' => 'required',
            'fotomasalah' => 'required',
            'detailmasalah' => 'required',
            'urgensi' => 'required',
            'namapembuat' => 'required',
            'unitpembuat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $lembarmasalah = LembarMasalah::create($request->all());

        try {
            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $lembarmasalah,
            ];

            return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal " . $e->errorInfo,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $lembarmasalah = lembarmasalah::where('id', $id)->firstOrFail();
        if (is_null($lembarmasalah)) {
            return $this->sendError('lembarmasalah tidak diemukan');
        }
        return response()->json([
            "success" => true,
            "message" => "Data lembarmasalah ditemukan.",
            "data" => $lembarmasalah,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $lembarmasalah = lembarmasalah::find($id);
        $lembarmasalah->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Data lembarmasalah telah diubah.",
            "data" => $lembarmasalah,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deletedRows = lembarmasalah::where('id', $id)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data lembarmasalah berhasil dihapus.",
            "data" => $deletedRows,
        ]);
    }
}
