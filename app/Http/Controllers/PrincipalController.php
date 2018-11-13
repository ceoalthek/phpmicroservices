<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tabla;
use App\Http\Controllers\Controller;

class PrincipalController extends Controller {
    public function index() {
        $status = 200;
        try {
            $this->respuesta['data'] = Tabla::orderBy('id', 'asc')->get();
        } catch(Exception $e) {
            $this->respuesta['status'] = "1";
            $this->respuesta['msj'] = $e->getMessage();
        } finally {
            return response()->json($this->respuesta, 200);
        }
    }

    public function insertar(Request $request) {
        $data = $request->json()->all();
        try {
            if(count($data) > 0) {
                $tabla = new Tabla();
                $tabla->fill($data);
                if (count($tabla->getAttributes()) > 0) {
                    $this->respuesta['data'] = Tabla::create($data);
                } else {
                    $this->respuesta['status'] = "2";
                    $this->respuesta['msj'] = "Debes rellenar los datos";
                }
            }
        } catch(Exception $e) {
            $this->respuesta['status'] = "1";
            $this->respuesta['msj'] = $e->getMessage();
        } finally {
            return response()->json($this->respuesta, 200);
        }
    }

    public function webservice() {
        $cliente = new \nusoap_client("http://www.dneonline.com/calculator.asmx?WSDL",'wsdl');
        var_dump($cliente);
    }
}