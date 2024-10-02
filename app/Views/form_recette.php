<?php
/**
 * @var string $titre_page                   Le titre de la page (créée automatiquement par CI via le tableau $data)
 * @var int $max_ingredient                  Nombre maximum d'ingrédients pour une recette
 * @var App\Entities\Recette $recette        La recette
 */
?>
<main role="main" class="container">
    <div class="titre">
        <h1>
            <?= (isset($recette) ? "Modifier une recette" : "Nouvelle recette") ?>
        </h1>
    </div>

    <?php if (session('erreurs') !== null) : ?>
        <div class="alert alert-danger">
            <?= implode('<br>', session('erreurs')) ?>
        </div>
    <?php endif; ?>

    <?php if (session('message') !== null) : ?>
        <div class="alert alert-success text-center">
            <?= session('message'); ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="mb-3">
            <?= form_open('/sauvegarder' . (isset($recette) ? "/{$recette->id}" : ""), ['enctype' => 'multipart/form-data']) ?>
                
                <?= form_label("Titre", 'form_titre', ['class' => 'form-label']) ?>
                <?= form_input('titre', old('titre', $recette->titre ?? '', false), ['class' => 'form-control mb-3']) ?>

                <?= form_label("Image", 'form_image', ['class' => 'form-label']) ?>
                <?= form_upload('image', '', ['class' => 'form-control mb-3']) ?>

                <?= form_label("Ingrédients", '', ['class' => 'form-label']) ?>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Ingrédient</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < $max_ingredient; $i++): ?>
                            <tr>
                                <th scope="row"><?= ($i + 1) ?></th>
                                <td>
                                    <?= form_input("quantite_ingredient_{$i}", old("quantite_ingredient_{$i}", $recette->ingredients[$i]->quantite ?? '', false), ['class' => 'form-control']) ?>
                                </td>
                                <td>
                                    <?= form_input("nom_ingredient_{$i}", old("nom_ingredient_{$i}", $recette->ingredients[$i]->nom ?? '', false), ['class' => 'form-control']) ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>

                <?= form_label("Préparation", 'form_instruction', ['class' => 'form-label']) ?>
                <?= form_textarea('instructions', old('instructions', $recette->instructions ?? '', false), ['id' => 'form_instruction', 'class' => 'form-control mb-3']) ?>

                <?= form_submit('form_submit', "Sauvegarder", ['class' => 'btn btn-outline-primary my-1']) ?>
            <?= form_close() ?>
        </div>
    </div>
</main>

