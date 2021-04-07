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
    
   echo "<h1>Modification du message</h1>";

	if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
	{
	if(isset($_GET['id_sujet_a_modifier'])){
			
	$c = $db->prepare("SELECT * FROM forum_sujet WHERE id_sujet=:id_sujet");
   $c->execute([
   'id_sujet'=> $_GET['id_sujet_a_modifier']
   ]);
   
   $result1 = $c->fetch();
   
   $s = $db->prepare("SELECT * FROM forum_reponses WHERE id_reponses=:id_reponses");
   $s->execute([
   'id_reponses'=> $_GET['id_sujet_a_modifier']
   ]);
   
   $result2 = $s->fetch();
   		
   if($result1 == true){
   if($result1['auteur'] == $_SESSION['pseudo']){
  
	if (isset ($_POST['submit'])) {
	if (!empty($_POST['titre']) && !empty($_POST['message'])) {
	if (preg_match("#^[^<>]+$#i", $_POST['titre']))
	{
	
	$q = $db->prepare("UPDATE forum_sujet SET titre = :titre WHERE id_sujet = :id_sujet");
	$q->execute([
	'id_sujet' => 	$_GET['id_sujet_a_modifier'],
   	'titre' => $_POST['titre']
   	]);
	$k = $db->prepare("UPDATE forum_reponses SET correspondance_sujet  = :update WHERE correspondance_sujet = :titre");
	$k->execute([
	'titre' => $result1['titre'],
   	'update' => $_POST['titre']
   	]);
   	$k = $db->prepare("UPDATE forum_reponses SET message = :message WHERE id_reponses = :id_reponses");
	$k->execute([
	'id_reponses' => $_GET['id_sujet_a_modifier'],
   	'message' => $_POST['message']
   	]);
    
   echo "<p>Votre sujet à bien été modifié</p>";
    
	}else{
	echo "<p>Certains champs ne respectent pas la forme demandée</p>";
	}
	}else{
	echo "<p>Veuillez renseigner l'ensemble des champs</p>";
	}
	}else{
	
	?>
	
	<form method="post"><br/>
	<p>Modification du titre<p>
	<input type="text" name="titre" maxlength="50" size="50" value="<?= $result1['titre'] ?>" required><br/>
	<p>Modification du sujet<p>
	<input type="button" value="B" style="font-weight:bold;" onclick="editextcommande('bold');" />
	<input type="button" value="I" style="font-style:italic;" onclick="editextcommande('italic');" />
	<input type="button" value="U" style="text-decoration:underline;" onclick="editextcommande('underline');" />
	<input type="button" value="Lien" onclick="editextcommande('createLink');" />
	<br/>
	<div id="editeur" contentEditable=true><?= $result2['message'] ?></div>
	<br/><br/><br/>
	<input id="message" type="hidden" name="message" />
	<input type="submit" name="submit" value="Modifer" onclick="editextresult();">
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
	echo "<p>Veuillez vous connecter à votre compte</p>";
	}

	echo "</div>";
	echo "</div>";

	echo 
	"</body>
	</html>";
?>