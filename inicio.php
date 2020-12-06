<?php 
use Illuminate\Database\Capsule\Manager as DB;

require 'vendor/autoload.php';
require 'config/database.php';

$user = DB::table('usuarios')
    ->leftJoin('perfiles', 'usuarios.idperfil', '=', 'perfiles.idperfil')
    ->where('usuarios.idusuarios', $_GET['idusuario'])->first();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Principal Escuela</title>
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="diseños/pagprincipal.css">
    <style>
        body{
            background-image: url("Imagenes/fondoescuela.png");
            background-size: cover;
        }

        .encabezado{
            background-image: url("Imagenes/fondoescuela.png");
            background-size: cover;
        }
    </style>
</head>
<body>
    <header class="encabezado">
        <div class="columns">
            <div class="column">
                <figure class="image is-128x128">
                    <img class="is-rounded" src="Imagenes/Logoprimitivo.png">
                </figure>
            </div>
            <div class="column" id="titulohead">
              ESCUELA PRIMITIVO ALONSO IMEE CAMPESTREE
            </div>
            <div class="column">
              </div>
        </div>
    </header>
    
    <br>
    <h1 id="titulo">BIENVENIDO A LA PÁGINA DE LA ESCUELA PRIMITIVO ALONSO IMEE CAMPESTREE</h1>
    <br>

    <?php if ($user->nombreperfil == 'Profesor') { ?>
        <p class="subtitulos">Bienvenido profesor, toque el siguiente botón para realizar la insercion de las calificaciones:</p>
        <br>
        <button class="button is-dark" type="button" id="botones"><a href="insertar_asignaturas.html">Ingresar Asignaturas</a></button>
    <?php } ?>

    <?php if ($user->nombreperfil == 'Estudiante') { ?>
        <p class="subtitulos">Bienvenido estudiante, toque el siguiente botón para registrarte:</p>
        <br>
        <button class="button is-dark" type="button" id="botones"><a href="pag_estudiante.html">Registrarse</a></button>
    <?php } ?>
    <br>
    <br>
    <figure class="image is-180x180" id="Imagen">
        <img src="Imagenes/primitivo.png">
    </figure>
    <br>

</body>
</html>