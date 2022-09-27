<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        try {
            $data = Role::all();
            return response()->json($data, 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {

            $data = Role::find($id);
            return response()->json($data, 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $data = Role::create($request->all());
            return response()->json($data, 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {

        try {

            $data = Role::find($id)->update($request->all());
            return response()->json($data, 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {

            $data = Role::find($id)->delete();
            return response()->json($data, 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
