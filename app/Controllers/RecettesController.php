<?php namespace App\Controllers;

use App\Libraries\MesRecettes;

class RecettesController extends BaseController
{
    /**
     * Liste des recettes
     * @return string
     */
    public function index()
    {
        // Si un formulaire de recherche a été soumis
        if ($this->request->getMethod() === 'post')
        {
            // Obtenir les critères de recherche du formulaire
            $rech = [
                'texte' => $this->request->getPost('rech_texte'),
                'nb_par_page' => $this->request->getPost('rech_nb_par_page'),
            ];
        }
        // Sinon, si des critères de recherche ont été sauvegardés dans la session
        else if (session('rech_recette') !== null)
        {
            // Obtenir les critères de recherche de la session
            $rech = session('rech_recette');
        }
        else
        {
            // Critères de recherche par défaut
            $rech = [
                'texte' => null,
                'nb_par_page' => null,
            ];
        }

        if ($rech['nb_par_page'] !== null)
        {
            // Convertir la valeur en 'int' (nombre entier)
            $rech['nb_par_page'] = (int)$rech['nb_par_page'];

            // Si négatif ou 0, mettre null pour prendre la valeur définit dans
            // la configuration du "Pager"
            if ($rech['nb_par_page'] <= 0)
            {
                $rech['nb_par_page'] = null;
            }

            // Maximum de 100 recettes par page
            if ($rech['nb_par_page'] > 100)
            {
                $rech['nb_par_page'] = 100;
            }
        } else {
			// Valeur par défaut de 10 recettes par page si aucun nombre spécifié
			$rech['nb_par_page'] = 10;
		}

        // Sauver les critères de recherche dans la session
        session()->set('rech_recette', $rech);

        // Créer une instance de notre librairie
        $mesRecettes = new MesRecettes();

        // Rassembler toutes les données utilisées par la vue dans un tableau $data
        $data = [
            'titre_page' => "Mes recettes",
            'sous_titre_page' => "Je vous présente mes recettes favorites...",
            'recettes' => $mesRecettes->getListeRecettes($rech),
            // Passer les critères de recherche à la vue
            'rech' => $rech,
            // Passer l'instance de la classe de pagination à la vue
            'pager' => $mesRecettes->recetteModel->pager,
        ];

        // Charger les fonctions utilitaires pour les formulaires
        helper('form');

        /* Chacun des items du tableau $data sera accessible dans la vue
         * par des variables portant le même nom que la clé :
         * $titre_page, $sous_titre_page, $recettes, $rech et $pager
         */
		echo view('header');			 
        echo view('liste_recettes', $data);
		echo view('footer');	
    }

    /**
     * Une seule recette
     * @param int $id
     * @return string
     */
    public function recetteParId (int $id)
    {
        // Créer une instance de notre librairie
        $mesRecettes = new MesRecettes();

        $data = [];

        /* Obtenir la recette pour l'id reçu en paramètre.
         * Si la recette n'existe pas, on emet une exception de page non trouvée (erreur 404)
         */
        if ( ! $data['recette'] = $mesRecettes->getRecetteParId($id))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
		echo view('header');			 
        echo view('recette', $data);
		echo view('footer');
    }

    /**
     * Une seule recette
     * @param string $slug
     * @return string
     */
    public function recetteParSlug (string $slug)
    {
        // Créer une instance de notre librairie
        $mesRecettes = new MesRecettes();

        $data = [];

        /* Obtenir la recette pour l'id reçu en paramètre.
         * Si la recette n'existe pas, on emet une exception de page non trouvée (erreur 404)
         */
        if ( ! $data['recette'] = $mesRecettes->getRecetteParSlug($slug))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
		
		echo view('header');			 
        echo view('recette', $data);
		echo view('footer');
    }
	
	public function creer()
	{
		// Vérifier si l'utilisateur est connecté
		if (!session()->get('is_logged_in')) {
			return redirect()->to('/login');
		}

		// Charger les fonctions utilitaires pour les formulaires
		helper('form');

		// Charger la configuration de notre application
		$config = config('Recette');

		$data = [
			'titre_page' => "Nouvelle recette",
			'max_ingredient' => $config->nb_ingredient,
		];

		echo view('header');			 
		echo view('form_recette', $data);
		echo view('footer');	
	}


