<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'message' => 'Data user',
            'data' => $user,
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
        //
        // $data = json_decode($request->getContent(), false);
        $data = $request->getContent();
        // $data = $request->getContent();
        
        $response = [
            'data' => $request->input('username')
        ];
        return $data['username'];
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required',
        //     'password' => 'required',
        //     'role' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(
        //         $validator->errors(),
        //         HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY
        //     );
        // }

        // try {
        //     $user = User::create($request->all());

        //     $response = [
        //         'message' => 'Berhasil disimpan',
        //         'data' => $user,
        //     ];

        //     return response()->json($response, HttpFoundationResponse::HTTP_CREATED);
        // } catch (QueryException $e) {
        //     return response()->json([
        //         'message' => "Gagal " . $e->errorInfo,
        //     ]);
        // }
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
    }
}
