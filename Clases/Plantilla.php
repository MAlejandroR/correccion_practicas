<?php

namespace Utilidades;
class Plantilla
{
    static function generarSelect($name, $opciones)
    {
        var_dump($name);
        var_dump($opciones);
        $html = "<select name='$name'>";
        foreach ($opciones as $opcion)
            $html .= "<option name =$opcion>$opcion</opcion>\n";

        $html .= "</select>";
        return $html;
    }

    /**
     * @param $name nombre de cada checkbox []
     * @param $opciones lista de elementos o checkbox
     * @param null $stringOpcionesCheked por si quiero dejar chekeadas (opcional)
     * @return string html con los inputs checkbox y chekeados aquellos que se aporten en el string
     */
    static function generarCheckbox($name, $opciones, $stringOpcionesCheked=null)
    {

        $opcionesCheked = [];
        if ($stringOpcionesCheked) {
            $opcionesCheked = explode("\n", $stringOpcionesCheked);
        }
        $html = "No se han identificado criterios";

        if ((count($opciones)> 0)) {
            $html ="";
              foreach ($opciones as $opcion) {
                $pos = array_search($opcion, $opcionesCheked);
                $cheked = $pos !== FALSE ? "checked" : null;
                $html .= "<input type='checkbox' $cheked name='{$name}[]' value='$opcion'</opcion>$opcion\n<br />";
            }
        }

        return $html;

    }

    /**
     * @param $name_check
     * @return string html con los select seleccionados
     */
    static function getValueCheckBox($name_check)
    {
        $html = "";

        $checkbox = $_POST[$name_check];
        foreach ($checkbox as $check)
            $html .= "$check\n";
        return $html;

    }

    /**
     * @param $nota
     * @param $comentarios
     * @param $criterio
     * @return string
     */
    public static function getCorreccion($nota, $comentarios, $criterio)
    {
        $msj .= "---------------------------------------------------------------\n";

        $msj = "En esta práctica has obtenido una nota de $nota\n";
        $msj .= "-------------------------\n";
        $msj .= "Respecto a los criterios establecidos en esta práctica he observado que las siguientes no funcionan correctamente:\n";
        $msj .= "$criterio\n";
        $msj .= "-------------------------\n";

        $msj .= "OTros comentarios :\n";
        $msj .= $comentarios;
        $msj .= "---------------------------------------------------------------\n";

        return $msj;
    }

    public static function getListadoAlumnosPracticasShow(array $listadoPracticas, $practica ):string{
        $html ="";
        foreach ($listadoPracticas  as $posicion => $alumno) {
            if (is_dir("practicas/$practica/$alumno")) {
                $html .= "<form action='show.php' method='POST' target='_blank'>";
                //Nos quedamos con el nombre del alumno que es
                //El dir del alumno dentro de la práctica
                //Le quitamos subrayado y ponemos mayúsculas la primera letra
                $htmlAlumno = ucwords(str_replace("_", " ", $alumno));
                $html .= "<li><span class=nombre>$htmlAlumno</span>\n";
                $html .= "<input type=submit value='Ejecutar práctica' name=submit />\n";
                $html .= "<input type=submit value='Ver ficheros' name='submit' />\n";
                $html .= "<input type=submit value='Corrección' name='submit' />";
                if (file_exists("practicas/$practica/$alumno/correccion.ini"))
                    $html .= "<img style='width:3%' src=./imagenes/ok.ico />";
                $html .= "</li>";
                $html .= "<hr />";
                $html .= "<input type=hidden value='$practica' name='practica' />\n";
                $html .= "<input type=hidden value='$alumno' name='alumno' />\n";
//            $html .="<input type=hidden value='$dir' name='dir' />\n";-->
                $html .= "<input type=hidden value='$posicion' name='posicion' />\n";
                $html .= "</form>";
            }
        }
        return $html;
    }

    public static function  cerrar_ventana(){
        echo "<script>window.close();</script>";
    }


}