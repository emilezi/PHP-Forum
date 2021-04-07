<?php
if((isset($_SESSION['pseudo'])) && (isset($_SESSION['prenom'])) && (isset($_SESSION['nom'])))
	{
		
	?>
	
	<form method="post">
	<br/>
	<input type="button" value="B" style="font-weight:bold;" onclick="editextcommande('bold');" />
	<input type="button" value="I" style="font-style:italic;" onclick="editextcommande('italic');" />
	<input type="button" value="U" style="text-decoration:underline;" onclick="editextcommande('underline');" />
	<input type="button" value="Lien" onclick="editextcommande('createLink');" />
	<br/><br/>
	<div id="editeur" contentEditable=true></div>
	<br/><br/><br/>
	<input id="message" type="hidden" name="message" />
	<input type="submit" name="submit_txt" value="Poster" onclick="editextresult();">
	</form>
	
	<script src="editext.js" ></script>
	
	<?php

	if (isset ($_POST['submit_txt'])) {
	if (!empty($_POST['message']) && !empty($presult['titre'])) {
	
		
		$id = md5(microtime(TRUE)*100000);
		
		$q = $db->prepare("INSERT INTO forum_reponses(auteur,message,correspondance_sujet,id_reponses) VALUES(:auteur,:message,:correspondance_sujet,:id_reponses)");
		$q->execute([
		'auteur' => $_SESSION['pseudo'],
		'message' => $_POST['message'],
		'correspondance_sujet'=> $presult['titre'],
		'id_reponses' => $id
		]);

		header('Location: lire_sujet.php?id_sujet_a_lire='.$_GET['id_sujet_a_lire']);
		exit();
	}else{
		echo "<p>Veuillez bien renseigner tous les champs</p>";
	}
	}
	}else{
		echo "<p>Veuillez vous connecter à votre compte</p>";
	}
?>
