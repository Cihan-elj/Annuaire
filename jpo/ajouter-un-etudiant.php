<?php
session_start();
include('./src/dbConnect.php');


?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <form class="w-full max-w-md mx-auto mt-5 bg-gray-100 p-10 rounded" method="POST">
        <div class="mb-4">
            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
            <input type="text" id="nom" name="nom" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="mail" class="block text-gray-700 text-sm font-bold mb-2">Adresse mail</label>
            <input type="email" id="mail" name="mail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="annee" class="block text-gray-700 text-sm font-bold mb-2">Année</label>
            <select id="annee" name="annee" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="A1">A1</option>
                <option value="A2">A2</option>
                <option value="A3">A3</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="specialite" class="block text-gray-700 text-sm font-bold mb-2">Spécialité</label>
            <select id="specialite" name="specialite" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="Développement Web">Développement Web</option>
                <option value="Web Marketing">Web Marketing</option>
                <option value="Communication Graphique">Communication Graphique</option>
                <option value="Community Management">Community Management</option>
            </select>
        </div>
        <div class="">
            <div class=" mb-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ajouter étudiant
                </button>
            </div>
            <div class="mb-4">
                <a href="index.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Retour</a>
            </div>
        </div>
    </form>
    <?php 
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $mail = $_POST["mail"];
        $annee = $_POST["annee"];
        $specialite = $_POST["specialite"];
        
      
        // $_SESSION["nom"]=$nom;
        // $_SESSION["prenom"]=$prenom;
        // $_SESSION["mail"]=$mail;
        // $_SESSION["annee"]=$annee;
        // $_SESSION["specialite"]=$specialite;

        function requestCreate($connection, $nom, $prenom, $mail, $annee, $specialite) {
            if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($annee) && !empty($specialite)) {
                try {
                    $statement = $connection->prepare("INSERT INTO informations (nom, prenom, mail, annee, specialite) VALUES (?, ?, ?, ?, ?)");
                    $statement->bindParam(1, $nom);
                    $statement->bindParam(2, $prenom);
                    $statement->bindParam(3, $mail);
                    $statement->bindParam(4, $annee);
                    $statement->bindParam(5, $specialite);
                    $statement->execute();
                    echo "L'enregistrement a effectué créé avec succès.";
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            } else {
                echo "Veuillez remplir tous les champs du formulaire.";
            }
        }

        requestCreate($connection, $nom, $prenom, $mail, $annee, $specialite);
    ?>
</body>
</html>


<?php
    session_destroy();
  
?>

