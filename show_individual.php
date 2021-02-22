<?php
$pos_alumno = $_POST['pos_alumno_actual'] ?? $_GET['pos_alumno_actual'] ?? 0;
require"funciones.php";



session_start();
//He de venir de show.php. Pendiente asegurar esto ....

$dir_practica = $_SESSION['directorioPractica'];
// Listado de alumnos en un array
//
$dir_practicas = scandir($dir_practica);
quitar_ocultos($dir_practicas);


if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'Ejecutar práctica':
            $dir = $_POST['dir'];
            $dir_index = busca_index($dir);
            cerrar_ventana();
            header("Location:./$dir/$dir_index");
            exit();
        case 'Ver ficheros' :
            $dir_alumno = $_POST['directorioAlumno'];
            header("Location:ver_practica.php?directorioAlumno=$dir_alumno");
            exit;
        case 'Corrección':
            $dir_alumno = $_POST['directorioAlumno'];
            header("Location:correccion.php?directorioAlumno=$dir_alumno&pos_alumno=$pos_alumno");
            exit;
        case "Ver siguiente":
            $pos_alumno++;
            break;
        case "Ver actual"://Caso de que venga de visualizar un alumno
            $pos_alumno++;
            break;

        case "Volver listado Alumnos":
            //El dir prácticas lo tengo en variable de sesión
            header("Location:show.php");
            exit();
        case "Volver listado Prácticas":
            header("Location:index.php");
            exit();
            break;
    }
}
$dir_practica_alumno = "$dir_practica/$dir_practicas[$pos_alumno]";


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prácticas individual</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<fieldset>
    <legend>Opciones</legend>
    <form action="show_individual.php" method="POST">
        <input type="submit" value="Ver siguiente" name="submit" />
        <input type="submit" value="Volver listado Alumnos" name="submit" />
        <input type="submit" value="Volver listado Prácticas" name="submit" />
        <input type=hidden value='<?=$pos_alumno?>' name='pos_alumno_actual' />
    </form>
    <?php

    echo "<form action=show_individual.php method='POST' target='_blank'>";
    //Nos quedamos con el nombre del alumno que es
    //El dir del alumno dentro de la práctica
    $dir_alumno = basename($dir_practica_alumno);
    $dir_practica = dirname($dir_practica_alumno);
    $dir = "$dir_practica/$dir_alumno";

    //Le quitamos subrayado y ponemos mayúsculas la primera letra
    $alumno = ucwords(str_replace("_", " ", $dir_alumno));
    echo "<hr />";
    echo "<h3><span class=nombre>$alumno</span></h3>\n";
    echo "<input type=submit value='Ejecutar práctica' name=submit \>\n";
    echo "<input type=submit value='Ver ficheros' name=submit \>\n";
    echo "<input type=submit value='Corrección' name='submit' \><hr />\n";

    echo "<input type=hidden value='<?=$pos_alumno?>' name='pos_alumno_actual' />";

    echo "<input type=hidden value='$dir_practica' name='directorioPractica' \>\n";
    echo "<input type=hidden value='$dir_alumno' name='directorioAlumno' \>\n";
    echo "<input type=hidden value='$dir' name='dir' \>\n";


    echo "</form>";

    ?>
</body>
</html>
