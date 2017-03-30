<h1>Modifier la photo</h1>
<?php
if ($idPhoto != $photoLogement)
	echo '<a class="buttonDroit" href="/photos/changer/' . $idPhoto . '">Définir comme photo principale</a>';
echo '<a class="buttonDroit" href="/photos/supprimer/' . $idPhoto . '">Supprimer la photo</a>';
echo '<img src="/images/photos/' . $idPhoto . '.' . $extensionPhoto . '" alt="' . $descriptionPhoto . '" width="100" height="100"></img>';
$html->ouvrirFormulaire('photos', '#');
$html->champ('description_photos');
$html->boutonEnvoyer('Modifier');
$html->fermerFormulaire();