<?php
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor/autoload.php';
require 'config/database.php';
?>
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

    <h1 id="titulo">BIENVENIDO AQUI PODRA REALIZAR EL REGISTRO DE LAS CALIFICACIONES</h1>
    <br>

<?php
$estudiantes = DB::table('estudiante')->get();

echo <<<_TABLA
    <table class='table is-bordered'id='CardFormulario'>
      <thead>
        <tr>
          <th>Número de registro</th>
          <th>Nombre del alumno</th>
        </tr>
       </thead>
_TABLA;

foreach ($estudiantes as $colum) {
    echo <<<_CONSULTA
    <tr>
         <td>$colum->idestudiante</td>
         <td>$colum->nombre_estudiante</td>
       </tr>
_CONSULTA;
}
echo <<<_TABLA
    </table>
    <br>
_TABLA;
?>
<?php 
$estudiantes = DB::table('estudiante')->get();
$asignatura = DB::table('asignaturas')->get();
?>
    
    <p class="subtitulos">Ingresar las calificaciones para cada asignatura</p>
    <br>

    <p id="datos">INGRESA LAS CALIFICACIONES:</p>
    <br>
    <div class="card card-width='100'" id="CardFormulario">
        <header class="card-header">
          <p class="card-header-title">
            Formulario de registro de calificaciones:
          </p>
        </header>
        <div class="card-content">
          <div class="content">
            <form action="api/index.php/calificacion" method="POST">
                <label for="calificacion">Calificación:</label>
                <input id="calificacion" class="input is-rounded" type="text" name="calificacion" placeholder="calificación">
                <label for="idestudiante">Número de lista:</label>
                <div class="control">
                    <div class="select is-info">
                        <select id="idestudiante" name="idestudiante" >
                            <?php
                              foreach ($estudiantes as $colum){
                                  echo "<option value='$colum->idestudiante'>{$colum->idestudiante}- {$colum->nombre_estudiante}</option>";
                              }
                            ?>
                        </select>
                    </div>
                </div>
                <label for="id_asignatura">Número de asignatura:</label>
                <div class="control">
                    <div class="select is-info">
                        <select id="id_asignatura" name="id_asignatura" >
                            <?php
                              foreach ($asignatura as $colum){
                                  echo "<option value='$colum->id_asignatura'>{$colum->id_asignatura}- {$colum->nombre_asignatura}</option>";
                              }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="botones">
                    <button type="button" class="button is-dark" onclick="calificacion_estudiante()">Ingresar calificaciones</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <br>
    <br>

    <script>
        function calificacion_estudiante (){
            var EstudianteSelect = document.getElementById("idestudiante")
            var selectestudiante = EstudianteSelect.options[EstudianteSelect.selectedIndex].value
            var AsignaturaSelect = document.getElementById("id_asignatura")
            var selectasignatura = AsignaturaSelect.options[AsignaturaSelect.selectedIndex].value
            axios.post('api/index.php/calificacion_estudiante', {
                calificacion: document.forms[0].calificacion.value,
                idestudiante: selectestudiante,
                id_asignatura: selectasignatura
            }).then(resp => {
                alert(`Se han insertado correctamente los datos de las calificaciones\nConsultemos las calificaciones`)
                setTimeout(`location. href='consultar_profesor.php'`, 500)
                console.log(resp)
            }).catch(error => {
                alert(`Los datos no se han ingresado correctamente, vuelva a intentarlo`)
            });
        }
    </script>
    
</body>
</html>