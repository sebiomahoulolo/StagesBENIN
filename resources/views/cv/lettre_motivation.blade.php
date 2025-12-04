@php
    // Récupération des infos du profil
    $nom = $cvProfile->username ?? '';
    $poste = $cvProfile->title ?? '';
    $ville = $cvProfile->city ?? '';
    $email = $cvProfile->email ?? '';
    $telephone = $cvProfile->phone ?? '';
    $nationalite = $cvProfile->nationality ?? '';
    $resume = $cvProfile->resume ?? '';

    // Diplôme le plus récent
    $diplome = '';
    if (!empty($cvProfile->formations) && count($cvProfile->formations)) {
        $lastFormation = $cvProfile->formations->sortByDesc('annee_fin')->first();
        $diplome = $lastFormation ? $lastFormation->diplome . ' à ' . $lastFormation->etablissement : '';
    }

    // Expérience la plus récente
    $experience = '';
    if (!empty($cvProfile->experiences) && count($cvProfile->experiences)) {
        $lastExp = $cvProfile->experiences->sortByDesc('date_fin')->first();
        $experience = $lastExp ? $lastExp->poste . ' chez ' . $lastExp->entreprise : '';
    }

    // Générer le texte de la lettre
    $lettreGeneree =
        ($ville ? $ville . ',' : '') . ' le ' . date('d/m/Y') . "\n"
        . "Nom et prénom : $nom\n"
        . "Email : $email\n"
        . "Téléphone : $telephone\n"
        . "Nationalité : $nationalite\n\n"
        . "Objet : Candidature au poste de " . ($poste ?: '...') . "\n\n"
        . "Madame, Monsieur,\n\n"
        . ($resume ? $resume . "\n\n" : '')
        . "Titulaire d'un diplôme en " . ($diplome ?: '...') . ", j'ai récemment exercé en tant que " . ($experience ?: '...') . ", ce qui m'a permis de consolider mes compétences professionnelles et d'approfondir mes connaissances en lien direct avec le poste de " . ($poste ?: '...') . ".\n\n"
        . "Tout au long de mon parcours, j'ai su faire preuve d'adaptabilité, d'autonomie et d'un fort esprit d'équipe. Mes expériences m'ont permis de développer une rigueur professionnelle, un sens aigu de l'organisation ainsi qu'une excellente aisance relationnelle.\n\n"
        . "Fort(e) de ces atouts, je suis convaincu(e) de pouvoir contribuer activement au développement de votre entreprise. Intégrer votre structure serait pour moi une opportunité enrichissante, tant sur le plan professionnel que personnel.\n\n"
        . "Je me tiens à votre disposition pour un entretien, au cours duquel je pourrai vous présenter plus en détail mon profil et mes motivations.\n\n"
        . "Dans l'attente de votre retour, je vous prie d'agréer, Madame, Monsieur, l'expression de mes salutations distinguées.\n\n"
        . "$nom";
@endphp

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row d-flex align-items-stretch justify-content-center g-4 flex-column flex-md-row">
        <!-- Affichage lettre (prévisualisation live) -->
        <div class="col-12 col-md-6 h-100 d-flex align-items-stretch">
            <div class="w-100 h-100" style="background:#fff;border-radius:12px;box-shadow:0 2px 12px #e3e3e3;padding:2rem;">
                <h2 class="mb-4 text-center" style="font-weight:700;">Lettre de motivation</h2>
                <div id="lettre-preview">
                    @foreach(explode("\n", $lettreGeneree) as $ligne)
                        <p style="margin-bottom:0.7em;">{!! nl2br(e($ligne)) !!}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Formulaire édition + téléchargement -->
        <div class="col-12 col-md-6 h-100 d-flex align-items-stretch">
            <div class="w-100 h-100 mt-4 mt-md-0" style="max-width: 1000px; height: 1000px;">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Modifier et télécharger</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <form method="POST" action="{{ route('cv.lettre_motivation.download') }}" class="flex-grow-1 d-flex flex-column">
                            @csrf
                            <div class="mb-3 flex-grow-1 d-flex flex-column">
                                <label for="lettre" class="form-label">Lettre de motivation</label>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-outline-dark me-1" onclick="insertTag('lettre', '<b>', '</b>')"><b>B</b></button>
                                    <button type="button" class="btn btn-sm btn-outline-dark me-1" onclick="insertTag('lettre', '<i>', '</i>')"><i>I</i></button>
                                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="insertTag('lettre', '<u>', '</u>')"><u>U</u></button>
                                </div>
                                <textarea name="lettre" id="lettre" rows="16" class="form-control flex-grow-1" required oninput="updatePreview()">{{ old('lettre', $lettreGeneree) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-2 mt-auto">
                                Télécharger en PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function insertTag(textareaId, openTag, closeTag) {
    var textarea = document.getElementById(textareaId);
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var selectedText = textarea.value.substring(start, end);
    var before = textarea.value.substring(0, start);
    var after = textarea.value.substring(end);
    textarea.value = before + openTag + selectedText + closeTag + after;
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + openTag.length + selectedText.length + closeTag.length;
    updatePreview();
}
function updatePreview() {
    var val = document.getElementById('lettre').value;
    // Séparer en paragraphes
    var html = val.split(/\n/).map(function(ligne) {
        return '<p>' + ligne.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/&lt;(b|i|u)&gt;|&lt;\/(b|i|u)&gt;/g, function(tag) {
            return tag.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        }) + '</p>';
    }).join('');
    // Autoriser les balises b, i, u uniquement
    html = html.replace(/&lt;(b|i|u)&gt;/g, '<$1>').replace(/&lt;\/(b|i|u)&gt;/g, '</$1>');
    document.getElementById('lettre-preview').innerHTML = html;
}
// Initialiser la prévisualisation si le textarea existe
if(document.getElementById('lettre')) updatePreview();
</script>
@endsection 