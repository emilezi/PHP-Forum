<?php
	session_start();
	include 'database.php'; 
	global $db;

	echo "<html>";
	
	echo
	"<head>
   <meta charset='utf-8' />
   <title>Suppression de la reponse</title>
  	</head>";
  
  	echo "<body>";
    
   if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
   {

	echo "<h1>Suppression de la reponse</h1>";
    
   if(isset($_GET['message_a_supprimer'])){
   		  	
   		  	$c = $db->prepare("SELECT * FROM forum_reponses WHERE id_reponses=:id_reponses");
   		  	$c->execute([
   		  	'id_reponses'=> $_GET['message_a_supprimer']
   		  	]);
   		  	$result = $c->fetch();
   		  	
   		  	if($result == true){
   		  	if(($result['auteur']) == ($_SESSION['pseudo'])){

	echo "<div class='forum-content'>";
  
  	echo "<p>Etes vous vraiment sur de supprimer la réponse</p>";
  
  	echo "<form method='post'>
  	<input type='radio' name='delradio' value='Non' checked />Non
  	<input type='radio' name='delradio' value='Oui' />Oui<br/><br/>
  	<input type='submit' name='submit' value='Valider'>
  	</form>";
   
   if(isset($_POST["submit"])){
   	extract($_POST);
   if($delradio == "Oui")
   {
   		  	$f = $db->prepare("DELETE FROM `forum_reponses` WHERE id_reponses=:id_reponses");
   		  	$f->execute([
   		  	'id_reponses' => $_GET['message_a_supprimer']
   		  	]);
   		  	
   		  	header('Location: lire_sujet.php?id_sujet_a_lire='.$_GET['id_sujet_a_lire']);
   		  }else{
   	header('Location: lire_sujet.php?id_sujet_a_lire='.$_GET['id_sujet_a_lire']);
   	}
	}
  
  	echo "</div>";
  
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
