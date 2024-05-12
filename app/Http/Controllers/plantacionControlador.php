<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class plantacionControlador extends Controller
{
    function create(Request $request)

    {

        $validator = Validator::make($request->all(), [
            'id_usuario_fk' => 'required',
            'fecha' => 'required|date',
            'estado' => 'required',
            'tipo' => 'required'
        ]);

        if ($validator->fails()) {
            $result = [
                'message' => 'Error en la validación de los datos ' . $request,
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($result, 400);
        }

        $query = "INSERT INTO plantacion (id_usuario_fk, fecha, id_estado_fk, id_tipo_fk) VALUES (?, ?, ?, ?)";
        $data = [
            $request->input('id_usuario_fk'),
            $request->input('fecha'),
            $request->input('estado'),
            $request->input('tipo')
        ];
        try {
            DB::insert($query, $data);
        } catch (\Exception $e) {
            $result = ['message' => 'No se pudo crear la plantación', 'status' => 500];
            return response()->json($result, 500);
        }
        $result = ['message' => 'Usuario creado correctamente', 'status' => 201];
        return response()->json($result, 201);
    }

    function showAll($id)
    {
        $query = "select * from plantacion where id_usuario_fk=?;";
        $data = [$id];

        try {
            $resultQuery = DB::select($query, $data);
        } catch (\Exception $e) {
            $result = ['message' => 'Plantaciones no encontradas', 'status' => 500];
            return response()->json($result, 404);
        }

        if (empty($resultQuery)) {
            $result = ['message' => 'No hay plantaciones para este usuario', 'status' => 200];
            return response()->json($result, 200);
        }

        $result = ['Plantaciones' => $resultQuery, 'status' => 200];
        return response()->json($result, 200);
    }

    function showTypes()
    {
        $query = "SELECT * FROM tipo;";

        try {
            $resultQuery = DB::select($query);
        } catch (\Exception $e) {
            $result = ['message' => 'Tipos no encontrados', 'status' => 500];
            return response()->json($result, 404);
        }

        if (empty($resultQuery)) {
            $result = ['message' => 'No hay tipos almacenados', 'status' => 200];
            return response()->json($result, 200);
        }

        $result = ['Tipos' => $resultQuery, 'status' => 200];
        return response()->json($result, 200);
    }

    function show($id_usuario, $id_plantacion)
    {
        $query = "SELECT * FROM plantacion WHERE id = ? AND id_usuario_fk = ?";
        $data = [$id_plantacion, $id_usuario];

        try {
            $resultQuery = DB::selectOne($query, $data);
        } catch (\Exception $e) {
            $result = ['message' => 'Plantación no encontrada', 'status' => 500];
            return response()->json($result, 404);
        }

        if (!$resultQuery) {
            $result = ['message' => 'Plantación no encontrada o no pertenece al usuario', 'status' => 404];
            return response()->json($result, 404);
        }

        $result = ['Plantación' => $resultQuery, 'status' => 200];
        return response()->json($result, 200);
    }

    function delete($id)
    {
        $querySelect = "Select * from  plantacion where id=?";
        $queryDelete = "Delete from plantacion where id=?";
        $data = [$id];
        try {
            $user = DB::select($querySelect, $data);
            if (!$user) {
                $result = ['message' => 'Plantación no encontrada', 'status' => 404];
                return response()->json($result, 404);
            }
            DB::delete($queryDelete, $data);
            $result = ['message' => 'Plantación eliminada', 'status' => 200];
            return response()->json($result, 200);
        } catch (\Exception $e) {
            $result = ['message' => 'Error', 'status' => 500];
            return response()->json($result, 500);
        }
    }

    function update(Request $request, $id)
    {
        $querySelect = "SELECT * FROM plantacion WHERE id=?";
        $data = [$id];
        try {
            $planta = DB::selectOne($querySelect, $data);
            if (!$planta) {
                $result = ['message' => 'Plantacion no encontrada', 'status' => 404];
                return response()->json($result, 404);
            }
            $fecha = $request->input('fecha', $planta->fecha);
            $estado = $request->input('estado', $planta->id_estado_fk);
            $tipo = $request->input('tipo', $planta->id_tipo_fk);

            $queryUpdate = "UPDATE plantacion SET fecha = ?, id_estado_fk = ?, id_tipo_fk = ? WHERE id=?";
            $data = [$fecha, $estado, $tipo, $id];
            try {
                $update = DB::update($queryUpdate, $data);
            } catch (\Exception $e) {
                $result = ['message' => 'No se pudo actualizar la plantación', 'status' => 500];
                return response()->json($result, 500);
            }
            $result = ['message' => 'Plantación actualizada', 'status' => 200];
            return response()->json($result, 200);
        } catch (\Exception $e) {
            $result = ['message' => 'Error: ' . $e->getMessage(), 'status' => 500];
            return response()->json($result, 500);
        }
    }
}
