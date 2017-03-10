<h1>Profil de <?php echo $nomUtilisateur; ?></h1>
<p>Nom d'utilisateur : <?php echo $nomUtilisateur; ?><br />
Nom : <?php echo $nom; ?><br />
Prénom : <?php echo $prenom; ?><br />
Adresse E-mail : <?php echo $mail; ?><br />
N° de téléphone : <?php if (!empty($tel)) echo $tel; else echo 'N/A'; ?><br />
Sexe : <?php if ($sexe == 'M') echo 'Homme'; else echo 'Femme'; ?></p>