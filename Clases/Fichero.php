<?php

namespace Utilidades;


use PHPUnit\Runner\Exception;


class ExceptionFichero extends Exception
{
}

;

class Fichero
{

    /**
     * @param $file
     * @param $contenido escribe este contenido en el ficheor $file.
     * perderíamos cualquier contenido que tuviéramos
     */
    static function writeln($file, $contenido)
    {
//        var_dump($contenido);
        $headlerFile = @fopen($file, "w");
        if ($headlerFile === false)
            throw new ExceptionFichero("No se ha podido abrir $file");
        $rtdo = fwrite($headlerFile, $contenido . PHP_EOL);
        if ($rtdo === false)
            throw new ExceptionFichero("No se ha podido escribir en el fichero  $file");
        fclose($headlerFile);
    }


    /**
     * @param $dir directorio del cual queremos su contendio
     * @return array|false el array con el contendio de un directorio quitando ' y ''
     * Si recursivo devuelve todos los ficheros del dir actual y subdirectorios
     * OjO Problena no resuelto con nombres de directorios que contentan acentos
     */
    static function getContenidoDir($dir)
    {

        $ficheros = @scandir($dir);
        if ($ficheros == false)
            throw new ExceptionFichero("No se ha podido leer del directorio -$dir-");
        unset ($ficheros[array_search(".", $ficheros)]);
        unset ($ficheros[array_search("..", $ficheros)]);

        return $ficheros;
    }


    /**
     * @param $dir directorio del cual queremos su contendio
     * @return array|false el array con el contendio de todos los ficheros del dir actual y subdirectorios
     * OjO Problena no resuelto con nombres de directorios que contentan acentos
     */
    static function getFicheros($dir, &$lista_ficheros)
    {


        $dirBase = __DIR__;
        $dirBase =substr($dirBase, 0, strrpos($dirBase, "/"));

        $ficheros = @scandir("$dirBase/$dir");
        unset ($ficheros[array_search(".", $ficheros)]);
        unset ($ficheros[array_search("..", $ficheros)]);

        foreach ($ficheros as $fichero) {
            if ($ficheros == false)
                throw new ExceptionFichero("No se ha podido leer del directorio -$dir-");
            if (is_dir("$dirBase/$dir/$fichero")) {
                 self::getFicheros("$dir/$fichero", $lista_ficheros);
            }
            else {
                $lista_ficheros[] = "$dirBase/$dir/$fichero";

            }
        }
    }

    public static function getDatosFicheroIni($directorio, $fichero)
    {
        $datos = parse_ini_file("$directorio/$fichero", true);

        if ($datos === FALSE)
            throw new ExceptionFichero("Error obteniendo datos del fichero ini $directorio/$fichero");
        return $datos;
    }


    /**
     * @param $diretory un directorio
     * A partir de él busca el primer directorio que contenga algún fichero ph
     */


    public static function searchDirectorioWithtypeFiles($directory, $type)
    {
        $files = Fichero::getContenidoDir($directory);
        $encontrado = false;
        $fin = false;
        while (!$encontrado and !$fin) {
            foreach ($files as $file) {
                if (is_dir("$directory/$file")) {
                    $encontrado = self::searchDirectorioWithtypeFiles($file, $type);
                }
                if ($encontrado)
                    break;
                if (strpos($file, $type) !== false)
                    $encontrado = true;
            }
            $fin = true;
        }
        if ($encontrado)
            return $directory;
        else
            return false;


    }

}

