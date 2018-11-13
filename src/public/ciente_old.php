<?php
    include("nusoap.php");

    $cliente = new nusoap_client("http://phpms.macross.mx/server.php?wsdl",'wsdl');
    $error = $cliente->getError();
    if ($error) 
    {
        echo "<strong>Error desde la apertura</strong>".$error;
    }
      
    $datos = array(
        'usu_email' => 'malag@unam.mx',
        'usu_passwd' => '1234.', 
        'numero' => 10,
    );
    
    $result = $cliente->call("calcularRaiz", array("datos" => json_encode($datos)));
    if ($cliente->fault) {
        echo "Fault: ";
        echo $result;
    }
    else {
        $error = $cliente->getError();
        if ($error) {
            echo "Error ".$error;
        }
        else {
            echo "Resultado de Consulta: <br/>";
            echo $result;
        }
    }
?>