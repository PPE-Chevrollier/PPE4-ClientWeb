<?php
namespace App\Controleurs
{
	class Photos extends \Systeme\Controleur
	{
		public function ajouter($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$this->chargerValidateur('photos');
			$logement = $this->logements->recupParId($params[0]);
			if ($logement->id_etudiants == $this->session->recup('id_etudiants'))
			{
				if ($this->validateurPhotos->ajouter())
				{
					$fichier = $this->validateurPhotos->recupValeur('photo');
					$extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
					$idPhoto = $this->photos->ajouter($extension, $this->validateurPhotos->recupValeur('description_photos'));
					move_uploaded_file($fichier['tmp_name'], 'images/photos/' . $idPhoto . '.' . $extension);
					$this->logements->ajouterIllustration($params[0], $idPhoto);
					$this->rediriger('logements', 'photos', [$params[0]]);
				}
				else
					$this->chargerVue('', ['titre' => 'Ajouter une photo']);
			}
			else
				$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
		}
		
		public function changer($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$idPhoto = (sizeof($params) == 1) ? $params[0] : 0;
			$photo = $this->photos->recupParId($idPhoto);
			if ($photo == null)
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
			else
			{
				$droit = $this->photos->droitSorPhoto($idPhoto, $this->session->recup('id_etudiants'));
				if ($droit == null)
					$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
				else
				{
					$this->logements->changerPhoto($droit->id_logements, $idPhoto);
					$this->rediriger('logements', 'photos', [$droit->id_logements]);
				}
			}
		}
		
		public function modifier($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('photos');
			$this->chargerValidateur('photos');
			$photo = $this->photos->recupParId($params[0]);
			if ($photo == null)
				$this->chargerVue('introuvable', ['titre' => 'Photo introuvable']);
			else
			{
				$droit = $this->photos->droitSurPhoto($photo->id_photos, $this->session->recup('id_etudiants'));
				if ($droit == null)
					$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
				else
				{
					if ($this->validateurPhotos->modifier())
					{
						$this->photos->modifier($photo->id_photos, $this->validateurPhotos->recupValeur('description_photos'));
						$this->rediriger('logements', 'photos', [$droit->id_logements]);
					}
					else
					{
						$this->validateurPhotos->definirValeur('description_photos', $photo->description_photos);
						$this->chargerVue('', ['descriptionPhoto' => $photo->description_photos, 'extensionPhoto' => $photo->extension_photos, 'idPhoto' => $photo->id_photos, 'photoLogement' => $droit->photo_logements, 'titre' => 'Modifier la photo']);
					}
				}
			}
		}
		
		public function supprimer($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$id = (sizeof($params) == 1) ? $params[0] : 0;
			$photo = $this->photos->recupParId($id);
			if ($photo == null)
				$this->chargerVue('introuvable', ['titre' => 'Photo introuvable']);
			else
			{
				$droit = $this->photos->droitSurPhoto($id, $this->session->recup('id_etudiants'));
				$photos = $this->photos->recupParLogement($droit->id_logements);
				if ($droit == null)
					$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
				else if (sizeof($photos) == 1)
					$this->chargerVue('impossible', ['titre' => 'Suppression impossible']);
				else
				{
					foreach ($photos as $p)
					{
						if ($p->id_photos != $photo->id_photos)
						{
							$this->logements->changerPhoto($droit->id_logements, $p->id_photos);
							break;
						}
					}
					$this->photos->supprimer($photo->id_photos);
					unlink('images/photos/' . $photo->id_photos . '.' . $photo->extension_photos);
					$this->rediriger('logements', 'photos', [$droit->id_logements]);
				}
			}
		}
	}
}