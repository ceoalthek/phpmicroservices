<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = '127.0.0.1';
$config['db']['user']   = 'root';
$config['db']['pass']   = '12345678';
$config['db']['dbname'] = 'mservicio';

$app = new \Slim\App(['settings' => $config]);


$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$container = $app->getContainer();
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// get all todos los cursos
$app->get('/curso', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM curso ORDER BY cur_nombre");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

//Nuevo curso
$app->post('/curso', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO curso (curso) VALUES (:curso)";
        $sth = $this->db->prepare($sql);
    $sth->bindParam("curso", $input['curso']);
    $sth->execute();
    $input['id'] = $this->db->lastInsertId();
    return $this->response->withJson($input);
});
    
$app->run();