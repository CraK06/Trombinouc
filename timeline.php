<?php
	session_start();
	include 'bdd.php';

	$req_amis = $bdd->prepare('SELECT amis FROM utilisateur WHERE id = :id');
	$req_amis->execute(array('id'=>$_SESSION['id']));
	$rep_amis = $req_amis->fetch();
	$req_amis->closeCursor();
	if (!$_SESSION['user']) {
		header('Location: connexion.php?err=timeline');
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://kit.fontawesome.com/cbe705ba66.js"></script>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title></title>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<section>
			<?php if (isset($_SESSION['admin'])) {
				echo '<div class="post">
						<h1>Actualités :</h1>
							<form method="POST" action="posts.php">
								<p>
									<input type="text" name="poster" placeholder="Exprimez-vous">
									<input type="submit" name="submit" value="Poster">
								</p>
							</form>
					</div>';
			}
			elseif ($rep_amis['0'] == 0) {
				echo '<div class="post">
						<h1>Actualités :</h1>
					</div>';
					echo '<div class="add_del"><p>L\'accès au fil d\'actualités est bloqué par défaut aux nouveaux utilisateurs. Veuillez attendre que l\'admin vous ajoute dans ses amis.</p></div>';
				exit();
			}
			else {
				echo '<div class="post">
						<h1>Actualités :</h1>
					</div>';
			}
				
			?>
				<?php
					$req2 = $bdd->prepare('SELECT publication.id_P, publication.message_P,  publication.date_P, publication.time_P,utilisateur.prenom, utilisateur.nom
											FROM publication
											LEFT JOIN utilisateur ON utilisateur.id = publication._id
											ORDER BY id_P DESC
											');
					$req2->execute();
					$rep2 = $req2->fetchAll();
					foreach ($rep2 as $value) {
						echo '<div class="message">
								<p>'.$value['nom'].' '.$value['prenom'].' a posté le '.$value['date_P'].' à '.$value['time_P'].': </p>
								<p>'.$value['message_P'].'</p>
							';


						$req3 = $bdd->prepare('SELECT publication.id_P,publication.message_P, utilisateurP.prenom AS prenom_P, utilisateurC.prenom AS prenom_C, utilisateurC.nom, commentaire._id_P, commentaire.reponse_C, commentaire.date_C, commentaire.time_C
												FROM publication
												LEFT JOIN commentaire ON publication.id_P = commentaire._id_P
												LEFT JOIN utilisateur AS utilisateurP ON utilisateurP.id = publication._id
												LEFT JOIN utilisateur AS utilisateurC ON utilisateurC.id = commentaire._id
												WHERE id_P = :id_P
												ORDER BY id_C
											');
						$req3->execute(array('id_P' => $value['id_P']));
						$rep3 = $req3->fetchAll();

						foreach($rep3 as $value2) {
								if(isset($value2['reponse_C'])) {
									echo '<div class="reponse">
										<p><i class="fas fa-reply" id="rotate"></i> '.$value2['nom'].' '.$value2['prenom_C'].' a répondu le '.$value2['date_C'].' à '.$value2['time_C'].' :</p><p class="tabulation">'.$value2['reponse_C'].'</p></div>';
								
									}
						}
				?>

				<form method="POST" class="repondre" action="posts.php">
					<p>
						<input type="text" name="reponse" placeholder="Répondre à <?php echo $value['prenom'];?>...">
						<input type="submit" name="repondre" value="Répondre">
						<input id="hidden" name="hidden" type="hidden" value="<?php echo $value['id_P']; ?>">
					</p>	
				</form>

				<?php
						echo '</div>';
						
					}
				?>	
		</section>
	</body>
</html>
