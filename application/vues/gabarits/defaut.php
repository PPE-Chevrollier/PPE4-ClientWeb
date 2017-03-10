<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php if (isset($titre)) echo $titre . ' | '; ?>Chev Book</title>
		<link rel="stylesheet" href="/css/style.css" />
	</head>
	<body>
		<header>
			<nav><ul>
				<li><a href="/">Accueil</a></li><li><a href="/plantes">Plantes</a></li><li><a href="/meteo">Météo</a></li><li><a href="/faq">F.A.Q.</a></li><li><a href="/a-propos">A propos</a></li>
			</ul></nav>
			<div id="utilisateur"><?php if ($session->recup('prenom_personnes')) echo 'Bonjour ' . $session->recup('prenom_personnes') . ' !<a href="/profil/modifier">Modifier le profil</a><a href="/connexion/deconnexion">Déconnexion</a>'; else echo '<a href="/connexion">Connexion</a><a href="/champs/ajouter">Inscription</a>'; ?></div>
		</header>
		<main>
			<?php if (isset($contenu)) echo $contenu; ?>
		</main>
		<footer>&copy; 2016 La Harry Co.<br />Tous droits réservés.</footer>
	</body>
</html>