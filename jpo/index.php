<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Annuaire NWS</title>
</head>

<?php
session_start();
include('./templates/includes/header.php');
include_once('./src/dbConnect.php');
include_once('./src/crud.php');
include_once('./src/toolkits.php');
?>

<?php
$spe = isset($_POST["spe"]) ? $_POST["spe"] : array(); // Initialise $spe avec un tableau vide s'il n'est pas défini
$a = isset($_POST["a"]) ? $_POST["a"] : array();

$valider = $_POST["valider"];

?>

<style>
.bouton{
        background:url(images/icones/icons8-loupe-50.png);
        border:none;
        width: 50px; 
        height: 50px;
        cursor: pointer;
}
</style>
  
<body class="text-center">
    <header class="flex flex-col">
        <div class="mx-auto w-[250px] pb-[20px]">
            <img src="./images/logo_nws.png">
        </div>
        <div id="lesFormulaires" class="flex flex-col mx-auto" >
            <div class="w-[364px]">
                <form action="#" method="post" class="ml-5">
                    <div id="recherche" class="flex justify-around my-auto  border-solid border-2 border-gray-400 pl-7 rounded-full">
                        <input type="text" name="recherche" placeholder="Rechercher un étudiant... " value="<?php echo isset($recherche) ? $recherche : '';$recherche = $_POST['recherche'];?>" class="pr-20">
                        <input type="submit" class="bouton" name="valider" value="" alt="Rechercher">

                        
                    </div>
                    <div id="filtre" class="flex flex-col">
                        <div id="spé">
                            <label>
                                <input type="checkbox" name="spe[]" value="Développement Web" <?php if (in_array("Développement Web", $spe)) { echo "checked";} ?>> Développement Web
                            </label>
                            <label>
                                <input type="checkbox" name="spe[]" value="Web Marketing" <?php if (in_array("Web Marketing", $spe)) { echo "checked";} ?>> Web Marketing
                            </label><br>
                            <label>
                                <input type="checkbox" name="spe[]" value="Communication Graphique" <?php if (in_array("Communication Graphique", $spe)) { echo "checked";} ?>> Communication Graphique
                            </label>
                            <label>
                                <input type="checkbox" name="spe[]" value="Community Management" <?php if (in_array("Community Management", $spe)) { echo "checked";} ?>> Community Management
                            </label><br>
                            <label>
                        </div>
                        <div id="année">
                            <label>
                                <input type="checkbox" name="a[]" value="A1" <?php if (in_array("A1", $a)) { echo "checked";} ?>> A1
                            </label>
                            <label>
                                <input type="checkbox" name="a[]" value="A2" <?php if (in_array("A2", $a)) { echo "checked";} ?>> A2
                            </label>
                            <label>
                                <input type="checkbox" name="a[]" value="A3" <?php if (in_array("A3", $a)) { echo "checked";} ?>> A3
                            </label>   
                        </div>                     
                    </div>
                </form>
                
            </div>
        </div>
    </header>
    <section>
        <div>
            <a href="ajouter-un-etudiant.php" class="bg-[#e94a34] hover:bg-red-600 text-white font-bold py-3 px-4 rounded inline-flex items-center m-10"> Ajouter un étudiant </a>
        </div>


        <div class="w-lg mx-auto flex p-8 bg-gray-100 rounded shadow-2xl">
               <div class="">
                    <table class="table-auto">
                        <thead>
                            <tr class="">
                                <th class="px-16 pb-5"><h3>Nom</h3></th>
                                <th class="px-16 pb-5"><h3>Prénom</h3></th>
                                <th class="px-16 pb-5"><h3>Adresse mail</h3></th>
                                <th class="px-16 pb-5"><h3>Année</h3></th>
                                <th class="px-16 pb-5"><h3>Spécialité</h3></th>
                                <!-- <th class="px-16 pb-5"><h3>Modifier</h3></th> -->
                                <th class="px-16 pb-5"><h3>Supprimer</h3></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            requestRead($connection, $a, $spe, $recherche);
                            ?>
                        </tbody> 
                       
                    </table>
                </div>
        </div>
<?php

?>
    </section>   
</body>
</html>

<?php
    session_destroy();
?>

