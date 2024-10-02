<?php namespace App\Entities;

use CodeIgniter\Entity;

class Recette extends Entity
{
    public $ingredients;

    public function __construct (array $data = null)
    {
        parent::__construct($data);

        // Initialiser la liste d'ingrédients avec un tableau vide.
        $this->ingredients = [];
    }
	
	// Cette fonction est automatiquement appellée quand on définie la valeur de $recette->titre
	public function setTitre (string $titre)
	{
		$this->attributes['titre'] = $titre;

		// Définir automatiquement le "slug" à partir du titre de la recette.
		$this->attributes['slug'] = mb_url_title($titre, '-', TRUE);
	}
}