<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require "vendor/autoload.php";

use Utilidades\Fichero as Fichero;

$opcion =$_POST['submit'] ?? null;
switch ($opcion) {
    case  'Volver':
        echo "<script>windows.close()</script>";
        header("Location:show.php");
        exit();
}


$error = "";
$practica = $_SESSION['practica'];
$alumno = $_GET['alumno'];


$htmlAlumno = ucwords(str_replace("_", " ", "$alumno"));
/**Pendiente de implementar esta idea ...
 * try {
 * $dir = Fichero::searchDirectorioWithTypeFiles("practicas/$practica/$alumno", "php");
 * $ficheros = \Utilidades\Fichero::getContenidoDir("$dir");
 *
 * }catch (\Utilidades\ExceptionFichero $e){
 * $error = "Error!!! ".$e->getMessage();
 * }
 * */
try {
//    $ficheros = Fichero::getContenidoDir("./practicas/$practica/$alumno");
    $listado_ficheros =[];
        Fichero::getFicheros("./practicas/$practica/$alumno", $listado_ficheros);



    $listadoFicherosTexto = "<ol>\n";
    $html="";
    foreach ($listado_ficheros as $fichero) {
        /**MRM Pendinte de implementar mejor
         * Quiero solo tener los ficheros php y html
         */
        if ((strpos($fichero, "php") === False) and (strpos($fichero, "php") === False))
            continue;

        if (strpos($fichero, "ini"))
            continue;
        if ($fichero[0] == ".")
            continue;
        $listadoFicherosTexto  .= "<li>$fichero</li>";

        $contenido = file_get_contents("$fichero");
        $html .= "<div class='fichero'>";
        $nombreFichero = basename($fichero);
        $html .= "<h2>Fichero <span style='color:#baeeff'>$nombreFichero</span> </h2>";
        $html .= "<pre class=\"prettyprint\">" . htmlspecialchars($contenido) . "</pre>";
        $html .= "<hr />";
        $html .= "</div> ";

    }
    $listadoFicherosTexto.= "<ol>\n";

} catch (\Utilidades\ExceptionFichero $e) {
    $error .= "Error!!! " . $e->getMessage();
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <link rel="stylesheet" href="css/estilo.css">

    <title>Document</title>
</head>
<body>
<span class="error">
<?= $error ?>
    </span>
<form action="ver_practica.php" method="post">
    <input type="submit" value="Volver" name="submit">
    <input type="submit" value="Volver a <?= $alumno ?>" name="submit">
</form>
<h3>Listado de ficheros obtenidos</h3>
<?=$listadoFicherosTexto ?>
<hr />
<br />
<?= $html ?>


</body>
</html>
