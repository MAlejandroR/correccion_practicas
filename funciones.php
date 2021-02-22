<?php
//Plantear una clase llamada Ficheros.




function busca_index($dir)
{
    $ficheros = scandir($dir);

    $retorno = $dir;
    foreach ($ficheros as $dir_index) {

        if (strpos($dir_index, ".") === 0)
            continue;
        if (is_dir("$dir/$dir_index")) {
            $retorno = $dir_index;
        }
         }

    return $retorno;
}

function lee_ficheros($dir, &$contenidos)
{
    $ficheros = scandir($dir);
    foreach ($ficheros as $fichero) {
        if ($fichero == "." || $fichero == '..')
            continue;
        if (is_dir("$dir/$fichero")) {
            lee_ficheros("$dir/$fichero", $contenidos);

        } else {
            switch (true) {
                case strpos($fichero, "php"):
                case strpos($fichero, "css"):
                case strpos($fichero, "html"):
                    $contenidos[] = "$dir/$fichero";
                    break;
            }
        }
    }
}
/**
 * @param $directorios un array con directorios
 * Quita todas las entradas que empiecen por punto
 * Reorganiza el array de forma indexada
 * Modifica el array que recibe como parámetro
 */

function quitar_ocultos(&$directorios)
{
    foreach ($directorios as $index => $directorio) {
        if ($directorio[0] == ".")
            unset ($directorios[$index]);
    }
    foreach ($directorios as $directorio) {
        $d[] = $directorio;
    }
    $directorios = $d;
}


?>