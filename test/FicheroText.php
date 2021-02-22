<?php


require_once "./../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use Utilidades\Fichero;


class FicheroText extends TestCase
{


    public function testsearchDirectorioWithtypeFiles()
    {
        $dir_base = "/var/www";
        $type = "php";
        $rtdo = Fichero::searchDirectorioWithtypeFiles($dir_base, $type);
        $this->assertSame($rtdo, $dir_base);


    }


}