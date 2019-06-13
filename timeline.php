<?php
	session_start();
	include 'bdd.php';

	$req_amis = $bdd->prepare('SELECT amis FROM utilisateur WHERE id = :id');
	$req_amis->execute(array('id'=>$_SESSION['id']));
	$rep_amis = $req_amis->fetch();
	$req_amis->closeCursor();
	if (!$_SESSION['user']) {
		header('Location: connexion.php?err=timeline');
		exit();
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://kit.fontawesome.com/cbe705ba66.js"></script>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Actualités</title>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<section>
			<?php if (isset($_SESSION['admin'])) {
				echo '<div class="post">
						<h1>Actualités :</h1>
							<form method="POST" action="posts.php">
								<p>
									<input type="text" name="poster" placeholder="Exprimez-vous" autocomplete="off">
									<input type="submit" name="submit" value="Poster">
								</p>
							</form>
					</div>';
			}
			elseif ($rep_amis['amis'] == 0) {
					echo '<div class="post">
							<h1>Actualités :</h1>
						</div>';
						echo '<div class="add_del">
								<p>L\'accès au fil d\'actualités est bloqué.<br><br>Deux raisons peuvent en être la cause :</p><p class="tabulation">- L\'accès est bloqué par défaut aux nouveaux utilisateurs. Veuillez attendre que l\'administrateur vous ajoute dans sa liste d\'amis.
								</p>
								<p class="tabulation">- L\'administrateur n\'a plus choisi de partager son fil d\'actualité avec vous. 
								</p>
							</div>';
					exit();
			}
			else {
				echo '<div class="post">
						<h1>Actualités :</h1>
					</div>';
			}
				
			?>
				<?php
					$req_message = $bdd->prepare('SELECT publication.id_P, publication.message_P,  publication.date_P, publication.time_P,utilisateur.prenom, utilisateur.nom
											FROM publication
											LEFT JOIN utilisateur ON utilisateur.id = publication._id
											ORDER BY id_P DESC
											');
					$req_message->execute();
					$rep_message = $req_message->fetchAll();
					foreach ($rep_message as $value_message) {
						echo '<div class="message">
								<p>'.$value_message['nom'].' '.$value_message['prenom'].' a posté le '.$value_message['date_P'].' à '.$value_message['time_P'].': </p>
								<p>'.$value_message['message_P'].'</p>
							';


						$req_reponse = $bdd->prepare('SELECT publication.id_P,publication.message_P, utilisateurP.prenom AS prenom_P, utilisateurC.prenom AS prenom_C, utilisateurC.nom, commentaire._id_P, commentaire.reponse_C, commentaire.date_C, commentaire.time_C
												FROM publication
												LEFT JOIN commentaire ON publication.id_P = commentaire._id_P
												LEFT JOIN utilisateur AS utilisateurP ON utilisateurP.id = publication._id
												LEFT JOIN utilisateur AS utilisateurC ON utilisateurC.id = commentaire._id
												WHERE id_P = :id_P
												ORDER BY id_C
											');
						$req_reponse->execute(array('id_P' => $value_message['id_P']));
						$rep_reponse = $req_reponse->fetchAll();

						foreach($rep_reponse as $value_reponse) {
								if(isset($value_reponse['reponse_C'])) {
									echo '<div class="reponse">
										<p><i class="fas fa-reply" id="rotate"></i> '.$value_reponse['nom'].' '.$value_reponse['prenom_C'].' a répondu le '.$value_reponse['date_C'].' à '.$value_reponse['time_C'].' :</p><p class="tabulation">'.$value_reponse['reponse_C'].'</p></div>';
								
									}
						}
				?>

				<form method="POST" class="repondre" action="posts.php">
					<p>
						<input type="text" name="reponse" placeholder="Répondre à <?php echo $value_message['prenom'];?>..." autocomplete="off">
						<input type="submit" name="repondre" value="Répondre">
						<input id="hidden" name="hidden" type="hidden" value="<?php echo $value_message['id_P']; ?>">
					</p>	
				</form>

				<?php
						echo '</div>';
						
					}
				?>	
		</section>
	</body>
</html>
