/**
 * Récupère le nom de la spécialité à partir de son ID
 * @param string|null $specialiteId
 * @return string
 */
function getSpecialiteName($specialiteId)
{
    if (empty($specialiteId)) {
        return 'Non spécifié';
    }

    // Si l'ID est numérique, on le traite comme un ID de spécialité
    if (is_numeric($specialiteId)) {
        $specialite = \App\Models\Specialite::find($specialiteId);
        return $specialite ? $specialite->nom : 'Spécialité inconnue';
    }

    // Sinon, on retourne directement la valeur (cas où c'est déjà le nom)
    return $specialiteId;
} 