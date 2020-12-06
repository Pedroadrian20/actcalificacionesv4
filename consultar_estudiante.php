<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor/autoload.php';
require 'config/database.php';

echo <<<_INIT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisro de calificaciones</title>
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="diseños/calificacion.css">
    <script src="node_modules/axios/dist/axios.min.js"></script>
    <style>
        body{
            background-image: url("Imagenes/fondoescuela.png");
            background-size: cover;
        }
        .encabezado3{
            background-image: url("Imagenes/fondoescuela.png");
            background-size: cover;
        }
    </style>
</head>
<body>
_INIT;

echo <<<_MAIN
    <header class="encabezado3">
        <div class="columns">
            <div class="column">
                <figure class="image is-128x128">
                    <img class="is-rounded" src="Imagenes/Logoprimitivo.png">
                </figure>
            </div>
            <div class="column" id="titulohead3">
              ESCUELA PRIMITIVO ALONSO IMEE CAMPESTREE
            </div>
            <div class="column">
              </div>
        </div>
    </header>

    <h1 id="titulo">BIENVENIDO AQUI PODRA VER EL REGISTRO DE LAS CALIFICACIONES</h1>
    <br>
    
    <p class="subtitulos">CALIFICACIONES:</p>
    <br>
_MAIN;

$calificaciones = DB::table('calificaciones')
->leftJoin('estudiante', 'calificaciones.idestudiante', '=', 'estudiante.idestudiante')
->leftJoin('asignaturas', 'calificaciones.id_asignatura', '=', 'asignaturas.id_asignatura')
->get();

echo <<<_TABLA
    <table class='table is-bordered'id='tablacalificaciones'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre del alumno</th>
          <th>Asignatura</th>
          <th>Calificación</th>
        </tr>
       </thead>
_TABLA;

foreach ($calificaciones as $colum) {
    echo <<<_CONSULTA
    <tr>
         <td>$colum->idcalificacion</td>
         <td>$colum->nombre_estudiante</td>
         <td>$colum->nombre_asignatura</td>
         <td>$colum->calificacion</td>
       </tr>
_CONSULTA;
}
echo <<<_TABLA
    </table>
    <br>
    <br>
    <br>
<br>
</body>
</html>
_TABLA;