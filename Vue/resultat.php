<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<?php
	require_once "../Modele/Database.class.php";
	$db = new Database();

    if(isset($_POST['modif'])) { // cette première boucle créé un tableau qui placera le noms des colonnes de la table dans les cases de la première ligne ( on va dire nom, prenom, promo) 
        $tab = $db->getEtudiant($_POST['groupe']);
        
        echo "<table border=1>";
        echo "<tr>";
        
                echo "<th>Nom</th>";
                echo "<th>Prenom</th>";
                echo "<th>Promo</th>";


        echo "</tr>";
        
        foreach($tab as $cle1 => $etudiant) { // cette seconde boucle affiche le contenu de chaque etudiant 
		
			echo "<tr>";
			foreach($etudiant as $cle2 => $info) {
					echo "<td>".$info."</td>";
			
	       }
            echo "<tr>";
        }
    
    }
                   
?>
<form action="../vue/menu.php" method="post">
<input type="submit" name="annule" id="annule" value="Retour au menu" /> <!-- ce bouton permet un retour au menu -->
</form>
