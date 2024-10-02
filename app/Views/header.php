<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        /* Assure que la page prend toute la hauteur de l'écran */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Flexbox sur le body pour espacer le contenu */
        body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        main {
            flex: 1; /* Prend tout l'espace restant entre header et footer */
        }

        .titre {
            padding: 3rem 1.5rem;
        }

        article {
            padding: 1.5rem 1.5rem;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.05);
            text-align: center;
            padding: 1rem 0;
        }

        a {
            text-decoration: none;
        }
        
        .bg-image {                    
            background-size: cover;
            background-position: center;
        }
        
        .thumbnail {
            width: 400px; 
            height: 400px; 
            object-fit: cover;
        }

        .navbar-nav {
            margin-left: auto; /* Permet de pousser les éléments à droite */
        }
		
		.form-container {
            max-width: 500px;
            margin: auto;
			margin-top: -120px;
			margin-bottom: 150px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }		
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="public/css/lity.css" rel="stylesheet">			
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body">
            <div class="container-fluid">				 
				<a class="navbar-brand" href="<?= site_url('/'); ?>">
					<img src="<?= base_url('public/images/logomfr.png'); ?>" alt="Logo My Favorite recipes" style="width: 250px; height: auto;">
				</a>

			
                <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarRecipes" aria-controls="navbarRecipes" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
				
                <div class="collapse navbar-collapse" id="navbarRecipes">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= site_url('/'); ?>" aria-current="page">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('liste_recettes'); ?>">Recettes</a>
                        </li>
                        <li class="nav-item">
                            <?= anchor('/creer', 'Nouvelle recette', ['class' => 'nav-link']) ?>
                        </li>
						<?php if (!session()->get('is_logged_in')): ?>
							<li class="nav-item">
								<?= anchor('/register', 'Créer un compte', ['class' => 'nav-link']) ?>
							</li>
						<?php endif; ?>
                    </ul>
					
					<?php if (session()->get('is_logged_in')): ?>
						<span style="display: flex; align-items: center;">						
							<i class="fas fa-user-circle" style="color: blue; font-size: 1.5em; margin-right: 5px;"></i>
							<?= esc(session()->get('username')); ?> <!-- Utiliser esc() pour éviter les failles XSS -->
						</span>		

						<a href="<?= base_url('/logout') ?>" class="btn btn-primary ms-3"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
					<?php else: ?>					
						<a href="<?= base_url('/login') ?>" class="btn btn-primary ms-3"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
					<?php endif; ?>
                </div>
            </div>
        </nav>
        
        <div class="alert alert-danger text-center" role="alert">
            ⚠ Ce site est un site de démonstration, contenant des données fictives, et ayant pour unique objectif, de présenter mes compétences en Code Igniter 4. 
        </div>

        <div class="p-5 text-center bg-image" style="background-image: url('<?= base_url('public/images/chicon_gratin.jpg') ?>'); height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex justify-content-center align-items-center h-10">
                    <div>
                        <h1 class="mb-3 text-white">Je vous livre mes plus belles recettes</h1>
                        <h4 class="mb-3 text-white">Bonnes découvertes !</h4>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
