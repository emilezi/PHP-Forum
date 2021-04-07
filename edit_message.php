<?php
	session_start();
	include 'database.php'; 
	global $db;

	echo "<html>";
	
	echo
	"<head>
   <meta charset='utf-8' />
   <link rel='stylesheet' href='style.css'/>
   <title>Modification du message</title>
  	</head>";
  
  	echo "<body>";
  	
  	echo
   "<div id='header'>
   <h1>Modification du message</h1>
   </div>";
    
   if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
   {
    
   if(isset($_GET['message_a_modifier'])){
   		  	
   		  	$c = $db->prepare("SELECT * FROM forum_reponses WHERE id_reponses=:id_reponses");
   		  	$c->execute([
   		  	'id_reponses'=> $_GET['message_a_modifier']
   		  	]);
   		  	$result = $c->fetch();
   		  	
   		  	if($result == true){
   		  	if($result['auteur'] == $_SESSION['pseudo']){
    
	if (isset($_POST['submit'])){
	if (!empty($_POST['message'])){
	
   $v = $db->prepare("UPDATE forum_reponses SET message = :message WHERE id_reponses = :id_reponses");
	$v->execute([
	'id_reponses' => $_GET['message_a_modifier'],
   'message' => $_POST['message']
   ]);
    
   echo "<p>Votre message à bien été modifié</p>";
   
	}else{
	echo "<p>Veuillez bien renseigner le champs</p>";
	}
	}else{
	
	?>
	
	<form method="post"><br/>
	<p>Modification du commentaire<p>
	<input type="button" value="B" style="font-weight:bold;" onclick="editextcommande('bold');" />
	<input type="button" value="I" style="font-style:italic;" onclick="editextcommande('italic');" />
	<input type="button" value="U" style="text-decoration:underline;" onclick="editextcommande('underline');" />
	<input type="button" value="Lien" onclick="editextcommande('createLink');" />
	<br/>
	<div id="editeur" contentEditable=true><?= $result['message'] ?></div>
	<br/><br/><br/>
	<input id="message" type="hidden" name="message"/>
	<input type="submit" name="submit" value="Modifier" onclick="editextresult();">
	</form>
	
	<script src="editext.js" ></script>

	<?php
	
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
  
  echo
  "</body>
  </html>";
  
?>
