<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        echo view('header');             
        echo view('register');
        echo view('footer');    
    }

    public function createAccount()
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Valider les données
        if ($this->validate([
            'username' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            $userModel = new UserModel();

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $userModel->save([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            // Rediriger vers la page de connexion ou d'accueil
            return redirect()->to('/login')->with('success', 'Compte créé avec succès. Vous pouvez vous connecter.');
        } else {
            // Afficher des erreurs
            echo view('header');
            echo view('register', ['validation' => $this->validator]);
            echo view('footer');
        }
    }
}
