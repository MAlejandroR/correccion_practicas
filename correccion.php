<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/**
 * //RF1 Corrección
 * //RF1.1
 * // obtener un listado de check según se establezcan en el ini  de la corrección del proyecto
 * //sección Ejecución
 * //RF1.2
 * si guardar:
 * leo los checkbox seleccoinados
 * construyo un mensaje con nota, correcion y checkbox seleccionados (esto para msj)
 * Anoto todo en el ini
 *
 *
 */
require_once "./vendor/autoload.php";


use Utilidades\Plantilla as Plantilla;
use Utilidades\Fichero as Fichero;

//IOnicializamos varialbes que pueden ser referenciadas sin tener valor para evitar warning
$correccion = "";
$error = "";

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//ini_set('error_reporting', E_ALL);
//Obtener variables de sesión
session_start();

$practica = $_SESSION['practica'] ?? null;
//var_dump($practica);
if (is_null($practica)) {
    header("index.php?msj=No se ha leído ninguna prácica");
    exit();
}

$alumno = $_GET['alumno'] ?? $_POST['alumno'] ?? "";
$posicion = $_GET['posicion'] ?? $_POST['posicion'] ?? 0;

//


try {
    $criteriosCorreccionPractica = Fichero::getDatosFicheroIni("practicas/$practica", "criterios.ini");


} catch (\Utilidades\ExceptionFichero $e) {
    $error .= "Error en correccion.php " . $e->getMessage() . "<br />";
    $criteriosCorreccionPractica['Ejecucion'] = [];
}
//var_dump($criterios);

$stringCriteriosConCheckCorregidos = Plantilla::generarCheckbox("criterios", $criteriosCorreccionPractica['Ejecucion']);

//MRM Tengo que leer la ejecución y actulizar los chceck según esté o no esa opcion
$opcion = $_POST['submit'] ?? null;

switch ($opcion) {
    case 'guardar':
        //Leo valores establecidoiis
        $nota = trim($_POST['nota']);
        $comentarios = trim($_POST['contenido']);
        $stringCriteriosSeleccionados = Plantilla::getValueCheckbox('criterios');
        $correcion = <<<FIN
NOTA=$nota\n
CORRECCION="$comentarios"\n
EJECUCION="$stringCriteriosSeleccionados"\n
FIN;
        try {
            Fichero::writeln("practicas/$practica/$alumno/correccion.ini", $correcion);
        } catch (\Utilidades\ExceptionFichero $error) {
            $error .= "Error!!! " . $error->getMessage() . "<br />";
        }
        break;
    case 'volver':
        header("Location:show.php");
        exit();
    case "volver a $alumno":
        header("Location:show_individual.php?posicionAlumnoActual=$posicionAlumnoActual");
        exit();
   case "Escribir en Word":
       $nota = trim($_POST['nota']);
       $comentarios = explode ("\r\n",$_POST['contenido']);
       $comentarios=serialize($comentarios);

       header("Location:writeWord.php?practica=$practica&alumno=$alumno&comentarios=$comentarios&nota=$nota");
//       header("Location:writeWord.php?comentarios=$comentarios");
       exit;


}


if (file_exists("practicas/$practica/$alumno/correccion.ini")) {
    try {

        $contenido = Fichero::getDatosFicheroIni("practicas/$practica/$alumno", 'correccion.ini');
//        var_dump($contenido);
        $nota = $contenido ['NOTA'];
        $correccion = $contenido ['CORRECCION'];
        $criteriosCorregidos = $contenido ['EJECUCION'];
        $stringCriteriosConCheckCorregidos = Plantilla::generarCheckbox("criterios", $criteriosCorreccionPractica['Ejecucion'], $criteriosCorregidos);
    } catch (\Utilidades\ExceptionFichero $e) {
        $error = "Error!! " . $e->getMessage();
    }


}
$stringCriteriosConCheckCorregidos = $stringCriteriosConCheckCorregidos ?? $selectCriterios ?? "No se han detectado criterios de correción ";


$htmlPractica = ucwords(str_replace("_", " ", $practica));
$htmlAlumno = $htmlAlumno ?? ucwords(str_replace("_", " ", $alumno));
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
<h1><?= $error ?></h1>
<fieldset>
    <legend>Comentarios</legend>
    <h4>Práctica <span style="color:#701ba7"><?= $htmlPractica ?> </span></h4>
    <h4>Alumno <span style="color:#701ba7"><?= $htmlAlumno ?></span></h4>


    <form action="correccion.php" method="POST">
        <fieldset>
            <legend>Critero de correción de esta práctica</legend>
            <?= $stringCriteriosConCheckCorregidos ?>
        </fieldset>
        <label for="nota">Nota</label> <input type="text" name="nota" value="<?= $nota ?? '' ?>" id="">
        <br/>
        <label for="contenido">Corrección</label>
        <textarea name="contenido" cols="100" rows="10">
            <?= $correccion ?? "" ?>
        </textarea>
        <br/>
        <input type="submit" value="guardar" name="submit">
        <input type="submit" value="volver" name="submit">
        <input type="submit" value="volver a <?= $alumno ?>" name="submit">
        <input type="submit" value="Escribir en Word" name="submit">
        <input type="hidden" value="<?= $practica ?>" name="practica">
        <input type="hidden" value="<?= $alumno ?>" name="alumno">
        <input type="hidden" value="<?= $posicion ?>" name="posicion">

    </form>


</fieldset>


</body>
</html>
