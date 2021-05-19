<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($nameSpace, $view, $location)
    {
        $data = app($nameSpace)->all();
        return view($view)
            ->with('location', $location)
            ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create($view, $location, $relaciones)
    {
        $data = null;
        if ($relaciones != null) {
            //llamamos todos los modelos necesarios para crear nuevo registro
            foreach ($relaciones as $key => $value) {
                $array = app($key)->pluck($value['valor'], $value['clave']);
                if (count($array) > 0) {
                    $arrayFinal = null;
                    foreach ($array as $i => $v) {
                        $arrayFinal[$i] = $v;
                    }
                    $data[$key] = $arrayFinal;
                }
            }
        }
        return view($view)
            ->with('location', $location)
            ->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, $nameSpace, $path, $attributes, $auditoria)
    {
        $data = null;
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $attributes)) {
                $data[$key] = strtoupper($value);
            } else {
                $data[$key] = $value;
            }
        }
        $modelo = app($nameSpace)->create($data);
        if ($modelo != null) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "CREACIÓN DE " . $nameSpace . ". DATOS: ";
            foreach ($modelo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app($auditoria)->create($a);
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route($path);
        } else {
            flash("Error al guardar el registro")->error();
            return redirect()->route($path);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function storeWithParams(Request $request, $nameSpace, $path, $params, $attributes, $auditoria)
    {
        $data = null;
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $attributes)) {
                $data[$key] = strtoupper($value);
            } else {
                $data[$key] = $value;
            }
        }
        $modelo = app($nameSpace)->create($data);
        if ($modelo != null) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "CREACIÓN DE " . $nameSpace . ". DATOS: ";
            foreach ($modelo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app($auditoria)->create($a);
            flash("El registro fue almacenado de forma exitosa!")->success();
            return redirect()->route($path, $params);
        } else {
            flash("Error al guardar el registro")->error();
            return redirect()->route($path, $params);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($id, $nameSpace, $view, $location)
    {
        $data = app($nameSpace)->find($id);
        return view($view)
            ->with('location', $location)
            ->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function edit($id, $nameSpace, $view, $location, $relaciones)
    {
        $data = null;
        $model = app($nameSpace)->find($id);
        if ($relaciones != null) {
            //llamamos todos los modelos necesarios para editar registro
            foreach ($relaciones as $key => $value) {
                $array = app($key)->pluck($value['valor'], $value['clave']);
                if (count($array) > 0) {
                    $arrayFinal = null;
                    foreach ($array as $i => $v) {
                        $arrayFinal[$i] = $v;
                    }
                    $data[$key] = $arrayFinal;
                }
            }
        }
        return view($view)
            ->with('location', $location)
            ->with('data', $data)
            ->with('model', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, $id, $nameSpace, $route, $attributes, $auditoria)
    {
        $model = app($nameSpace)->find($id);
        $temp = new $nameSpace($model->attributesToArray());
        foreach ($model->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if (in_array($key, $attributes)) {
                    $model->$key = strtoupper($request->$key);
                } else {
                    $model->$key = $request->$key;
                }
            }
        }
        if ($model->save()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "EDICIÓN DE CONVOCATORIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($temp->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($model->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str . " - " . $str2;
            app($auditoria)->create($a);
            flash("El registro fue modificado de forma exitosa!")->success();
            return redirect()->route($route);
        } else {
            flash("Error al modificar el registro")->error();
            return redirect()->route($route);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function updateWithParams(Request $request, $id, $nameSpace, $route, $params, $attributes, $auditoria)
    {
        $model = app($nameSpace)->find($id);
        $temp = new $nameSpace($model->attributesToArray());
        foreach ($model->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if (in_array($key, $attributes)) {
                    $model->$key = strtoupper($request->$key);
                } else {
                    $model->$key = $request->$key;
                }
            }
        }
        if ($model->save()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "INSERTAR";
            $str = "EDICIÓN DE CONVOCATORIA. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($temp->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($model->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str . " - " . $str2;
            app($auditoria)->create($a);
            flash("El registro fue modificado de forma exitosa!")->success();
            return redirect()->route($route, $params);
        } else {
            flash("Error al modificar el registro")->error();
            return redirect()->route($route, $params);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($id, $nameSpace, $path, $relations, $auditoria)
    {
        $modelo = app($nameSpace)->find($id);
        if ($relations != null) {
            foreach ($relations as $r) {
                if ($r != null) {
                    $rel = $modelo->$r;
                    if ($rel != null) {
                        if (count($rel) > 0) {
                            flash("El registro no puede ser aliminado porque tiene relación con " . $r)->warning();
                            return redirect()->route($path);
                        }
                    }
                }
            }
        }
        if ($modelo->delete()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "ELIMINAR";
            $str = "ELIMINACIÓN DE " . $nameSpace . ". DATOS ELIMINADOS: ";
            foreach ($modelo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app($auditoria)->create($a);
            flash("El registro fue eliminado de forma exitosa!")->success();
            return redirect()->route($path);
        } else {
            flash("Error al eliminar el registro")->error();
            return redirect()->route($path);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroyWithParams($id, $nameSpace, $path, $params, $relations, $auditoria)
    {
        $modelo = app($nameSpace)->find($id);
        if ($relations != null) {
            foreach ($relations as $r) {
                if ($r != null) {
                    $rel = $modelo->$r;
                    if ($rel != null) {
                        if (count($rel) > 0) {
                            flash("El registro no puede ser aliminado porque tiene relación con " . $r)->warning();
                            return redirect()->route($path, $params);
                        }
                    }
                }
            }
        }
        if ($modelo->delete()) {
            $u = Auth::user();
            $a['usuario'] = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $a['operacion'] = "ELIMINAR";
            $str = "ELIMINACIÓN DE " . $nameSpace . ". DATOS ELIMINADOS: ";
            foreach ($modelo->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $a['detalles'] = $str;
            app($auditoria)->create($a);
            flash("El registro fue eliminado de forma exitosa!")->success();
            return redirect()->route($path, $params);
        } else {
            flash("Error al eliminar el registro")->error();
            return redirect()->route($path, $params);
        }
    }
}
