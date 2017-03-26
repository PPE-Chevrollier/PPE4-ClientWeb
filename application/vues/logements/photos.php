<h1>Gérer les photos</h1>
<?php echo '<a class="buttonDroit" href="/photos/ajouter/' . $idLogement . '">Ajouter une photo</a>'; ?>
<?php foreach ($photos as $p)
	echo '<a href="/photos/modifier/' . $p->id_photos . '" title="Modifier ou supprimer la photo"><img src="/images/photos/' . $p->id_photos . '.' . $p->extension_photos . '" alt="' . $p->description_photos . '" width="75" height="75"></img></a>';