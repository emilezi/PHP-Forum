<?php 
	session_start();
	include 'database.php'; 
	echo "<html>";
    
   ?>
   <head>
   <meta charset='utf-8'/>
   <title>Forum</title>
   </head>
   <?php
    
   echo "<body>";
    
    echo "<h1>Forum</h1>";

	$q = $db->prepare("SELECT * FROM forum_sujet");
	$nb_sujets = $q->rowCount();

	if ($nb_sujets == 0) {
    echo "Aucuns sujets à afficher";
	}
	else {
	
	while($result = $q->fetch(PDO::FETCH_ASSOC)){
	
    sscanf($result['date_derniere_reponse'], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde); 
    
    echo "<a href='./lire_sujet.php?id_sujet_a_lire=" . $result['id_sujet'] . "'>";
	
    echo "<h2>" . $result['titre'] . " - " . $result['categorie'] . "</h2>";
	
	echo "<p>" . $result['auteur'] . " - " . $jour . " - " . $mois . " - " . $annee . " " . $heure . " : " . $minute . "</p></a>";

	}
	}

	echo "<p><a href='new_sujet.php'>Nouveau sujet</a></p>
    <p><a href='my_sujets.php'>Mes sujets</a></p>";


	echo
	"</body>
	</html>";

?>