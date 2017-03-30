<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php if (isset($titre)) echo $titre . ' | '; ?>ChevLoc</title>
		<link rel="stylesheet" href="/css/style.css" />
                <link rel="stylesheet" href="/css/jquery-ui.css">
	</head>
	<body>
		<header>
			<nav><ul>
				<li><a href="/">Accueil</a></li><li><a href="/logements">Logements</a></li><li><a href="/faq">F.A.Q.</a></li><li><a href="/a-propos">A propos</a></li>
			</ul></nav>
			<div id="utilisateur"><?php if ($session->recup('id_etudiants'))
			{
				echo 'Bonjour ' . $session->recup('prenom_etudiants') . ' !<a href="/messagerie">Messagerie';
				$nbMessages = $session->recup('nb_messages');
				if ($nbMessages > 0)
					echo ' (' . $nbMessages . ')';
				echo '</a><a href="/profil/voir/' . $session->recup('login_etudiants') . '">Mon profil</a><a href="/logements/miens">Mes logements</a><a href="/connexion/deconnexion">Déconnexion</a>';
			}
			else echo '<a href="/connexion">Connexion</a>'; ?></div>
		</header>
		<main>
			<?php if (isset($contenu)) echo $contenu; ?>
		</main>
		<footer>&copy; 2017 - PPE Chevrollier<br />Tous droits réservés.</footer>
		<script src="/js/jquery-3.1.1.min.js"></script>
                <script src="/js/jquery-ui.js"></script>
		<?php if (isset($scripts))
		{
			foreach ($scripts as $s)
				echo '<script src="/js/' . $s . '.js"></script>';
		}
		?>
	</body>
</html>