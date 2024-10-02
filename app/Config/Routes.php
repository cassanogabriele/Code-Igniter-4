<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// Définir le contrôleur par défaut
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// Désactiver l'AutoRoute
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
 
/**
 * slug placeholder:
 *
 *  [a-z0-9]+     # Une ou plusieurs répétitions de ces caractères
 *  (?:           # Un groupe sans capture
 *    -           # Un tiret
 *    [a-z0-9]+   # Une ou plusieurs répétitions de ces caractères
 *  )*            # Aucune ou plusieurs répétitions du précédent groupe
 *
 *  Ceci va faire un match avec :
 *  - Une séquence de caractères alphanumériques au début de la chaîne de caractères.
 *  - Ensuite ça va trouver un tiret, puis une séquence de caractères alphanumériques,
 *    aucune ou plusieurs fois.
 *
 * Exemples :
 *   item12345
 *   un-article-de-blog
 *
 */
$routes->addPlaceholder('slug', '[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*');
$routes->get('/', 'HomeController::index');  // Utiliser HomeController pour la page d'accueil
$routes->get('/liste_recettes', 'RecettesController::index');
$routes->addPlaceholder('slug', '[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*');
$routes->match(['get', 'post'], '/', 'RecettesController::index');
$routes->get('recette/(:num)', 'RecettesController::recetteParId/$1');
$routes->get('recette/(:slug)', 'RecettesController::recetteParSlug/$1');
$routes->get('/creer', 'RecettesController::creer');
$routes->get('/modifier/(:num)', 'RecettesController::modifier/$1');
$routes->get('/supprimer/(:num)', 'RecettesController::supprimer/$1');
$routes->post('/sauvegarder', 'RecettesController::sauvegarder');
$routes->post('/sauvegarder/(:num)', 'RecettesController::sauvegarder/$1');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');  
$routes->post('/register', 'AuthController::createAccount'); 


// Vous pouvez ajouter ici d'autres routes spécifiques si nécessaire

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
