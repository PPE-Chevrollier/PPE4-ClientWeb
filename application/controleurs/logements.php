<?php
namespace App\Controleurs
{
	class Logements extends \Systeme\Controleur
	{
		public function chercher()
		{
      $this->chargerService('connexion-simple');
			$this->chargerModele('logements');
			$this->chargerModele('villes');
			$this->chargerValidateur('logements');
			if ($this->validateurLogements->chercher())
			{
				$idVille = $this->validateurLogements->recupValeur('ville_logements');
				$logements = $this->logements->recupParVille($idVille);
				$villes = $this->villes->recupToutes();
				$villes2 = [];
				foreach ($villes as $v)
					$villes2[$v->id_villes] = $v->nom_villes;
				$this->chargerVue('index', ['estConnecte' => $this->serviceConnexionSimple->recupPersonne() != null, 'logements' => $logements, 'titre' => 'Résultats de recherche', 'villes' => $villes2]);
			}
		}
		
		public function index()
		{
			$this->chargerService('connexion-simple');
			$this->chargerModele('logements');
			$this->chargerModele('villes');
			$this->chargerValidateur('logements');
			$this->validateurLogements->chercher();
			$logements = $this->logements->recupTous();
			$villes = $this->villes->recupToutes();
			$villes2 = [];
			foreach ($villes as $v)
				$villes2[$v->id_villes] = $v->nom_villes;
			$this->chargerVue('', ['estConnecte' => $this->serviceConnexionSimple->recupPersonne() != null, 'logements' => $logements, 'titre' => 'Liste des logements', 'villes' => $villes2]);
		}
		
		public function nouveau()
		{
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$this->chargerModele('proprietaires');
			$this->chargerModele('villes');
			$this->chargerModele('motifs');
			$this->chargerValidateur('logements');
			if ($this->validateurLogements->ajouter())
			{
				$idVille = 0;
				$ville = $this->villes->recup($this->validateurLogements->recupValeur('ville_logements'));
				if (!$ville)
					$idVille = $this->villes->ajouter($this->validateurLogements->recupValeur('ville_logements'));
				else
					$idVille = $ville->id_villes;
				$idProprietaire = 0;
				$proprietaire = $this->proprietaires->recup($this->validateurLogements->recupValeur('nom_proprietaire'), $this->validateurLogements->recupValeur('prenom_proprietaire'), $this->validateurLogements->recupValeur('sexe_proprietaire'));
				if (!$proprietaire)
					$idProprietaire = $this->proprietaires->ajouter($this->validateurLogements->recupValeur('nom_proprietaire'), $this->validateurLogements->recupValeur('prenom_proprietaire'), $this->validateurLogements->recupValeur('sexe_proprietaire'));
				else
					$idProprietaire = $proprietaire->id_proprietaires;
				$fichier = $this->validateurLogements->recupValeur('photo');
				$extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
				$idPhoto = $this->photos->ajouter($extension, $this->validateurLogements->recupValeur('description_photos'));
				move_uploaded_file($fichier['tmp_name'], 'images/photos/' . $idPhoto . '.' . $extension);
				$idLogement = $this->logements->ajouter($idProprietaire, $idPhoto, $this->validateurLogements->recupValeur('rue_logements'), $this->validateurLogements->recupValeur('complement_adresse_logements'), $idVille, $this->validateurLogements->recupValeur('cp_logements'), $this->validateurLogements->recupValeur('prix_logements'), $this->validateurLogements->recupValeur('surface_logements'));
				$this->logements->ajouterIllustration($idLogement, $idPhoto);
				$idMotif = 0;
				$motif = $this->motifs->recup($this->validateurLogements->recupValeur('libelle_motifs'));
				if (!$motif)
					$idMotif = $this->motifs->ajouter($this->validateurLogements->recupValeur('libelle_motifs'));
				else
					$idMotif = $motif->id_motifs;
				$this->logements->ajouterProposition($idLogement, $this->serviceConnexion->recupPersonne()->id_etudiants, $idMotif);
        echo $this->validateurLogements->recupValeur('type_logements').'<br/>';
        echo $idLogement.'<br/>';
        echo $this->validateurLogements->recupValeur('nb_places_appartements').'<br/>';
        echo $this->validateurLogements->recupValeur('nb_chambres_appartements').'<br/>';
        echo $this->validateurLogements->recupValeur('parties_communes_chambres').'<br/>';
        echo $this->validateurLogements->recupValeur('meuble_studios').'<br/>';
        switch ($this->validateurLogements->recupValeur('type_logements'))
        {
          case 1:
            $this->logements->ajouterAppartement($idLogement, $this->validateurLogements->recupValeur('nb_places_appartements'), $this->validateurLogements->recupValeur('nb_chambres_appartements'));
            break;
          case 2:
            $this->logements->ajouterChambreHabitant($idLogement, $this->validateurLogements->recupValeur('parties_communes_chambres'));
            break;
          case 3:
            $this->logements->ajouterStudio($idLogement, $this->validateurLogements->recupValeur('meuble_studios'));
            break;
        }        
				$this->rediriger('logements', 'voir', [$idLogement]);
			}
			else
				$this->chargerVue('', ['titre' => 'Nouveau logement', 'scripts' => ['logementsNouveau']]);
		}
		
		public function voir($params)
		{
			$this->chargerModele('logements');
			$id = (sizeof($params) == 1) ? $params[0] : 0;
			$logement = $this->logements->recupParId($id);
			if ($logement)
			{
				$this->chargerVue('', [
					'complementAdresse' => $logement->complement_adresse_logements,
					'cp' => $logement->cp_logements,
					'descriptionPhoto' => $logement->description_photos,
					'meuble' => $logement->meuble_studios,
					'nbAvis' => $logement->nb_avis,
					'nbChambres' => $logement->nb_chambres_appartements,
					'nbPlaces' => $logement->nb_places_appartements,
					'nomEtudiant' => $logement->nom_etudiants,
					'nomProprietaire' => $logement->nom_proprietaires,
					'noteMoyenne' => $logement->note_moyenne,
					'partiesCommunes' => $logement->parties_communes_chambre,
					'photo' => $logement->id_photos . '.' . $logement->extension_photos,
					'prenomEtudiant' => $logement->prenom_etudiants,
					'prenomProprietaire' => $logement->prenom_proprietaires,
					'prix' => $logement->prix_logements,
					'rue' => $logement->rue_logements,
					'sexeEtudiant' => $logement->sexe_etudiants,
					'sexeProprietaire' => $logement->sexe_proprietaires,
					'surface' => $logement->surface_logements,
					'titre' => 'Consultation d\'un logement',
					'type' => $logement->type,
					'ville' => $logement->nom_villes]);
			}
			else
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
		}
	}
}