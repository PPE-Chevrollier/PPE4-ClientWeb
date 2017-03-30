<h1>Nouveau message</h1>
<?php
$html->ouvrirFormulaire('messages', '#');
$html->champ('destinataire_messages');
$html->champ('sujet_messages');
$html->champMultiLigne('texte_messages');
$html->boutonEnvoyer('Envoyer');
$html->fermerFormulaire();