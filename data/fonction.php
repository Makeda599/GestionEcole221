<?php
function lireJsonEnPhp(){
    $data = file_get_contents("../data/data.json");
    $data = json_decode($data,true);
    return $data;
}

function phpEnJson($data){
    $contenu = json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('../data/data.json',$contenu);
}
// function menu(){
//     print "1 => Gestion d'etudiants \n";
//         print "\t1 => Ajouter un étudiant \n";
//         print "\t2 => Modifier un étudiant \n";
//         print "\t3 => Supprimer un étudiant \n";
//         print "\t4 => Lister les étudiants \n";

//     print "2 => Gestion de formations \n";
//         print "\t1 => Ajouter une formation \n";
//         print "\t2 => Modifier une formation \n";
//         print "\t3 => Supprimer une formation \n";
//         print "\t4 => Lister les étudiants \n";
// }
function menuGestion(){
    print "1 => Gestion d'etudiants \n";
    print "2 => Gestion de formations \n";
    print "0 =>Quitter \n";
}
function menuEtudiant(){
        print "\t1 => Ajouter un étudiant \n";
        print "\t2 => Modifier un étudiant \n";
        print "\t3 => Supprimer un étudiant \n";
        print "\t4 => Lister les étudiants \n";
}
function menuFormation(){
        print "\t1 => Ajouter une formation \n";
        print "\t2 => Modifier une formation \n";
        print "\t3 => Supprimer une formation \n";
        print "\t4 => Lister les étudiants \n";  
}
function verifMail($email){
    $datas = lireJsonEnPhp();
    foreach($datas["etudiants"] as $key => $etudiant){
        if($etudiant["email"] == $email){
            return 1;
        }
    }
    return 0;
}

function validerEtudiant($nom, $prenom, $email){
    $errors = [];

    
    $nomRegex = "/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/";
    $emailRegex = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";

   
    if(empty($nom)){
        $errors["nom"] = "Le nom est obligatoire";
    } elseif(!preg_match($nomRegex, $nom)){
        $errors["nom"] = "Nom invalide (lettres uniquement, 2 à 50 caractères)";
    }

   
    if(empty($prenom)){
        $errors["prenom"] = "Le prénom est obligatoire";
    } elseif(!preg_match($nomRegex, $prenom)){
        $errors["prenom"] = "Prénom invalide";
    }

    
    if(empty($email)){
        $errors["email"] = "L'email est obligatoire";
    } elseif(!preg_match($emailRegex, $email)){
        $errors["email"] = "Format email invalide";
    } elseif(verifMail($email)){
        $errors["email"] = "Cet email existe déjà";
    }

    return $errors;
}

function SaisirEtudiant(){
    $datas = lireJsonEnPhp();
    $etudiants = $datas["etudiants"];
    do{

        $nom = readline("Donnez le nom : ");
        $prenom = readline("Donnez le prenom : ");
        $email = readline("Donnez l'email : ");
        $errors = validerEtudiant($nom, $prenom, $email);
       if(!empty($errors)){
           print "\n ERREURS DETECTES \n";
           foreach($errors  as $key => $error){
               print "$error\n";
           }
            print "\n";
           
       }
    }while(!empty($errors));
    $etudiant = [
        "id_etudiant" => count($etudiants) + 1,
        "nom" => $nom,
        "prenom" => $prenom,
        "email" =>$email,
    ];
    return $etudiant;
}

function ajoutEtudiant($etudiant){
   $verificationMail = verifMail($etudiant["email"]);
//    var_dump($verificationMail);
   if($verificationMail == 0){
    $datas = lireJsonEnPhp();
    $datas["etudiants"][]=$etudiant;
    phpEnJson($datas);
    print "Etudiant ajouté avec succés \n";
   }else{
    print "cet email existe déjà \n";
   }
}
function verifId($id){
    $datas = lireJsonEnPhp();
    foreach ($datas["etudiants"]as $key => $etudiant){
        if($etudiant["id_etudiant"] == $id){
            return 1;
        }
    } 
    return 0;
}
function modifierEtudiant($id){
    $datas = lireJsonEnPhp();
    foreach ($datas["etudiants"]as $key => &$etudiant){
        if($etudiant["id_etudiant"] == $id){
            do{

                $nom = readline("Donnez le nom \n");
                $prenom = readline("Donnez le prenom \n");
                $email = readline("Donnez l'email \n");
                $errors = validerEtudiant($nom, $prenom, $email);
                if($email === $etudiant["email"]){
                    unset($errors["email"]);
                }
               if(!empty($errors)){
                        print "\n ERREURS :\n";
                        foreach($errors as $error){
                            print "$error\n";
                        }
                        print "\n";
                    }
            }while(!empty($errors));
            $etudiant["nom"] = $nom;
            $etudiant["prenom"] = $prenom;
            $etudiant["email"] = $email;

            phpEnJson($datas);
            print "Étudiant modifié avec succès\n";
            return;
        }
        }
    print "Cet étudiant n'existe pas\n";  
    }

