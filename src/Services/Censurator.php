<?php

namespace App\Services;

class Censurator
{

    function skip_accents( $str, $charset='utf-8' ) {

        $str = htmlentities( $str, ENT_NOQUOTES, $charset );

        $str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
        $str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
        $str = preg_replace( '#&[^;]+;#', '', $str );

        return $str;
    }


    public function purify(string $text):string
    {

    $tabous=['travail','enfant','argent'];
    $remplacer ='*';
    $text2 = $this->skip_accents($text);

    //premier essai avec juste un mot tabou(ok)

        //$rechercher = 'travail';
       // $remplacer ='*';
       // $censure = str_ireplace($rechercher, $remplacer,$text);

     //avec un tableau de mot interdits

        $censure = str_ireplace($tabous,$remplacer,$text2);

        //mettre autant de * qu'il y a de lettres dans le mot a remplacer
        //mb_strlen calcule la taille du mot /strlen qui calcule la taille du mot mais double pour une lettre avec accent
       // foreach($tabous as $tabou){
      //      $replacement = str_repeat('*',mb_strlen($tabou));
       //     $censure = str_ireplace($tabous,$remplacer,$text2);
      //  }


        return $censure;

    }







}
