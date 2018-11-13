<?php
    include("nusoap.php");

    function conectar()
    {
        try{
            $s = new PDO('mysql:host=127.0.0.1;dbname=phpms', "phpms", "phpms123.",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            return $s;
        }catch(PDOException $e) {
            echo 'Falló la Conexión: '.$e->getMessage();
        }
    }

    function login($datos)
    {
        $conn = conectar();
        try{
            $query = sprintf("SELECT * FROM usuario WHERE usu_passwd='%s' AND usu_email='%s'",$datos['usu_passwd'],$datos['usu_email']);
            $result = $conn->query($query);
            if ($result->fetchColumn() > 0)
            {
                $aux['error'] = ""; //Mensaje de Exito
                $aux['code'] = "0"; //Código de Exito
            }
            else
            {
                $aux['error'] = "¡Datos de Acceso Equivocados!"; 
                $aux['code'] = "-1";                
            }
            $conn = null; //Para cerrar la conexión a la base de datos.
            return json_encode($aux);
        }catch(PDOException $e) {
            $aux['error'] = $e->getMessage(); //Mensaje de Error en la Consulta
            $aux['code'] = "-2"; //Error de Consulta            
            $conn = null; //Para cerrar la conexión a la base de datos.
            return json_encode($aux);
        }
    }

    function calcularRaiz($datos)
    {
        $datos = json_decode($datos, true);
        login($datos);
        $numero = $datos['numero'];
        $raiz=sqrt($numero);
        $respuesta['exito']=1;
        $respuesta['numero']=$numero;
        $respuesta['resultado'] = $raiz;
        return json_encode($respuesta);

    }
      
    $server = new soap_server();
    $server->configureWSDL("registros", "urn:registros");

    $server->register("calcularRaiz",
        array("datos" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:registros",
        "urn:registros#calcularRaiz",
        "rpc",
        "encoded",
        "Calcula Raíz de");


    $server->service(file_get_contents("php://input"));
?>