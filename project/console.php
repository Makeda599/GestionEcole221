<?php
require_once("../data/fonction.php");
// menu();
do{
    menuGestion();
    $choix = readline("Donnez votre choix pour la gestion: ") ;
    
    switch ($choix){
        case 1 : 
            print("Gestion d'étudiants \n");
                menuEtudiant();
                $choixEtudiant = readline("Donnez votre choix: ");
                switch($choixEtudiant){
                    case 1 :
                        $etudiant = SaisirEtudiant();
                        ajoutEtudiant($etudiant);
                        break;
                    case 2 :
                        $etuId = readline("Donnez l'id de l'etudiant \n");
                        $verif = verifId($etuId);
                        if($verif == 1){
                            modifierEtudiant($etuId);
                        }else {
                            print "Cet etudiant n'exista pas \n";
                        }
                        break;
                    case 3 :
                        $etuId = readline("Donnez l'id de l'etudiant \n");
                        $verif = verifId($etuId);
                        if($verif == 1){
                           supprimerEtudiant($etuId);
                        }else {
                            print "Cet etudiant n'exista pas \n";
                        }                        
                        break;
                    default:
                        print "choix invalide \n";
                }
            break;
        case 2 :
            print("Gestion de formations \n");
                menuFormation();
                
            break;


        case 0 :
            print "Au revoir \n";
            break;
        default:
            print "choix invalide \n";
    }
}while($choix != 0);




