<?php 

if (isset($_SESSION['user']) AND isset($_SESSION['admin']) AND $_SESSION['admin'] == TRUE AND $_SESSION['user'] == TRUE) {
	echo 	'<div class="conteneur">
				<div class="contenu_gauche">
					<a href="index.php"><h1>Trombinouc</h1></a>
				</div>
				
				<div class="contenu_droite">
					<nav>
						<ul>
							<li>
								<a href="index.php"><i class="fas fa-star"></i> Accueil</a>
							</li>
							<li>
								<a href="timeline.php"><i class="far fa-newspaper"></i> Actualités</a>
							</li>
							<li>
								<a href="amis.php"><i class="fas fa-user-friends"></i> Amis</a>
							</li>
							<li>
								<a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
							</li>
						</ul>
					</nav>
				</div>
				<p id="spacer"></p>
			</div>';
}
elseif (isset($_SESSION['user']) AND $_SESSION['user'] == TRUE) {
	echo 	'<div class="conteneur">
				<div class="contenu_gauche">
					<a href="index.php"><h1>Trombinouc</h1></a>
				</div>
				
				<div class="contenu_droite">
					<nav>
						<ul>
							<li>
								<a href="index.php"><i class="fas fa-star"></i> Accueil</a>
							</li>
							<li>
								<a href="timeline.php"><i class="far fa-newspaper"></i> Actualités</a>
							</li>
							<li>
								<a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
							</li>
						</ul>
					</nav>
				</div>
				<p id="spacer"></p>
			</div>';
}
else {
	echo 	'<div class="conteneur">
				<div class="contenu_gauche">
					<a href="index.php"><h1>Trombinouc</h1></a>
				</div>
				
				<div class="contenu_droite">
					<nav>
						<ul>
							<li>
								<a href="index.php"><i class="fas fa-star"></i> Accueil</a>
							</li>
							<li>
								<a href="timeline.php"><i class="far fa-newspaper"></i> Actualités</a>
							</li>
							<li>
								<a href="connexion.php"><i class="fas fa-sign-in-alt"></i> Connexion</a>
							</li>
						</ul>
					</nav>
				</div>
				<p id="spacer"></p>
			</div>';	
}



?>