<?php 
	session_start();
	include 'database.php'; 
	global $db;
	
	echo
	"<html>";
	
	echo
  	"<head>
	<meta charset='utf-8' />
   <title>Mes sujets</title>
   </head>";
  
  	echo "<body>";
    
  	echo "<h1>Mes sujets</h1>";
  
  	if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
  	{
  	
  	$q = $db->prepare("SELECT * FROM forum_sujet WHERE auteur=:auteur");
  	$q->execute([
	  'auteur' => $_SESSION['pseudo'],
	]);
	$nb_sujets = $q->rowCount();

	if ($nb_sujets == 0) {
	echo '<p>Aucuns sujets à afficher</p>';
	}else{
	
	$i=0;
	
	while($result = $q->fetch(PDO::FETCH_ASSOC)){
	
	$i = $i +1;
	
	echo "<a href='./lire_sujet.php?id_sujet_a_lire=".$result['id_sujet']."'>";

	echo "<h2>".$result['titre']." - ".$result['categorie']."</h2>";
	
	echo "<p>".$i." - ".$result['date_derniere_reponse']."</p></a><br/>";
	
	echo "<form action='edit_sujet.php?id_sujet_a_modifier=".$result['id_sujet']."' method='post'>
	<input type='submit' name='edit_sujet".$result['id_sujet']."'value='Modifier'>
	</form>";
	
	echo "<form action='delsujet.php?id_sujet_a_supprimer=".$result['id_sujet']."' method='post'>
	<input type='submit' name='delsujet".$result['id_sujet']."' value='Supprimer'>
	</form>";

	}		
	}
	}else{
	echo "<p>Veuillez vous connecter à votre compte</p>";
	}
  
  	echo
  	"</body>
	</html>";
	
?>
