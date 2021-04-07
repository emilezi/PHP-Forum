<?php
	session_start();
	include 'database.php'; 

	echo "<html>";
	
	echo
	"<head>
	<meta charset='utf-8' />
	<link rel='stylesheet' href='style.css'/>
	<title>Nouveau sujet</title>
	</head>";
    
	echo "<body>";
    
   echo "<h1>Nouveau sujet</h1>";


	if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
	{
  
	if (isset ($_POST['submit'])) {
	if (!empty($_POST['categorie']) && !empty($_POST['titre']) && !empty($_POST['message'])) {
	if (preg_match("#^[^<>]+$#i", $_POST['titre']) && preg_match("#^[^<>]+$#i", $_POST['categorie']))
	{
		
		$id = md5(microtime(TRUE)*100000);
		
	
		$q = $db->prepare("INSERT INTO forum_sujet (auteur,categorie,titre,id_sujet) VALUES (:auteur,:categorie,:titre,:id_sujet)");
		$q->execute([
    'auteur' => $_SESSION['pseudo'],
    'categorie' => $_POST['categorie'],
    'titre' => $_POST['titre'],
    'id_sujet' => $id
    ]);
		$c = $db->prepare("INSERT INTO forum_reponses(auteur,message,correspondance_sujet,id_reponses) VALUES (:auteur,:message,:correspondance_sujet,:id_reponses)");
		$c->execute([
    'auteur' => $_SESSION['pseudo'],
    'message' => $_POST['message'],
    'correspondance_sujet' => $_POST['titre'],
    'id_reponses' => $id
	]);

    echo "<p>Votre sujet à bien été posté</p>";
	
	}else{
	echo "<p>Certain champs ne respectent pas la forme demandée</p>";
	}
	}else{
	echo "<p>Veuillez bien renseigner tous les champs</p>";
	}
	}else{
	
	?>
	<form method="post"><br/>
	<input type="text" name="titre" maxlength="50" size="50" placeholder='Saisissez un titre' required>
	<br/><br/>
   	<select name='categorie' size='1'>
   	<option value="autres">Sélectionnez une catégorie
  	<option value="informatique">Informatique
  	<option value="programmation">Programmation
  	<option value="social">Social
    <option value="autres">Autres
    </select>
	<br/><br/>
	<p>Réalisez votre sujet<p>
	<input type="button" value="B" style="font-weight:bold;" onclick="editextcommande('bold');" />
	<input type="button" value="I" style="font-style:italic;" onclick="editextcommande('italic');" />
	<input type="button" value="U" style="text-decoration:underline;" onclick="editextcommande('underline');" />
	<input type="button" value="Lien" onclick="editextcommande('createLink');" />
	<br/>
	<div id="editeur" contentEditable=true></div>
	<br/><br/><br/>
	<input id="message" type="hidden" name="message" />
	<input type="submit" name="submit" value="Poster" onclick="editextresult();">
	</form>
	
	<script src="editext.js" ></script>
	
	<?php
	
	}
	}else{
	echo "<p>Veuillez vous connecter à votre compte</p>";
	}


	echo 
	"</body>
	</html>";
?>