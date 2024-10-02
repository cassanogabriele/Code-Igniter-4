<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function register()
    {
        // Charger les fonctions utilitaires pour les formulaires
        helper(['form']);

        // Vérifier si la requête est POST
        if ($this->request->getMethod() == 'post') {
            // Valider les données de formulaire
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[5]',
                'password_confirm' => 'matches[password]',
            ];

            if ($this->validate($rules)) {
                $model = new UserModel();
                $data = [
                    'username' => $this->request->getVar('username'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];
                $model->save($data);
                return redirect()->to('/login');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        echo view('header');
        echo view('register', $data ?? []);
        echo view('footer');
    }

    public function login()
    {
        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            $model = new UserModel();

            $user = $model->where('email', $this->request->getVar('email'))
                          ->first();

            if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
                // Enregistrer les infos utilisateur dans la session
                session()->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'is_logged_in' => true,
                ]);
                return redirect()->to('/creer');
            } else {
                $data['error'] = 'Email ou mot de passe incorrect';
            }
        }

        echo view('header');
        echo view('login', $data ?? []);
        echo view('footer');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
