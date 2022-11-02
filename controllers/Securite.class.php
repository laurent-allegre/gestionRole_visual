<?php

class Securite{
    public const COOKIE_NAME="timers";

    public static function secureHTML($chaine){
        return htmlentities($chaine);
    }
    public static function estConnecte(){
        return (!empty($_SESSION['profil']));
    }
    public static function estUtilisateur(){
        return ($_SESSION['profil']['role'] === "utilisateur");
    }
    public static function estAdministrateur(){
        return ($_SESSION['profil']['role'] === "administrateur");
    }
    public static function genererCookieConnexion(){
        $ticket = session_id().microtime().rand(0,999999);
        $ticket = hash("sha512",$ticket);
        setcookie(self::COOKIE_NAME,$ticket,time()+(60*20));
        $_SESSION['profil'][self::COOKIE_NAME] = $ticket;
    }
    public static function checkCookieConnexion(){
        return $_COOKIE[self::COOKIE_NAME] === $_SESSION['profil'][self::COOKIE_NAME];
    }
}