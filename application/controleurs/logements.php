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
				$tab = null;
				$idVille = $this->validateurLogements->recupValeur('ville_logements');
				$idTypeLogement = $this->validateurLogements->recupValeur('type_logements');
				$idSurface = $this->validateurLogements->recupValeur('surface_logements');
				$idPrix = $this->validateurLogements->recupValeur('prix_logements');
				if ($idVille) $tab['ville_logements'] = ['valeur' => $idVille, 'signe' => "="];
				if ($idTypeLogement) $tab['type_logements'] = ['valeur' => $idTypeLogement, 'signe' => "="];
				if ($idSurface != 0) $tab['surface_logements'] = ['valeur' => $idSurface, 'signe' => ">"];
				if ($idPrix != 0) $tab['prix_logements'] = ['valeur' => $idPrix, 'signe' => "<"];
				
				$logements = $this->logements->recupParRecherche($tab);
				$villes = $this->villes->recupToutes();
				$villes2 = ['0' => '---'];
				foreach ($villes as $v)
					$villes2[$v->id_villes] = $v->nom_villes;
				$this->chargerVue('index', [
					'estConnecte' => $this->serviceConnexionSimple->recupPersonne() != null,
					'logements' => $logements,
					'titre' => 'Résultats de recherche',
					'villes' => $villes2
				]);
			}
		}
		
		public function equipements($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('equipements');
			$this->chargerModele('logements');
			$idLogement = (sizeof($params) == 1) ? $params[0] : 0;
			$logement = $this->logements->recupParId($idLogement);
			if ($logement == null)
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
			else if ($logement->id_etudiants != $this->session->recup('id_etudiants'))
				$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
			else
			{
				$equipements = $this->equipements->recupParLogement($idLogement);
				$this->chargerVue('equipements', ['equipements' => $equipements, 'idLogement' => $idLogement, 'titre' => 'Gérer les équipements']);
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
			$villes2 = ['0' => '---'];
			foreach ($villes as $v)
				$villes2[$v->id_villes] = $v->nom_villes;
			$this->chargerVue('', [
				'estConnecte' => $this->serviceConnexionSimple->recupPersonne() != null,
				'logements' => $logements,
				'titre' => 'Liste des logements',
				'villes' => $villes2
			]);
		}
		
		public function miens()
		{
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('villes');
			$this->chargerValidateur('logements');
			$this->validateurLogements->chercher();
			$villes = $this->villes->recupToutes();
			$villes2 = ['0' => '---'];
			foreach ($villes as $v)
				$villes2[$v->id_villes] = $v->nom_villes;
			$logements = $this->logements->recupParEtudiant($this->session->recup('id_etudiants'));
			$this->chargerVue('index', [
				'estConnecte' => $this->serviceConnexion->recupPersonne() != null,
				'logements' => $logements, 'titre' => 'Mes logements',
				'titre' => 'Mes logements'
			]);
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
				$this->chargerVue('', ['titre' => 'Nouveau logement', 'scripts' => ['logements']]);
		}
		
		public function photos($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$logement = $this->logements->recupParId($params[0]);
			if ($logement == null)
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
			else
			{
				if ($logement->id_etudiants != $this->session->recup('id_etudiants'))
					$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
				else
				{
					$photos = $this->photos->recupParLogement($logement->id_logements);
					$this->chargerVue('', ['idLogement' => $logement->id_logements, 'photos' => $photos, 'titre' => 'Gérer les photos']);
				}
			}
		}
		
		public function supprimer($params){
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$id = (sizeof($params) == 1) ? $params[0] : 0;
			$logement = $this->logements->recupParId($id);
			if ($logement == null)
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
			else
			{
				$droit = $this->logements->droitSurLogement($id, $this->session->recup('id_etudiants'));
				if (!$droit)
					$this->chargerVue('interdit', ['titre' => 'Opération interdite']);
				else
				{
					$this->logements->supprimer($logement->id_logements);
					$this->rediriger('logements');
				}
			}
		}

		public function voir($params)
		{
			$this->chargerModele('avis');
			$this->chargerModele('equipements');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$id = (sizeof($params) == 1) ? $params[0] : 0;
			$logement = $this->logements->recupParId($id);
			if ($logement)
			{
				$aVote = $this->avis->aVote($this->session->recup('id_etudiants'), $logement->id_logements);
				if (!$aVote)
				{
					$this->chargerValidateur('logements');
					$this->validateurLogements->voter();
				}
				$this->chargerVue('', [
					'aVote' => $aVote,
					'complementAdresse' => $logement->complement_adresse_logements,
					'cp' => $logement->cp_logements,
					'descriptionPhoto' => $logement->description_photos,
					'equipements' => $this->equipements->recupParLogement($id),
					'idEtudiant' => $logement->id_etudiants,
					'idPhoto' => $logement->id_photos,
					'meuble' => $logement->meuble_studios,
					'nbAvis' => $logement->nb_avis,
					'nbChambres' => $logement->nb_chambres_appartements,
					'nbPlaces' => $logement->nb_places_appartements,
					'nomEtudiant' => $logement->nom_etudiants,
					'nomProprietaire' => $logement->nom_proprietaires,
					'noteMoyenne' => $logement->note_moyenne,
					'partiesCommunes' => $logement->parties_communes_chambre,
					'photo' => $logement->id_photos . '.' . $logement->extension_photos,
					'photos' => $this->photos->recupParLogement($logement->id_logements),
					'prenomEtudiant' => $logement->prenom_etudiants,
					'prenomProprietaire' => $logement->prenom_proprietaires,
					'prix' => $logement->prix_logements,
					'rue' => $logement->rue_logements,
					'sexeEtudiant' => $logement->sexe_etudiants,
					'sexeProprietaire' => $logement->sexe_proprietaires,
					'surface' => $logement->surface_logements,
					'titre' => 'Consultation d\'un logement',
					'type' => $logement->type_logements,
					'ville' => $logement->nom_villes,
					'idEtudiants' => $logement->id_etudiants,
					'idLogement' => $logement->id_logements]);
			}
			else
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
		}
		
		public function voter($params)
		{
			$this->chargerService('connexion');
			$this->chargerModele('avis');
			$this->chargerModele('logements');
			$this->chargerValidateur('logements');
			$idLogement = (sizeof($params) == 1) ? $params[0] : 0;
			$logement = $this->logements->recupParId($idLogement);
			if ($logement == null)
			{
				$this->chargerVue('introuvable', ['titre' => 'Logement introuvable']);
				return;
			}
			else if ($logement->id_etudiants == $this->session->recup('id_etudiants') || $this->avis->aVote($idLogement, $this->session->recup('id_etudiants')))
			{
				$this->chargerVue('vote-interdit', ['titre' => 'Vote interdit']);
				return;
			}
			else if ($this->validateurLogements->voter())
			{
				$vote = $this->validateurLogements->recupValeur('vote');
				if (!$vote)
					$vote = 0;
				$this->avis->voter($idLogement, $this->session->recup('id_etudiants'), $vote);
			}
			$this->rediriger('logements', 'voir', [$idLogement]);
		}

		public function modifier($params){
			$this->chargerService('connexion');
			$this->chargerModele('logements');
			$this->chargerModele('photos');
			$this->chargerModele('proprietaires');
			$this->chargerModele('villes');
			$this->chargerModele('motifs');
			$this->chargerValidateur('logements');
			$id = (sizeof($params) == 1) ? $params[0] : 0;			
			if (!$this->logements->droitSurLogement($id, $this->session->recup('id_etudiants')))
				$this->chargerVue('interdit', ['titre' => 'Opréation interdite']);
      else {      
  			$logement = $this->logements->recupParId($id);
  			if($this->validateurLogements->modifier()){
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
  				if ($fichier){
  					$extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
  					$idPhoto = $this->photos->ajouter($extension, $this->validateurLogements->recupValeur('description_photos'));
  					move_uploaded_file($fichier['tmp_name'], 'images/photos/' . $idPhoto . '.' . $extension);
  				}
  				else
  				{
  					$idPhoto = $logement->id_photos;
  				}
  				$this->logements->modifier($id, $idProprietaire, $idPhoto, $this->validateurLogements->recupValeur('rue_logements'), $this->validateurLogements->recupValeur('complement_adresse_logements'), $idVille, $this->validateurLogements->recupValeur('cp_logements'), $this->validateurLogements->recupValeur('prix_logements'), $this->validateurLogements->recupValeur('surface_logements'));
  				if (!$fichier) $this->logements->ajouterIllustration($id, $idPhoto);
  				$idMotif = 0;
  				$motif = $this->motifs->recup($this->validateurLogements->recupValeur('libelle_motifs'));
  				if (!$motif)
  					$idMotif = $this->motifs->ajouter($this->validateurLogements->recupValeur('libelle_motifs'));
  				else 
  					$idMotif = $motif->id_motifs;
  				$this->logements->modifierProposition($id, $this->logements->recupParId($id)->date, $this->serviceConnexion->recupPersonne()->id_etudiants, $idMotif);
  				$this->logements->supprimerSousTypes($id);			
  				switch ($this->validateurLogements->recupValeur('type_logements'))
  				{
  				  case 1:
  					$this->logements->ajouterAppartement($id, $this->validateurLogements->recupValeur('nb_places_appartements'), $this->validateurLogements->recupValeur('nb_chambres_appartements'));
  					break;
  				  case 2:
  					$this->logements->ajouterChambreHabitant($id, $this->validateurLogements->recupValeur('parties_communes_chambres'));
  					break;
  				  case 3:
  					$this->logements->ajouterStudio($id, $this->validateurLogements->recupValeur('meuble_studios'));
  					break;
  				}
  				$this->rediriger('logements', 'voir', [$id]);
			}
			else{
				$this->validateurLogements->definirValeur('nom_proprietaire', $logement->nom_proprietaires);
				$this->validateurLogements->definirValeur('prenom_proprietaire', $logement->prenom_proprietaires);
				$this->validateurLogements->definirValeur('sexe_proprietaire', $logement->sexe_proprietaires);
				$this->validateurLogements->definirValeur('rue_logements', $logement->rue_logements);
				$this->validateurLogements->definirValeur('complement_adresse_logements', $logement->complement_adresse_logements);
				$this->validateurLogements->definirValeur('ville_logements', $logement->nom_villes);
				$this->validateurLogements->definirValeur('cp_logements', $logement->cp_logements);
				$this->validateurLogements->definirValeur('prix_logements', $logement->prix_logements);
				$this->validateurLogements->definirValeur('surface_logements', $logement->surface_logements);
				$this->validateurLogements->definirValeur('description_photos', $logement->description_photos);
				$this->validateurLogements->definirValeur('type_logements', $logement->type_logements);
				$this->validateurLogements->definirValeur('nb_chambres_appartements', $logement->nb_chambres_appartements);
				$this->validateurLogements->definirValeur('nb_places_appartements', $logement->nb_places_appartements);
				$this->validateurLogements->definirValeur('parties_communes_chambres', $logement->parties_communes_chambre);
				$this->validateurLogements->definirValeur('meuble_studios', $logement->meuble_studios);
				$this->validateurLogements->definirValeur('libelle_motifs', $logement->libelle_motifs);
				$this->chargerVue('modifier', ['titre' => 'Modification du logement', 'idLogement' => $id, 'scripts' => ['logements']]);		
			}
     }			
		}
	}
}