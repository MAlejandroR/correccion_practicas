<?php


namespace Utilidades;

use PhpOffice\PhpWord\Exception\Exception;

class WordException extends Exception{

}
class Word
{

    private $phpWord;
    private $content;


    /**
     * @param $lang
     * @return \PhpOffice\PhpWord\Style\Language establece el idioma del documento
     */
    private function setLanguage($lang="EN_GB" ){
        return new \PhpOffice\PhpWord\Style\Language(\PhpOffice\PhpWord\Style\Language::ES_ES);

   }

    /**
     * Word constructor.
     * @param string $filename
     * @param string $lang
     * Creo o abre un fichero en wore
     */
    public function __construct(string $filename = "", $lang ="EN_GB")
    {
        //            //Verificar que exista el directorio
        $dir_base = dirname($filename);
        if (!file_exists($dir_base))
            throw new WordException("El directorio $dir_base no existe, y no se puede crear $filename");

        if (file_exists($filename)) {
            echo "<h1>El fichero $filename existe</h1>";
            $this->phpWord = \PhpOffice\PhpWord\IOFactory::load($filename);


            // Save file
          echo write($phpWord, basename(__FILE__, '.php'), $writers);


            $file = fopen  ($filename, "rb");
            $this->content = fread ($file, filesize($filename));
            var_dump($this->content);
        } else {
            $this->phpWord = new \PhpOffice\PhpWord\PhpWord();
            echo "<h1>Se ha intentado crear  el fichero $filename</h1>";
        }

        $language = $this->setLanguage("EN_GB");
        $this->phpWord->getSettings()->setThemeFontLang($language);
    }

    /**
     * MRM Método pendiente de implementar y explicar
     */
    private function leer()
    {
        $sections = $this->phpWord->getSections();
        $section = $this->$sections[0]; // le document ne contient qu'une section
        $this->content =  $this->$section->getElements();

    }

    public function escribirTitulo(string $titulo,int $nivel=1, array $estilo=[]){

        $estilo1 = ['bold' => true, 'italic' => true, 'size' => 20, 'allCaps' => true, 'doubleStrikethrough' => true,'color'=>'873600',];
        $estilo2 = ['bold' => true, 'italic' => true, 'size' => 18, 'color'=>'8736FF',];
        $estilo3 = ['bold' => true, 'italic' => true, 'size' => 16, 'color'=>'87360F',];
//        $nombreEstilo = "$estilo{$nivel}";


        $this->phpWord->addFontStyle("font_h{$nivel}", "$estilo{$nivel}");
        $this->phpWord->addTitleStyle($nivel, "font_h{$nivel}"); //h1

// New portrait section
        $section = $this->phpWord->addSection();

// Simple text
        $section->addTitle($titulo, $nivel);
        $section->addLine();

    }

    public function escribirTexto(string $texto, array $estilo=[]){

        $this->phpWord->addFontStyle("normal", $estilo);
        $section = $this->phpWord->addSection();
        $section->addText($texto);
        $section->addLine();

    }
    public function guardar ($filename){
        $this->phpWord->save($filename );
        

    }




}