	public function modifier (int $id)
	{
		// Créer une instance de notre librairie
		$mesRecettes = new MesRecettes();

		// Charger les fonctions utilitaires pour les formulaires
		helper('form');

		// Charger la configuration de notre application
		$config = config('Recette');

		$data = [
			'titre_page' => "Modifier une recette",
			'max_ingredient' => $config->nb_ingredient,
		];

		/* Obtenir la recette pour l'id reçu en paramètre.
		 * Si la recette n'existe pas, on emet une exception de page non trouvée (erreur 404)
		 */
		if ( ! $data['recette'] = $mesRecettes->getRecetteParId($id))
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		echo view('header');			 
        echo view('form_recette', $data);
		echo view('footer');
	}

	public function sauvegarder(int $id = null)
	{
		log_message('debug', ($id === null) ? "Sauvegarder nouvelle recette" : "Sauvegarder recette id $id");

		// Charger la configuration de notre application
		$config = config('Recette');

		// Définir les règles de validation du formulaire
		$regles = [
			'titre' => [
				'label' => "Titre",
				'rules' => "required|max_length[100]|is_unique[recette.titre,id,{$id}]"
			],
			'instructions' => [
				'label' => "Instructions",
				'rules' => "required|string"
			],
			'image' => [
				'label' => "Image",
				'rules' => "uploaded[image]|is_image[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif]"
			]
		];

		for ($i = 0; $i < $config->nb_ingredient; $i++) {
			$no_ingredient = $i + 1;

			$regles["quantite_ingredient_{$i}"] = [
				'label' => "Quantité de l'ingrédient {$no_ingredient}",
				'rules' => "permit_empty|string|max_length[10]|required_with[nom_ingredient_{$i}]"
			];

			$regles["nom_ingredient_{$i}"] = [
				'label' => "Nom de l'ingrédient {$no_ingredient}",
				'rules' => "permit_empty|string|max_length[50]|required_with[quantite_ingredient_{$i}]"
			];
		}

		// Valider les données du formulaire
		if (!$this->validate($regles)) {
			return redirect()->back()->withInput()->with('erreurs', $this->validator->getErrors());
		}

		// Créer une instance de notre librairie
		$mesRecettes = new MesRecettes();

		// Obtenir les données du formulaire
		$form_data_recette = [
			'titre' => $this->request->getPost('titre'),
			'instructions' => $this->request->getPost('instructions'),
		];

		// Traitement de l'image
		$imageFile = $this->request->getFile('image');
		if ($imageFile->isValid() && !$imageFile->hasMoved()) {
			$imageName = $imageFile->getRandomName();
			// Déplacez le fichier vers le dossier public/images
			$imageFile->move('public/images', $imageName);
			$form_data_recette['img'] = $imageName; // Enregistrer le nom de l'image
		}

		// Extraire et valider les ingrédients de cette recette
		$form_data_ingredients = [];
		for ($i = 0; $i < $config->nb_ingredient; $i++) {
			if (!empty($this->request->getPost("quantite_ingredient_{$i}")) &&
				!empty($this->request->getPost("nom_ingredient_{$i}"))) {
				$form_data_ingredients[] = [
					'quantite' => $this->request->getPost("quantite_ingredient_{$i}"),
					'nom' => $this->request->getPost("nom_ingredient_{$i}"),
				];
			}
		}

		// Obtenir les données du formulaire et les sauvegarder
		if ($mesRecettes->sauvegarderRecette($id, $form_data_recette, $form_data_ingredients)) {
			return redirect()->to('/liste_recettes')->with('message', "Recette sauvegardée avec succès");
		} else {
			return redirect()->back()->withInput()->with('erreurs', $mesRecettes->getErreurs());
		}
	}
	
	public function supprimer(int $id)
	{
		$mesRecettes = new MesRecettes();

		if ($mesRecettes->supprimerRecette($id)) {
			return redirect()->to('/liste_recettes')->with('message', "Recette supprimée avec succès");
		} else {
			return redirect()->back()->with('erreurs', 'Erreur lors de la suppression de la recette.');
		}
	}
}