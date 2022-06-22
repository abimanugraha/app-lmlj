<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $student = Student::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $student], 200);
        } else {
            $students = Student::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $students], 200);
        }
    }

    function store(StudentRequest $request)
    {
        $student = Student::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $student], 201);
    }

    function update($id, StudentRequest $request)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $student], 200);
    }

    function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
