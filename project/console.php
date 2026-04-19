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




