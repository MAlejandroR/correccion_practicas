<?php

use PHPUnit\Framework\TestCase;
use Utilidades\Plantilla;
require_once "./../vendor/autoload.php";

class PlantillaTest extends TestCase
{
    public function testgenerarCheckboxSinChecked(){
        $name = "nombre";
        $opciones =["a"];
        $stringOpcionesCheked="";

        $rtdo= Plantilla::generarCheckbox($name,$opciones);
        $rtdoEsperado= "<input type='checkbox'  name='nombre[]' value='a'</opcion>a\n<br />";
        $this->assertSame($rtdo, $rtdoEsperado);
    }
    public function testgenerarCheckboxWithChecked(){
        $name = "nombre";
        $opciones =["a","b","c","d","e"];
        $stringOpcionesCheked="a\nb\nd\n";
        var_dump($stringOpcionesCheked);

        $rtdo= Plantilla::generarCheckbox($name,$opciones,$stringOpcionesCheked);

        $rtdoEsperado = "<input type='checkbox' checked name='nombre[]' value='a'</opcion>a\n<br />";
        $rtdoEsperado.= "<input type='checkbox' checked name='nombre[]' value='b'</opcion>b\n<br />";
        $rtdoEsperado.= "<input type='checkbox'  name='nombre[]' value='c'</opcion>c\n<br />";
        $rtdoEsperado.= "<input type='checkbox' checked name='nombre[]' value='d'</opcion>d\n<br />";
        $rtdoEsperado.= "<input type='checkbox'  name='nombre[]' value='e'</opcion>e\n<br />";

        $this->assertSame($rtdo, $rtdoEsperado);
    }

}
