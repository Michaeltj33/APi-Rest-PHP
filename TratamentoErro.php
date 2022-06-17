<?php
class Tratar
{
    function removeE($dt)
    {
        $dt = str_replace(["  ", "   ", "    ", "     ", "      "], " ", $dt);
        $dt = str_replace(["  ", "   ", "    ", "     ", "      "], " ", $dt);
        return $dt;
    }
    function minusculo($dt1)
    {
        $dt1 = strval($this->removeE($dt1));
        $dt1 = strtolower($dt1); //deixa todas as letras minúscula           
        return $dt1;
    }
    function removerNumero($string)
    {
        $string = str_replace("+55", "", $string); //remove o +55, deixando apenas os 11 números 

        if (strlen($string) == 10) {
            $pegaV = "";
            for ($x = 0; $x < strlen($string); $x++) {
                if ($x == 2) {
                    $pegaV .= 9;
                    $pegaV .= $string[$x];
                } else {
                    $pegaV .= $string[$x];
                }
            }
            $string = $pegaV;
        }

        if (strlen($string) == 11) {
            if ($string[2] != 9) {
                $string[2] = 9;
            }
        }

        return $string;
    }
 
}
