<?php
/**
 * @var string $titre_page                       Le titre de la page (créée automatiquement par CI via le tableau $data)
 * @var string $sous_titre_page                  Le sous-titre de la page (créée automatiquement par CI via le tableau $data)
 * @var array $rech                              Critères de recherche
 * @var array $recettes                          Liste des recettes (créée automatiquement par CI via le tableau $data)
 * @var App\Entities\Recette $recette            Une recette (créée par l'instruction foreach)
 * @var \CodeIgniter\Pager\PagerRenderer $pager  Instance de la classe de pagination
 */
?>

<main role="main" class="container">
	<div class="titre">
		<h1>
			<?= esc($titre_page) ?>			
		</h1>
	</div>
	
	 <h1>Bienvenue sur Mon Site de Recettes</h1>
     <p>Une démonstration de mes compétences en CodeIgniter 4 avec une collection de mes recettes préférées.</p>
	
	<section class="container my-5">
		<h2>Découvrez mes recettes préférées</h2>
		<p>Explorez une variété de recettes soigneusement sélectionnées pour vous offrir des plats délicieux et inspirants. Chaque recette a été testée et approuvée pour garantir une expérience culinaire exceptionnelle.</p>
	</section>
</main>

			

		
