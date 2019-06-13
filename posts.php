<?php
session_start();
	include 'bdd.php';
	date_default_timezone_set("Europe/Paris");
	if (isset($_POST['poster'])) {
		$query = $bdd->prepare('INSERT INTO publication(_id,message_P, date_P,time_P) VALUES(:_id, :message_P, :date_P,:time_P)');
		$marqueurs = array('_id'=>$_SESSION['id'],'message_P'=>$_POST['poster'],'date_P'=>date("d/m/y"),'time_P'=>date("H:i:s"));
		$query->execute($marqueurs);
		$query->closeCursor();	
	}
	elseif (isset($_POST['repondre'])) {
		$query = $bdd->prepare('INSERT INTO commentaire(_id,_id_P,reponse_C, date_C,time_C) VALUES(:_id,:_id_P, :reponse_C, :date_C,:time_C)');
		$marqueurs = array('_id'=>$_SESSION['id'],'_id_P'=>$_POST['hidden'],'reponse_C'=>$_POST['reponse'], 'date_C'=>date("d/m/y"),'time_C'=>date("H:i:s"));
		$query->execute($marqueurs);
		$query->closeCursor();	
	}

	header("Location: timeline.php");
	exit();
?>