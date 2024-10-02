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
			<small class="text-muted"><?= esc($sous_titre_page) ?></small>
		</h1>
	</div>

	<?php if (session('erreurs')): ?>
		<div class="alert alert-danger">
			<?= implode('<br>', session('erreurs')) ?>
		</div>
	<?php endif; ?>

	<?php if (session('message')): ?>
		<div class="alert alert-success text-center">
			<?= esc(session('message')) ?>
		</div>
	<?php endif; ?>

	<h3>Liste des recettes</h3>
	

	<div class="my-3">
		<?= form_open('/', ['class' => 'form-inline']) ?>	

		<div class="input-group mb-3">
		  <?= form_input('rech_texte', esc($rech['texte'] ?? ''), ['class' => 'form-control my-1 mr-3', 'placeholder' => "Veuillez entrer un nom de recette"]) ?>

		   <button type="submit" name="rech_submit" class="btn btn-primary my-1 mr-3">
			<i class="fas fa-search"></i>
		  </button>
		</div>	
		
		<?= form_close() ?>
	</div>

	<ul class="list-unstyled">
		<?php if (!empty($recettes)): ?>
			<?php foreach ($recettes as $recette): ?>
				<li><?= anchor('recette/' . esc($recette->slug), esc($recette->titre)) ?></li>
			<?php endforeach; ?>
		<?php else: ?>
			<li>Aucune recette trouvée.</li>
		<?php endif; ?>
	</ul>
	
	 <div class="mt-3 text-end"> <!-- Aligné à droite -->
        <?= form_label("Nombre de recette", 'rech_nb_par_page', ['class' => 'my-1 mr-2']) ?>

        <?php $nombre_recettes = count($recettes); ?>
        
        <?= form_input('rech_nb_recette', $nombre_recettes, ['id' => 'rech_nb_recette', 'class' => 'form-control my-1', 'style' => 'width:auto; display:inline-block;']) ?>
    </div>

	<?= $pager->links('default', 'bootstrap') ?>
</main>

