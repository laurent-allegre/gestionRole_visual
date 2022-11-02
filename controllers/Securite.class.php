<?php

class Securite{
    public static function secureHTML($chaine){
        return htmlentities($chaine);
    }
    public static function estConnecte(){
        return (!empty($_SESSION['profil']));
    }
}