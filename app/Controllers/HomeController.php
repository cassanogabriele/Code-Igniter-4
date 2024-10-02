<?php namespace App\Controllers;

class HomeController extends BaseController
{
    public function index() {
        $data = [
            'titre_page' => "Accueil",
            'sous_titre_page' => "Je vous présente mes recettes favorites...",
        ];

        echo view('header', $data);  // Passe les données à la vue 'header'
        echo view('accueil');
        echo view('footer');
    }
}
