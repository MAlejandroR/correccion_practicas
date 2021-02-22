<?php

ini_set("display_errors", true);
error_reporting(E_ALL);



require_once "vendor/autoload.php";


use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\PhpWord;
use Utilidades\Word;


$practica =$_GET['practica'];
$alumno =$_GET['alumno'];
$nota =$_GET['nota'];
$comentarios =unserialize($_GET['comentarios']);


$dir =__DIR__;
$path = "$dir/practicas/$practica/$alumno";
$filename ="$path/correccion.doc";
try {
    $phpWord = new Word($filename);
}catch (\Utilidades\WordException $ex){
    echo "<h1>Error </h1><h2>".$ex->getMessage()."</h2>";
    echo "<h3>En 10 segundos retornarás a la página anterior</h3>";

    header ("Refresh:10;url=correccion.php?practica=$practica&alumno?$alumno");

}


$phpWord->escribirTitulo("PRÁCTICA $practica",1);


$phpWord->escribirTitulo("NOTA $nota", 2);


$phpWord->escribirTitulo("COMENTARIOS", 2);
foreach ($comentarios as $comentario) {
    $phpWord->escribirTexto($comentario);
}



$phpWord->guardar($filename);
header('Content-disposition: inline');
header('Content-type: application/msword'); // not sure if this is the correct MIME type
readfile('$filename');
exit;
//header ("Location:correccion.php?practica=$practica&alumno?$alumno");



?>
