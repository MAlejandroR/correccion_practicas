<?php
//Leer los directorios que son la prácticas
session_start();
session_destroy();
echo "<h1>Hola</h1>";
$error = $_GET['msj'] ?? "";

require_once ("vendor/autoload.php");

Use Utilidades\Fichero as Fichero;

try {
    $practicas = Fichero::getContenidoDir("practicas");
}catch (\Utilidades\ExceptionFichero $e){
    $error.="Error: ".$e->getMessage();
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
<h1><?$error ?? ""?></h1>
<fieldset>

    <legend>Selecciona práctica</legend>
    <?php
    foreach ($practicas as $practica) {
        echo "<form action='show.php' method='POST'>";
        $name_practica = ucwords(str_replace("_", " ", $practica));
        echo "<input type=submit value='$name_practica' name='submit' \>\n";
        echo "<input type=hidden value='$practica' name='practica' \>\n";
        echo "</form>";
    }

    ?>
    </form>
</fieldset>

</body>
</html>
