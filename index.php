<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$app = AppFactory::create();
$app->setBasePath("/act_calificacionesv4/api/index.php");
$app->addErrorMiddleware(true, false, false);

// Add route callbacks
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Hello world!');
    return $response;
});

$app->post('/login/{usuario}', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $user = DB::table('usuarios')
    ->leftJoin('perfiles', 'usuarios.idperfil', '=', 'perfiles.idperfil')
    ->where('usuarios.nombre_usuario', $args['usuario'])
    ->first();

    $msg = new stdClass();

    if ($user->password_proporcionado == $data->password){
        $msg->aceptado = true;
        $msg->nombreperfil = $user->nombreperfil;
        $msg->nombre_usuario = $user->nombre_usuario;
        $msg->idusuario = $user->idusuarios;
    } else {
        $msg->aceptado = false;
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/estudiantes', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $id = DB::table('estudiante')->insertGetId([
        'nombre_estudiante' => $data->nombre_estudiante,
        'correo_electronico' => $data->correo_electronico,
        'idusuarios' => $data->idusuarios,
    ]);
    $msg = new stdClass();
    $msg->aceptado = !empty($id);
    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/asignaturas', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $id = DB::table('asignaturas')->insertGetId([
        'nombre_asignatura' => $data->nombre_asignatura,
    ]);
    $msg = new stdClass();
    $msg->aceptado = !empty($id);
    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/calificacion_estudiante', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $id = DB::table('calificaciones')->insertGetId([
        'calificacion' => $data->calificacion,
        'idestudiante' => $data->idestudiante,
        'id_asignatura' => $data->id_asignatura,
    ]);
    $msg = new stdClass();
    $msg->aceptado = !empty($id);
    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/delete/{id_calificacion}', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);
    DB::table('calificaciones')->where('idcalificacion', $args['id_calificacion'])->delete();
    $msg = 'Se elimino exitosamente';

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/update/{id_calificacion}', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);
    $id = DB::table('calificaciones')
    ->where('idcalificacion', $args['id_calificacion'])
    ->update([
        'calificacion' => $data->calificacion,
    ]);
    $msg = new stdClass();
    $msg->aceptado = !empty($id);
    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->run();