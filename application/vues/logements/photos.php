<a href="/photos/ajouter/<?php echo $idLogement; ?>">Ajouter une photo</a>
<h1Gérer les photos</h1>
<?php foreach ($photos as $p)
	echo '<img src="/images/photos/' . $p->id_photos . '.' . $p->extension_photos . '" alt="' . $p->description_photos . '"></img>';