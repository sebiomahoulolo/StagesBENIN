<?php

namespace App\Helpers;

class FormationHelper
{
    public static function getSpecialiteName($id)
    {
        $specialites = [
            1 => 'Administrateur système',
            2 => 'Assistant administratif',
            3 => 'Assistant de direction',
            4 => 'Assistant ressources humaines',
            5 => 'Cadre ressources humaines',
            6 => 'Chargé(e) de projet / Chef de projet',
            7 => 'Conseiller/conseillère en ressources humaines',
            8 => 'Directeur/directrice d\'établissement',
            9 => 'Directeur/directrice des ressources humaines',
            10 => 'Employé administratif',
            11 => 'Manager / Superviseur/superviseuse',
            12 => 'Réceptionniste',
            13 => 'Responsable administratif',
            14 => 'Responsable d\'exploitation',
            15 => 'Responsable des ressources humaines',
            16 => 'Secrétaire administratif',
            17 => 'Agent d\'assurance',
            18 => 'Analyste crédit',
            19 => 'Analyste financier',
            20 => 'Auditeur/auditrice',
            21 => 'Cadre financier',
            22 => 'Comptable',
            23 => 'Conseiller/conseillère financier/financière',
            24 => 'Contrôleur de gestion',
            25 => 'Directeur/directrice financier/financière',
            26 => 'Expert-comptable',
            27 => 'Expert en assurance'
        ];
        return $specialites[$id] ?? 'N/A';
    }
} 