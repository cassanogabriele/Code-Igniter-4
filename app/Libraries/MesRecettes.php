<?php namespace App\Libraries;

use App\Models\RecetteModel;
use App\Models\IngredientModel;

class MesRecettes
{
    public $recetteModel;
    public $ingredientModel;

    public function __construct()
    {
        $this->recetteModel = new RecetteModel();
        $this->ingredientModel = new IngredientModel();
    }

    /**
     * Obtenir la liste de recettes
     * @param array $rech
     * @return array
     */
    public function getListeRecettes (array $rech)
    {
        // Obtenir seulement les champs id, slug et titre
        $this->recetteModel->select('id, slug, titre');

        // Si on recherche par texte, chercher dans le titre et les instructions
        if ( ! empty($rech['texte']))
        {
            $this->recetteModel
                ->like('titre', $rech['texte'])
                ->orLike('instructions', $rech['texte']);
        }

        // Si on ne demande pas un nombre de page spécifique, prendre la valeur par défaut
        $nb_par_page = ! empty($rech['nb_par_page']) ? $rech['nb_par_page'] : null;

        // Ajouter le tri et la pagination, puis retourner les résultats
        $recettes = $this->recetteModel
            ->orderBy('id')
            ->paginate($nb_par_page);

        return $recettes;
    }

    /**
     * Obtenir une recette par son id
     * @param int $id
     * @return object|NULL
     */
    public function getRecetteParId (int $id)
    {
        // Obtenir la recette par son id
        $recette = $this->recetteModel->find($id);

        if ($recette !== null)
        {
            $recette->ingredients = $this->ingredientModel
                ->where( ['id_recette' => $recette->id] )
                ->orderBy('id')
                ->findAll();
        }

        return $recette;
    }

    /**
     * Obtenir une recette par son 'slug'
     * @param string $slug
     * @return object|NULL
     */
    public function getRecetteParSlug (string $slug)
    {
        // Obtenir la recette par son slug
        $recette = $this->recetteModel->where('slug', $slug)->first();

        if ($recette !== null)
        {
            $recette->ingredients = $this->ingredientModel
                ->where( ['id_recette' => $recette->id] )
                ->orderBy('id')
                ->findAll();
        }

        return $recette;
    }
	
	public function sauvegarderRecette(int $id = null, array $form_data_recette, array $form_data_ingredients)
	{
		// Générer un slug à partir du titre
		$form_data_recette['slug'] = url_title($form_data_recette['titre'], '-', true);

		// Gérer l'insertion ou la mise à jour de la recette
		if ($id) {
			// Mise à jour de la recette existante
			if (!$this->recetteModel->update($id, $form_data_recette)) {
				log_message('error', 'Erreur de mise à jour de la recette : ' . print_r($this->recetteModel->errors(), true));
				return false; // Retourne faux en cas d'erreur
			}

			// Supprimer les ingrédients existants
			$this->ingredientModel->where('id_recette', $id)->delete();
		} else {
			// Insertion d'une nouvelle recette
			$id = $this->recetteModel->insert($form_data_recette);
			if (!$id) {
				log_message('error', 'Erreur d\'insertion de la recette : ' . print_r($this->recetteModel->errors(), true));
				return false; // Retourne faux en cas d'erreur
			}
		}

		// Sauvegarder les ingrédients
		foreach ($form_data_ingredients as $ingredient) {
			if (!$this->ingredientModel->insert([
				'id_recette' => $id,
				'quantite' => $ingredient['quantite'],
				'nom' => $ingredient['nom'],
			])) {
				log_message('error', 'Erreur d\'insertion de l\'ingrédient : ' . print_r($this->ingredientModel->errors(), true));
				return false; // Retourne faux en cas d'erreur
			}
		}

		return true; 
	}	
	
	public function supprimerRecette(int $id)
	{
		// Récupérer la recette
		$recette = $this->recetteModel->find($id);

		if (!$recette) {
			log_message('error', "Recette ID $id introuvable.");
			return false; // Retourne faux si la recette n'existe pas
		}

		// Supprimer les ingrédients associés
		if (!$this->ingredientModel->where('id_recette', $id)->delete()) {
			log_message('error', "Erreur lors de la suppression des ingrédients de la recette ID $id.");
			return false;
		}

		// Supprimer l'image associée
		if (!empty($recette->img)) { // Utiliser la syntaxe objet pour accéder à la propriété img
			$imagePath = 'public/images/' . $recette->img;
			if (file_exists($imagePath)) {
				if (!unlink($imagePath)) {
					log_message('error', "Erreur lors de la suppression de l'image : $imagePath");
					return false;
				}
			}
		}

		// Supprimer la recette elle-même
		if (!$this->recetteModel->delete($id)) {
			log_message('error', "Erreur lors de la suppression de la recette ID $id.");
			return false;
		}

		return true; // Retourne vrai en cas de succès
	}

}