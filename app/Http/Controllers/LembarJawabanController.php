<?php

namespace App\Http\Controllers;

use App\Models\LembarJawaban;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class LembarJawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lembarjawaban = LembarJawaban::orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'message' => 'Data lembarjawaban',
            'data' => $lembarjawaban,
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
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $lembarjawaban = lembarjawaban::create($request->all());

        try {
            $response = [
                'message' => 'Berhasil disimpan',
                'data' => $lembarjawaban,
            ];

            return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal ".$e->errorInfo,
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
        $lembarjawaban = lembarjawaban::where('id', $id)->firstOrFail();
        if (is_null($lembarjawaban)) {
            return $this->sendError('lembarjawaban tidak diemukan');
        }
        return response()->json([
            "success" => true,
            "message" => "Data lembarjawaban ditemukan.",
            "data" => $lembarjawaban,
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
        $lembarjawaban = lembarjawaban::find($id);
        $lembarjawaban->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Data lembarjawaban telah diubah.",
            "data" => $lembarjawaban,
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
        $deletedRows = lembarjawaban::where('id', $id)->delete();
        return response()->json([
            "success" => true,
            "message" => "Data lembarjawaban berhasil dihapus.",
            "data" => $deletedRows,
        ]);
    }
}
