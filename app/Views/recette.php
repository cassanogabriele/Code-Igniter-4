<?php
/**
 * @var string $titre_page                   Le titre de la page (créée automatiquement par CI via le tableau $data)
 * @var string $sous_titre_page              Le sous-titre de la page (créée automatiquement par CI via le tableau $data)
 * @var array  $recettes                     Liste des recettes (créée automatiquement par CI via le tableau $data)
 * @var App\Entities\Recette $recette        Une recette (créée par l'instruction foreach)
 * @var App\Entities\Ingredient $ingredient  Un ingrédient (créée par l'instruction foreach)
 */
?>

<main role="main" class="container">
    <div class="titre">
        <h1>
            <?= esc($recette->titre) ?>
        </h1>
        <?php if (!empty($recette->img)): ?>
            <img src="<?= base_url('public/images/' . esc($recette->img)) ?>" alt="<?= esc($recette->titre) ?>" class="mt-3 img-fluid thumbnail rounded mx-auto d-block">           
        <?php endif; ?>
    </div>

    <div class="container">
        <article>
            <h5>Ingrédients</h5>
            <ul>
            <?php foreach ($recette->ingredients as $ingredient): ?>
                <li><?= esc($ingredient->quantite) ?> <?= esc($ingredient->nom) ?></li>
            <?php endforeach; ?>
            </ul>
            <h5>Préparation</h5>
            <p><?= nl2br(esc($recette->instructions)) ?></p>
        </article>

        <div class="mb-3">
            <?= anchor("/modifier/{$recette->id}", 'Modifier', ['class' => 'btn btn-outline-primary']) ?>

            <?= anchor("/supprimer/{$recette->id}", 'Supprimer', [
                'class' => 'btn btn-outline-danger',
                'onClick' => "return confirm('Voulez-vous vraiment supprimer cette recette ?');"
            ]) ?>
        </div>
    </div>
</main>


