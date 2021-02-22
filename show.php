<?php

session_start();
//En caso de venir del index leo de $_POST
//En caso de venir de show o corregir, leo de sesion
//@var $directorioPractica Nombre del proyecto, dir que lo contiene

require_once "vendor/autoload.php";
Use Utilidades\Fichero as Fichero;
Use Utilidades\Plantilla as Plantilla;
$practica=$_POST['practica'] ?? $_SESSION['practica'];
$_SESSION['practica']=$practica;

$opcion = $_POST['submit']??null;

switch ($opcion) {
    case 'Ejecutar práctica':
        $practica = $_POST['practica'];
        $alumno = $_POST['alumno'];
        header("Location:./practicas/$practica/$alumno");
        exit;
    case 'Listado de prácticas':
        header("Location:index.php");
        exit;
    case 'Ver ficheros' :
        $alumno=$_POST['alumno'];
        Plantilla::cerrar_ventana();
        header("Location:ver_practica.php?alumno=$alumno");
        exit;
    case 'Corrección':
        $alumno=$_POST['alumno'];
        $posicion = $_POST['posicion'];
        Plantilla::cerrar_ventana();
        header("Location:correccion.php?alumno=$alumno&posicion=$posicion");
        exit;

    default: //Vengo del index, el submit es el nombre del proyecto
        try {
            $practicas = Fichero::getContenidoDir("practicas/".$practica);
        }catch (\Utilidades\ExceptionFichero $e) {
            $error = "Error!! " . $e->getMessage();
        }
        $listadoPracticas = Plantilla::getListadoAlumnosPracticasShow($practicas, $practica);
        break;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilo.css" type="text/css">
</head>
<body>
<h1><?=$error ??null ?></h1>
<h2>Listado de prácticas de alumnos</h2>
<fieldset>
    <legend>Opciones</legend>
    <form action="show_individual.php" method="POST">
        <input type="submit" value="Mostrar de forma individual">
    </form>
    <form action="index.php" method="POST">
        <input type="submit" value="Listado de prácticas">
    </form>

</fieldset>
<fieldset>
    <legend>Selecciona práctica</legend>
    <ol>"
     <?=$listadoPracticas?>
    </ol>"

    ?>
</fieldset>

</body>
</html>