function supprimerEtudiant(int $id){
    $datas = lireJsonEnPhp();
    foreach($datas["etudiants"] as $key=>&$etudiant){
        if($etudiant["id_etudiant"] == $id){
            unset($datas["etudiants"][$key]);
            break;
        }
    }
    phpEnJson($datas);
    print "etudiant supprimé avec succes\n";
}
function getUnEtudiant($etudiant){
    print "Nom :  ".$etudiant["nom"]."\n";
    print "Prenom :  ".$etudiant["prenom"]."\n";
    print "Email :  ".$etudiant["email"]."\n";
}
function listeEtudiants(){
    $datas = lireJsonEnPhp();
    foreach($datas["etudiants"] as $key=>$etudiant){
        getUnEtudiant($etudiant);
        print "===============================================\n";

    }
}

// ==========================================================================================================
// ==========================================================================================================
function verifNiveau($id){
    $datas = lireJsonEnPhp();
    foreach($datas["niveaux"] as $key => $niveau){
        if($niveau["id"] == $id){
            return 1 ;
        }
    }
    return 0;
}
function saisirNiveau(){
    $idNiveau = (int)readline("Donnez le niveau \n");
    return $idNiveau;
}

function saisirFormation(){
    $datas =  lireJsonEnPhp();
    $tabForm = $datas["formations"];
    $titre = readline("Donner le titre de la formation \n");
    if(empty($titre)){
        print ("le titre est obligatoire \n");
        return ;
    }
    do{
        $places = (int)readline("Donner le nombre de places \n");
        if($places <= 0){
            print "Le nombre de places doit être supérieur à 0 réassayez\n";
        }
    }while($places <= 0);
    do{
        $idNiveau = saisirNiveau();
        $verif = verifNiveau($idNiveau);
        if($verif == 0){
            print "Ce niveau n'existe pas réassayez \n";
        }
    }while($verif == 0);
    $form = [
            "id_formation" => count($tabForm) + 1,
            "titre" => $titre,
            "description" => readline("Donner la description de la formation \n"),
            "duree" => readline("Donner la duree de la formation \n"),
            "nombres_de_places" => $places,
            "id_niveau" => $idNiveau,

    ];
    return $form;
}
function ajoutFormation($formation){
    $datas =  lireJsonEnPhp();
    $datas["formations"][] = $formation;
    phpEnJson($datas);
}

function verifFormation($id){
    $datas =  lireJsonEnPhp();
    foreach($datas["formations"] as $key => $formation){
    if($formation["id_formation"] == $id){
        return 1;
        }
    }
    return 0;
}

function modifierFormation($id){
    $datas =  lireJsonEnPhp();
    foreach($datas["formations"] as $key => &$formation){
        if($formation["id_formation"] == $id){
            $titre = readline("Donner le titre de la formation \n");
            if(empty($titre)){
                print ("le titre est obligatoire \n");
                return ;
            }
            do{
                $places = (int)readline("Donner le nombre de places \n");
                if($places <= 0){
                    print "Le nombre de places doit être supérieur à 0 réassayez\n";
                }
            }while($places <= 0);
            do{
                $idNiveau = saisirNiveau();
                $verif = verifNiveau($idNiveau);
                if($verif == 0){
                    print "Ce niveau n'existe pas réassayez \n";
                }
            }while($verif == 0);
            $formation = [
                    $formation["id_formation" ] = $id,
                    $formation["titre"] => $titre,
                    $formation["description"] => readline("Donner la description de la formation \n"),
                    $formation["duree"] => readline("Donner la duree de la formation \n"),
                    $formation["nombres_de_places"] => $places,
                    $formation["id_niveau"] => $idNiveau,

            ];

                phpEnJson($datas);
                print("formation modifié avec succés \n");
                return ;
                }
            }
}

function supprimerFormation($id){
    $datas =  lireJsonEnPhp();
        foreach($datas["formations"] as $key => &$formation){
        if($formation["id_formation"] == $id){
            unset($datas["formations"][$key]);
            phpEnJson($datas);
            print "formation supprimé avec succés \n";
            break;
        }
        }
}
function getUneFormation($formation){
    $datas = lireJsonEnPhp();
    print "Titre : ".$formation["titre"]."\n";
    print "Description : ".$formation["description"]."\n";
    print "Duree : ".$formation["duree"]."\n";
    print "Nombres de places: ".$formation["nombres_de_places"]."\n";
    foreach($datas["niveaux"] as $key => $niveau){
        if($niveau["id"] == $formation["id_niveau"]){
            print "Niveau : ".$niveau["nom"]."\n";
        }
    }
}

function afficheAllFormation(){
    $datas = lireJsonEnPhp();
    foreach($datas["formations"] as $key => $formation){
        getUneFormation($formation);
        print "===============================================\n";

    }
}