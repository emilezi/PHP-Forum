<?php
	session_start();
	include 'database.php'; 
	global $db;

	echo "<html>";
	
	echo
	"<head>
   <meta charset='utf-8' />
   <title>Suppression du sujet</title>
   </head>";
   
   echo "<body>";

   echo "<h1>Suppression du sujet</h1>";
    
   if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
   {
    
   if(isset($_GET['id_sujet_a_supprimer'])){
   		  	
   		  	$c = $db->prepare("SELECT * FROM forum_sujet WHERE id_sujet=:id_sujet");
   		  	$c->execute([
   		  	'id_sujet'=> $_GET['id_sujet_a_supprimer']
   		  	]);
   		  	$result = $c->fetch();
   		  	
   		  	if($result == true){
   		  	if($result['auteur'] == $_SESSION['pseudo']){
  
  
	echo "<p>Etes vous vraiment sur de supprimer le sujet selectionner</p>";
  
  	echo
  	"<form method='post'>
  	<input type='radio' name='delradio' value='Non' checked />Non
  	<input type='radio' name='delradio' value='Oui' />Oui<br/><br/>
  	<input type='submit' name='submit' value='Valider'>
  	</form>";
   
   if(isset($_POST["submit"])){
   	extract($_POST);
   if($delradio == "Oui")
   	{
   	 	$d = $db->prepare("DELETE FROM `forum_sujet` WHERE titre=:titre");
   		  	$d->execute([
   		  	'titre' => $result['titre']
   		  	]);
   		  	
   		  	$f = $db->prepare("DELETE FROM `forum_reponses` WHERE correspondance_sujet=:correspondance_sujet");
   		  	$f->execute([
   		  	'correspondance_sujet' => $result['titre']
			]);
   		  	
   		  	header('Location: my_sujets.php');
   		  }else{
   	header('Location: my_sujets.php');
   	}
	}
  
  	}else{
		echo "<p>Sujet non defini</p>";
  	}
  	}else{
		echo "<p>Sujet non defini</p>";
  	}
  	}else{
		echo "<p>Sujet non defini</p>";
  	}
  	}else{
	header('Location: ../index.php');
	}
  
  	echo "</div>";
  	
  	echo
  	"</body>
  	</html>";

?>
