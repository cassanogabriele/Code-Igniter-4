<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecettesSeeder extends Seeder
{
    public function run()
    {
        // Obtenir une instance du Query Builder pour la table RECETTE
        $qb_recette = $this->db->table('recette');

        // Obtenir une instance du Query Builder pour la table INGREDIENT
        $qb_ingredient = $this->db->table('ingredient');

        // Nombre de recettes bidons à créer
        $nb_recette = 500;

        // Boucler 500 fois
        for ($no_recette = 1; $no_recette <= $nb_recette; $no_recette++)
        {
            // Définir une recette bidon
            $recette = [
                'titre'  => "Recette bidon numéro {$no_recette}",
                'slug' => "recette-bidon-no-{$no_recette}",
                'instructions' => <<<EOT
Ajouter tous les ingrédients dans un plat.
Faire cuire au four à 350 °F (180 °C) pendant 45 minutes.
EOT
            ];

            // Insérer cette recette
            $qb_recette->insert($recette);

            // Obtenir l'ID de la recette créée
            $id_recette = $this->db->insertID();
            log_message('debug', "ID inséré: $id_recette");

            // Définir 3 ingrédients bidons associés à cette recette
            $ingredients = [
                [
                    'nom' => "Ingrédient A",
                    'quantite'  => "200 g",
                    'id_recette'  => $id_recette
                ],
                [
                    'nom' => "Ingrédient B",
                    'quantite'  => "50 g",
                    'id_recette'  => $id_recette
                ],
                [
                    'nom' => "Ingrédient C",
                    'quantite'  => "25 g",
                    'id_recette'  => $id_recette
                ]
            ];

            // Insérer ces 3 ingrédients
            $qb_ingredient->insertBatch($ingredients);
        }
    }
}