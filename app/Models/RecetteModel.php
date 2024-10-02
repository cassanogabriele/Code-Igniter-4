<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Recette;

class RecetteModel extends Model
{
    // Le nom de la table MySQL
    protected $table = 'recette';

    // Le type d'objet à retourner
    protected $returnType = Recette::class;

    // Les champs modifiables
    protected $allowedFields = [
        'titre',
        'instructions',
        'slug',
        'img', 
    ];

    // Active les timestamps si nécessaire
    protected $useTimestamps = false; // Changez à true si vous avez des colonnes created_at et updated_at
}
