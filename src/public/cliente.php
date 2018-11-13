<?php
    include("nusoap.php");
    switch($_POST['operacion'])
    {
        case 1: //raiz
        $datos = array(
            'usu_email' => 'malag@unam.mx',
            'usu_passwd' => '1234.', 
            'numero' => $_POST['numero'],
        );

        
        $wsUrl="http://orion.dgsca.unam.mx/ms/server.php?wsdl";
        $metodo = "calcularRaiz";
        break;
        case 3: //resta
        $datos = array(
            'usu_email' => 'karla',
            'usu_passwd' => '1234.', 
            'valor1' => $_POST['numero'],
            'valor2' => $_POST['numero'],
        );
        $wsUrl="http://132.248.63.141/sitio1/phpmicroservices/server.php?wsdl";
        $metodo = "resta";
        break;        
        case 2: //expo
        $datos = array(
            'username' => 'usrexpo',
            'password' => '9542931e640c671a60ea44a954b249c179da1240', 
            'valor' => 2,
            'exponente' => 3,
        );
        $wsUrl="https://www.althek.com/ws/server.php?wsdl";
        $metodo = "obtenerRegistros";
        break;    
    }


    $cliente = new nusoap_client($wsUrl,'wsdl');
    $error = $cliente->getError();
    if ($error) 
    {
        echo "<strong>Error desde la apertura</strong>".$error;
    }
      
    $result = $cliente->call($metodo, array("datos" => json_encode($datos)));
    // print_r($cliente->response);
    if ($cliente->fault) {
        echo $result;
    }
    else {
        $error = $cliente->getError();
        if ($error) {
            echo "Error ".$error;
        }
        else {
            echo $result;
        }
    }
?>