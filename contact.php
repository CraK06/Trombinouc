<?php
session_start();
include 'bdd.php';

if(isset($_POST['submit_contact']))
{
	$user_contact = htmlspecialchars($_POST['user_contact']);
	$objet_contact = htmlspecialchars($_POST['objet_contact']);
	$message_contact = htmlspecialchars($_POST['message_contact']);

	if(!empty($user_contact) AND !empty($objet_contact) AND !empty($message_contact))
	{
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $user_contact)) // On filtre les serveurs qui rencontrent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
 
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========
		 
		//=====Création du header de l'e-mail.
		$header = "From: Trombinouc <".$_SESSION['mail'].">".$passage_ligne;
		$header.= "Reply-to: ".$_SESSION['nom']." ".$_SESSION['prenom']."<".$_SESSION['mail'].">".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========
		 
		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========
		 
		//=====Envoi de l'e-mail.
		mail($user_contact,$objet_contact,$message_contact,$header);
		header('Location: amis.php?mail=done');
		exit();
		//==========

	}
	else
	{
		header('Location: amis.php');
		exit();
	}
}
else {
	header('Location: amis.php');
	exit();
}
?>