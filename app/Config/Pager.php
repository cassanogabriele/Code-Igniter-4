<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    // Alias des templates pour la pagination
    public $templates = [
        // Templates par défaut fournit avec CodeIgniter
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        // Template personnalisé pour utiliser Bootstrap
        'bootstrap'      => 'App\Views\pagination_bootstrap',
    ];

    // Valeur par défaut pour le nombre d'items par page
    public $perPage = 25;
}