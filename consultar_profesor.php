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
          <th>Eliminar</th>
          <th>Actualizar</th>
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
         <td><button class='button is-dark' type='button' onclick="eliminar($colum->idcalificacion)">Eliminar calificacion</button><br></td>
         <td>
            <form id='$colum->idcalificacion' method='POST'>
               <input id='id_calificacion' type='text' name='id_calificacion' value='{$colum->idcalificacion}' hidden>
               <label  size="5">Calificación:</label>
               <input id="calificacion" type="text" name="calificacion" size="5"><br>
               <button class='button is-dark' type='button' onclick="actualizar($colum->idcalificacion)">Actualizar calificacion</button><br>
           </form>
         </td>
       </tr>
_CONSULTA;
}
echo <<<_TABLA
    </table>
    <br>
    <br>
    <br>
_TABLA;

echo <<<_END
    <script>

    function eliminar(idcalificacion) {
        var form = document.getElementById(idcalificacion)
        axios.post('api/index.php/delete/'+ idcalificacion)
        .then(resp => {
            alert(`Se han eliminado correctamente los datos de las calificaciones`)
            console.log(resp)
        }).catch(error => {
            alert(`Los datos no se han podido eliminar`)
        });
    }

    function actualizar(idcalificacion) {
        var form = document.getElementById(idcalificacion)
        axios.post('api/index.php/update/'+ idcalificacion, {
            calificacion: form.calificacion.value
        }).then(resp => {
            alert(`Se han actualizado correctamente los datos de las calificaciones`)
            console.log(resp)
        }).catch(error => {
            alert(`Los datos no se han podido actualizar`)
        });
    }
    </script>
<br>
<br>
</body>
</html>
_END;