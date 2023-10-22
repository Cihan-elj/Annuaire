<?php
session_start();
include_once('index.php');
// include_once('dbConnect.php');



$connection=$_SESSION["connection"];

// var_dump($connection);

//FONCTION CREATE
// $nom = $_POST['nom'];
// $prenom = $_POST['prenom'];
// $mail = $_POST['mail'];
// $annee = $_POST['annee'];
// $specialite = $_POST['specialite'];

// $nom = "TESTaaa";
// $prenom = "azertyaaa";
// $mail = "aaabbb@gmail.com";
// $annee = "A2";
// $specialite = "Développement Web";

$nom=$_SESSION["nom"];
$prenom=$_SESSION["prenom"];
$mail=$_SESSION["mail"];
$annee=$_SESSION["annee"];
$specialite=$_SESSION["specialite"];


// function requestCreate($connection, $nom, $prenom, $mail, $annee, $specialite) {
//     if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($annee) && !empty($specialite)) {
//         try {
//             $statement = $connection->prepare("INSERT INTO informations (nom, prenom, mail, annee, specialite) VALUES (?, ?, ?, ?, ?)");
//             $statement->bindParam(1, $nom);
//             $statement->bindParam(2, $prenom);
//             $statement->bindParam(3, $mail);
//             $statement->bindParam(4, $annee);
//             $statement->bindParam(5, $specialite);
//             $statement->execute();
//             echo "L'enregistrement a été créé avec succès.";
//         } catch (PDOException $e) {
//             echo "Erreur : " . $e->getMessage();
//         }
//     } else {
//         echo "Veuillez remplir tous les champs du formulaire.";
//     }
// }








function requestRead($connection, $a, $spe, $recherche) {
    // Créez une chaîne vide 
    $conditions = '';

    
    $query = "SELECT * FROM informations WHERE ";

    if (!empty($a) || !empty($spe) || !empty($recherche)) {
        $conditionsArray = array();
        

        // Créez une condition pour les années cochées
        if (!empty($a)) {
            $conditionsArrayAnnee = array();
            foreach ($a as $valeurAnnee) {
                $conditionsArrayAnnee[] = "annee = '$valeurAnnee'";
            }
            $conditionsArray[] = '(' . implode(' OR ', $conditionsArrayAnnee) . ')';
        }

        // Créez une condition pour les spécialités cochées
        if (!empty($spe)) {
            $conditionsArraySpe = array();
            foreach ($spe as $valeurSpe) {
                $conditionsArraySpe[] = "specialite = '$valeurSpe'";
            }
            $conditionsArray[] = '(' . implode(' OR ', $conditionsArraySpe) . ')';
        }

        // Créez une condition pour la recherche
        if (!empty($recherche)) {
            $conditionsRecherche = "nom LIKE '%$recherche%' OR prenom LIKE '%$recherche%'";
            $conditionsArray[] = '(' . $conditionsRecherche . ')';
        }

        // Tout combiner
        $conditions = implode(' AND ', $conditionsArray);
        $query .= $conditions;
    } else {
        // Si aucune case n'est cochée et aucune recherche n'est spécifiée, tout séléctinné
        $query .= "1"; // "1" est une condition toujours vraie
    }


    $statement = $connection->prepare($query);
    $statement->execute();
    $resultat = $statement->fetchAll(PDO::FETCH_ASSOC);


    if (isset($_GET['delete_done']) && $_GET['delete_done'] === 'true') {
        echo 'Suppression effectuée';
    } else {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            requestDelete($id, $connection);
    
            header("Location: " . $_SERVER['PHP_SELF'] . "?delete_done=true");

        }
    }

    if (!empty($resultat)) {
        foreach ($resultat as $ligne) {
            $id = $ligne['Id'];
            echo '<tr>
                <td>' . $ligne['nom'] . '</td>
                <td>' . $ligne['prenom'] . '</td>
                <td>' . $ligne['mail'] . '</td>
                <td>' . $ligne['annee'] . '</td>
                <td>' . $ligne['specialite'] . '</td>
                
                <td><a href="?id=' . $id . '" class="hover:font-bold">Supprimer</a></td>
                </tr>';
    }
    } else {
        echo "Aucun résultat trouvé.";
    }
}




//FONCTION UPDATE
// $id=3;

function requestUpdate($connection, $id, $nom, $prenom, $mail, $specialite, $annee) {
    try {
        $statement = $connection->prepare("UPDATE informations SET nom =?, prenom =?, mail =?, specialite=?, annee=? WHERE id =?");
        $statement->bindParam(6, $id);
        $statement->bindParam(1, $nom);
        $statement->bindParam(2, $prenom);
        $statement->bindParam(3, $mail);
        $statement->bindParam(4, $specialite);
        $statement->bindParam(5, $annee);
        $statement->execute();

        echo "La modification a été faite avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
// requestUpdate($connection, $id, $nom, $prenom, $mail);



//FONCTION DELETE
function requestDelete($id, $connection) {
    try {
        $statement = $connection->prepare("DELETE FROM `informations` WHERE Id =?");
        $statement->bindParam(1, $id);
        $statement->execute();

        echo "L'enregistrement a été supprimé avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


session_destroy();
?>