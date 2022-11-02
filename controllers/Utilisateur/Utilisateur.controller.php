<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Utilisateur/Utilisateur.model.php");

class UtilisateurController extends MainController{
    private $utilisateurManager;

    public function __construct(){
        $this->utilisateurManager = new UtilisateurManager();
    }

    public function validation_login($login,$password){
        if($this->utilisateurManager->isCombinaisonValide($login,$password)){
            if($this->utilisateurManager->estCompteActive($login)){
                Toolbox::ajouterMessageAlerte("Bon retour sur le site ".$login." !", Toolbox::COULEUR_VERTE);
                $_SESSION['profil'] = [
                    "login" => $login,
                ];
                header("location: ".URL."compte/profil");
            } else {
                $msg = "Le compte ".$login. " n'a pas été activé par mail. ";
                $msg .= "<a href='renvoyerMailValidation/".$login."'>Renvoyez le mail de validation</a>";
                Toolbox::ajouterMessageAlerte($msg, Toolbox::COULEUR_ROUGE);
                header("Location: ".URL."login");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Combinaison Login / Mot de passe non valide", Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."login");
        }
    }
    public function profil(){
        $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
        $_SESSION['profil']["role"] = $datas['role'];
        
        $data_page = [
            "page_description" => "Page de profil",
            "page_title" => "Page de profil",
            "utilisateur" => $datas,
            "page_javascript" => ['profil.js'],
            "view" => "views/Utilisateur/profil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function deconnexion(){
        Toolbox::ajouterMessageAlerte("La deconnexion est effectuée",Toolbox::COULEUR_VERTE);
        unset($_SESSION['profil']);
        header("Location: ".URL."accueil");
    }
    public function validation_creerCompte($login,$password,$mail){
        if($this->utilisateurManager->verifLoginDisponible($login)){
            $passwordCrypte = password_hash($password,PASSWORD_DEFAULT);
            $clef = rand(0,9999);
            if($this->utilisateurManager->bdCreerCompte($login,$passwordCrypte,$mail,$clef)){
                $this->sendMailValidation($login,$mail,$clef);
                Toolbox::ajouterMessageAlerte("La compte a été créé, Un mail de validation vous a été envoyé !", Toolbox::COULEUR_VERTE);
                header("Location: ".URL."login");
            } else {
                Toolbox::ajouterMessageAlerte("Erreur lors de la création du compte, recommencez !", Toolbox::COULEUR_ROUGE);
                header("Location: ".URL."creerCompte");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."creerCompte");
        }
    }

    private function sendMailValidation($login,$mail,$clef){
        $urlVerification = URL."validationMail/".$login."/".$clef;
        $sujet = "Création du compte sur le site xxx";
        $message = "Pour valider votre compte veuillez cliquer sur le lien suivant ".$urlVerification;
        Toolbox::sendMail($mail,$sujet,$message);
    }

    public function renvoyerMailValidation($login){
        $utilisateur = $this->utilisateurManager->getUserInformation($login);
        $this->sendMailValidation($login,$utilisateur['mail'],$utilisateur['clef']);
        header("Location: ".URL."login");
    }

    public function validation_mailCompte($login,$clef){
        if($this->utilisateurManager->bdValidationMailCompte($login,$clef)){
            Toolbox::ajouterMessageAlerte("Le compte a été activé !", Toolbox::COULEUR_VERTE);
            $_SESSION['profil'] = [
                "login" => $login,
            ];
            header('Location: '.URL.'compte/profil');
        } else {
            Toolbox::ajouterMessageAlerte("Le compte n'a pas été activé !", Toolbox::COULEUR_ROUGE);
            header('Location: '.URL.'creerCompte');
        }
    }

    public function validation_modificationMail($mail){
        if($this->utilisateurManager->bdModificationMailUser($_SESSION['profil']['login'],$mail)){
            Toolbox::ajouterMessageAlerte("La modification est effectuée", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("Aucune modification effectuée", Toolbox::COULEUR_ROUGE);
        }
        header("Location: ".URL."compte/profil");
    }

    public function modificationPassword(){
        $data_page = [
            "page_description" => "Page de modification du password",
            "page_title" => "Page de modification du password",
            "view" => "views/Utilisateur/modificationPassword.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function pageErreur($msg){
        parent::pageErreur($msg);
    }
}