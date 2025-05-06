<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; // Keep just in case, though old hashes are used

class DatabaseTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // --- Truncate Tables (in an order that respects potential FKs if constraints were enabled) ---
        // Truncate CV related tables first
        DB::table('cv_competences')->truncate();
        DB::table('cv_experiences')->truncate();
        DB::table('cv_formations')->truncate();
        DB::table('cv_langues')->truncate();
        DB::table('cv_centre_interets')->truncate();
        DB::table('cv_certifications')->truncate();
        DB::table('cv_projets')->truncate();
        DB::table('cv_references')->truncate();
        DB::table('cv_profiles')->truncate();

        // Truncate messaging related tables
        DB::table('message_attachments')->truncate();
        DB::table('messages')->truncate();
        DB::table('conversation_participants')->truncate();
        DB::table('conversations')->truncate();

        // Truncate other dependent tables
        DB::table('tier')->truncate(); // Depends on users
        DB::table('examens')->truncate(); // Depends on etudiants, users
        DB::table('candidatures')->truncate(); // Depends on annonces, etudiants
        DB::table('annonces')->truncate(); // Depends on entreprises, users, secteurs, specialites
        DB::table('avis')->truncate(); // Depends on catalogues
        DB::table('event_registrations')->truncate(); // Depends on events, etudiants
        DB::table('events')->truncate(); // Depends on users (nullable now)
        DB::table('entretiens')->truncate(); // Depends on etudiants, users, entreprises
        DB::table('messageries')->truncate(); // Depends on entreprises
        DB::table('recrutements')->truncate(); // Depends on entreprises
        DB::table('complaints_suggestions')->truncate(); // Depends on etudiants

        // Truncate base/independent tables last (or before their dependents)
        DB::table('etudiants')->truncate(); // Depends on users, specialites (nullable)
        DB::table('entreprises')->truncate(); // Depends on users
        DB::table('users')->truncate();
        DB::table('catalogues')->truncate();
        DB::table('secteurs')->truncate();
        DB::table('specialites')->truncate();
        DB::table('subscribers')->truncate();
        DB::table('actualites')->truncate(); // No old data
        DB::table('catalogue')->truncate(); // No old data
        DB::table('failed_jobs')->truncate(); // Usually empty
        DB::table('password_resets')->truncate(); // Usually empty
        DB::table('personal_access_tokens')->truncate(); // Usually empty
        DB::table('questions')->truncate(); // No old data
        DB::table('registrations')->truncate(); // No old data
        // Truncate messaging core tables (if not already done)
        DB::table('message_comments')->truncate(); // Depends on posts, users
        DB::table('message_post_attachments')->truncate(); // Depends on posts
        DB::table('message_shares')->truncate(); // Depends on posts, users
        DB::table('message_posts')->truncate(); // Depends on users

        // --- Seed Data ---

        // Seed Secteurs
        DB::table('secteurs')->insert([
            ['id' => 1, 'nom' => 'Administration / Gestion / Ressources Humaines', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 2, 'nom' => 'Finance / Banque / Assurance / Comptabilité', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 3, 'nom' => 'Marketing / Vente / Communication / Commerce', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 4, 'nom' => 'Informatique / Technologie / Digital (IT)', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 5, 'nom' => 'Santé / Social / Soins', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 6, 'nom' => 'Construction / BTP / Artisanat / Architecture', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 7, 'nom' => 'Arts / Culture / Média / Design', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 8, 'nom' => 'Éducation / Formation', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 9, 'nom' => 'Ingénierie / Industrie / Technique / Maintenance', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 10, 'nom' => 'Logistique / Transport', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 11, 'nom' => 'Tourisme / Hôtellerie / Restauration', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 12, 'nom' => 'Agriculture / Agroalimentaire / Environnement / Recherche', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 13, 'nom' => 'Services à la personne / Beauté', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 14, 'nom' => 'Juridique / Droit', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 15, 'nom' => 'Sécurité', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 16, 'nom' => 'Immobilier', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 17, 'nom' => 'Conseil / Services aux entreprises', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 18, 'nom' => 'Artisanat / Commerce Spécialisé', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
        ]);

        // Seed Specialites
        DB::table('specialites')->insert([
             ['id' => 1, 'secteur_id' => 1, 'nom' => 'Administrateur système', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 2, 'secteur_id' => 1, 'nom' => 'Assistant administratif', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
             ['id' => 3, 'secteur_id' => 1, 'nom' => 'Assistant de direction', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 4, 'secteur_id' => 1, 'nom' => 'Assistant ressources humaines', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 5, 'secteur_id' => 1, 'nom' => 'Cadre ressources humaines', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 6, 'secteur_id' => 1, 'nom' => 'Chargé(e) de projet / Chef de projet', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 7, 'secteur_id' => 1, 'nom' => 'Conseiller/conseillère en ressources humaines', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 8, 'secteur_id' => 1, 'nom' => 'Directeur/directrice d\'établissement', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 9, 'secteur_id' => 1, 'nom' => 'Directeur/directrice des ressources humaines', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 10, 'secteur_id' => 1, 'nom' => 'Employé administratif', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 11, 'secteur_id' => 1, 'nom' => 'Manager / Superviseur/superviseuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 12, 'secteur_id' => 1, 'nom' => 'Réceptionniste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 13, 'secteur_id' => 1, 'nom' => 'Responsable administratif', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 14, 'secteur_id' => 1, 'nom' => 'Responsable d\'exploitation', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 15, 'secteur_id' => 1, 'nom' => 'Responsable des ressources humaines', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 16, 'secteur_id' => 1, 'nom' => 'Secrétaire administratif', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 17, 'secteur_id' => 2, 'nom' => 'Agent d\'assurance', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 18, 'secteur_id' => 2, 'nom' => 'Analyste crédit', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 19, 'secteur_id' => 2, 'nom' => 'Analyste financier', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 20, 'secteur_id' => 2, 'nom' => 'Auditeur/auditrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 21, 'secteur_id' => 2, 'nom' => 'Cadre financier', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 22, 'secteur_id' => 2, 'nom' => 'Comptable', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 23, 'secteur_id' => 2, 'nom' => 'Conseiller/conseillère financier/financière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 24, 'secteur_id' => 2, 'nom' => 'Contrôleur de gestion', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 25, 'secteur_id' => 2, 'nom' => 'Directeur/directrice financier/financière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 26, 'secteur_id' => 2, 'nom' => 'Expert-comptable', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 27, 'secteur_id' => 2, 'nom' => 'Expert en assurance', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 28, 'secteur_id' => 3, 'nom' => 'Analyste commercial', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 29, 'secteur_id' => 3, 'nom' => 'Assistant marketing', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 30, 'secteur_id' => 3, 'nom' => 'Cadre marketing', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 31, 'secteur_id' => 3, 'nom' => 'Caissier/caissière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 32, 'secteur_id' => 3, 'nom' => 'Chargé(e) d\'études', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 33, 'secteur_id' => 3, 'nom' => 'Chargé(e) de clientèle', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 34, 'secteur_id' => 3, 'nom' => 'Chargé(e) de communication', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 35, 'secteur_id' => 3, 'nom' => 'Chef de produit', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 36, 'secteur_id' => 3, 'nom' => 'Commercial', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 37, 'secteur_id' => 3, 'nom' => 'Directeur/directrice commercial(e)', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 38, 'secteur_id' => 3, 'nom' => 'Directeur/directrice marketing', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 39, 'secteur_id' => 3, 'nom' => 'Expert en communication', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 40, 'secteur_id' => 3, 'nom' => 'Expert en marketing digital', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 41, 'secteur_id' => 3, 'nom' => 'Expert en relations publiques', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 42, 'secteur_id' => 3, 'nom' => 'Responsable commercial', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 43, 'secteur_id' => 3, 'nom' => 'Responsable marketing', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 44, 'secteur_id' => 3, 'nom' => 'Vendeur/vendeuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 45, 'secteur_id' => 4, 'nom' => 'Analyste de données', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 46, 'secteur_id' => 4, 'nom' => 'Concepteur UX/UI', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 47, 'secteur_id' => 4, 'nom' => 'Développeur web', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 48, 'secteur_id' => 4, 'nom' => 'Ingénieur en informatique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 49, 'secteur_id' => 4, 'nom' => 'Informaticien/informaticienne', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 50, 'secteur_id' => 4, 'nom' => 'Programmeur/programmeuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 51, 'secteur_id' => 4, 'nom' => 'Responsable informatique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 52, 'secteur_id' => 4, 'nom' => 'Spécialiste en cybersécurité', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 53, 'secteur_id' => 4, 'nom' => 'Technicien/technicienne en informatique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 54, 'secteur_id' => 4, 'nom' => 'Webdesigner', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 55, 'secteur_id' => 5, 'nom' => 'Éducateur/éducatrice spécialisé(e)', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 56, 'secteur_id' => 5, 'nom' => 'Infirmier/infirmière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 57, 'secteur_id' => 5, 'nom' => 'Kinésithérapeute', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 58, 'secteur_id' => 5, 'nom' => 'Médecin', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 59, 'secteur_id' => 5, 'nom' => 'Opticien/opticienne', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 60, 'secteur_id' => 5, 'nom' => 'Orthophoniste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 61, 'secteur_id' => 5, 'nom' => 'Pharmacien/pharmacienne', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 62, 'secteur_id' => 5, 'nom' => 'Psychologue', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 63, 'secteur_id' => 5, 'nom' => 'Sage-femme', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 64, 'secteur_id' => 5, 'nom' => 'Secrétaire médical', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 65, 'secteur_id' => 5, 'nom' => 'Technicien/technicienne de laboratoire', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 66, 'secteur_id' => 5, 'nom' => 'Technicien/technicienne en radiologie', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 67, 'secteur_id' => 5, 'nom' => 'Vétérinaire', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 68, 'secteur_id' => 6, 'nom' => 'Architecte', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 69, 'secteur_id' => 6, 'nom' => 'Conducteur/conductrice de travaux', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 70, 'secteur_id' => 6, 'nom' => 'Maçon', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 71, 'secteur_id' => 6, 'nom' => 'Menuisier/menuisière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 72, 'secteur_id' => 6, 'nom' => 'Monteur/monteuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 73, 'secteur_id' => 6, 'nom' => 'Peintre', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 74, 'secteur_id' => 6, 'nom' => 'Plombier/plombière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 75, 'secteur_id' => 6, 'nom' => 'Soudeur/soudeuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 76, 'secteur_id' => 6, 'nom' => 'Ingénieur civil', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 77, 'secteur_id' => 7, 'nom' => 'Acteur/actrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 78, 'secteur_id' => 7, 'nom' => 'Animateur/animatrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 79, 'secteur_id' => 7, 'nom' => 'Bibliothécaire', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 80, 'secteur_id' => 7, 'nom' => 'Décorateur/décoratrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 81, 'secteur_id' => 7, 'nom' => 'Designer graphique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 82, 'secteur_id' => 7, 'nom' => 'Directeur/directrice artistique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 83, 'secteur_id' => 7, 'nom' => 'Graphiste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 84, 'secteur_id' => 7, 'nom' => 'Journaliste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 85, 'secteur_id' => 7, 'nom' => 'Musicien/musicienne', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 86, 'secteur_id' => 7, 'nom' => 'Photographe', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 87, 'secteur_id' => 7, 'nom' => 'Réalisateur/réalisatrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 88, 'secteur_id' => 7, 'nom' => 'Styliste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 89, 'secteur_id' => 8, 'nom' => 'Conseiller/conseillère en formation', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 90, 'secteur_id' => 8, 'nom' => 'Enseignant/enseignante', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 91, 'secteur_id' => 8, 'nom' => 'Formateur/formatrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 92, 'secteur_id' => 8, 'nom' => 'Professeur/professeure', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 93, 'secteur_id' => 9, 'nom' => 'Agent technique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 94, 'secteur_id' => 9, 'nom' => 'Ingénieur chimiste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 95, 'secteur_id' => 9, 'nom' => 'Ingénieur mécanique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 96, 'secteur_id' => 9, 'nom' => 'Ingénieur électrique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 97, 'secteur_id' => 9, 'nom' => 'Mécanicien/mécanicienne', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 98, 'secteur_id' => 9, 'nom' => 'Responsable qualité', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 99, 'secteur_id' => 9, 'nom' => 'Technicien/technicienne en maintenance', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 100, 'secteur_id' => 10, 'nom' => 'Agent logistique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 101, 'secteur_id' => 10, 'nom' => 'Magasinier/magasinière', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 102, 'secteur_id' => 10, 'nom' => 'Manutentionnaire', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 103, 'secteur_id' => 10, 'nom' => 'Pilote', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 104, 'secteur_id' => 10, 'nom' => 'Responsable logistique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 105, 'secteur_id' => 11, 'nom' => 'Agent de voyage', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 106, 'secteur_id' => 11, 'nom' => 'Guide touristique', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 107, 'secteur_id' => 11, 'nom' => 'Serveur/serveuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 108, 'secteur_id' => 12, 'nom' => 'Agriculteur/agricultrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 109, 'secteur_id' => 12, 'nom' => 'Ingénieur agronome', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 110, 'secteur_id' => 12, 'nom' => 'Zoologiste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 111, 'secteur_id' => 13, 'nom' => 'Coiffeur/coiffeuse', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 112, 'secteur_id' => 13, 'nom' => 'Esthéticien/esthéticienne', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 113, 'secteur_id' => 14, 'nom' => 'Avocat/avocate', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 114, 'secteur_id' => 14, 'nom' => 'Juriste', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 115, 'secteur_id' => 15, 'nom' => 'Agent de sécurité', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 116, 'secteur_id' => 15, 'nom' => 'Responsable sécurité', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 117, 'secteur_id' => 16, 'nom' => 'Agent immobilier', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 118, 'secteur_id' => 17, 'nom' => 'Conseiller/conseillère en gestion', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 119, 'secteur_id' => 17, 'nom' => 'Traducteur/traductrice', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 120, 'secteur_id' => 18, 'nom' => 'Boucher/bouchère', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
        ]);

        // Seed Users
        // Using existing hashed passwords from the old dump
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin StagesBenin', 'email' => 'admin@stagesbenin.com', 'email_verified_at' => '2025-04-30 14:30:42', 'password' => '$2y$10$YmwnRMf14ECu7w.ZTsK7zeLP61rMoqayEA75IF6rocavkeeOqOtTO', 'role' => 'admin', 'remember_token' => 'lStroLQkV1No0qAO1plrO2j2wZv5iZyBDZHH7QHdDZp5aojyynWyJl73NkW9', 'created_at' => '2025-04-30 14:30:42', 'updated_at' => '2025-04-30 14:30:42'],
            ['id' => 2, 'name' => 'Amina SOGLO', 'email' => 'amina.soglo@example.com', 'email_verified_at' => '2025-04-30 14:30:42', 'password' => '$2y$10$3ttgsnolIqLvKwG.Q2j7z.P17Gk9d2qcrOjCuKPQ1SIhjIcQ04NnO', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-04-30 14:30:42', 'updated_at' => '2025-04-30 14:30:42'],
            ['id' => 3, 'name' => 'Bio GUERA', 'email' => 'bio.guera@example.com', 'email_verified_at' => '2025-04-30 14:30:42', 'password' => '$2y$10$/5dSmci626RrOYaT2cFuYO0NQb3y5hsdNAFJQb/eGxlrxH6ioAlea', 'role' => 'etudiant', 'remember_token' => 'PITyTdCktJYfpJfoQSkayiHR74lXgOBElE7SLwv483cHfpZIqg2oDFxf6rKL', 'created_at' => '2025-04-30 14:30:42', 'updated_at' => '2025-04-30 14:30:42'],
            ['id' => 4, 'name' => 'Carine HOUNSOOU', 'email' => 'carine.hounsou@example.com', 'email_verified_at' => '2025-04-30 14:30:43', 'password' => '$2y$10$GqBciuTd4D7HikzNXX44NOA8HgzAyykavLnqxZ/Uc51R0u5Vz4Oxu', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 5, 'name' => 'David AKOTO', 'email' => 'david.akoto@techsolutions.bj', 'email_verified_at' => '2025-04-30 14:30:43', 'password' => '$2y$10$Jjnmv0CpubHQA2VqlkbtR.5830Dxol1t.DUpXnmIl/Hbw16DRKt5u', 'role' => 'recruteur', 'remember_token' => 'hhFookNmXKKeT08V5baJLS6w1B61BgkmUhrGZnAsl7PlKyVrZIwix1KKWTdU', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 6, 'name' => 'Elise PADONOU', 'email' => 'elise.padonou@agroplus.com', 'email_verified_at' => '2025-04-30 14:30:43', 'password' => '$2y$10$ECADpoVr6tXxVAd2g5tBuuhYBXDETd8SJY8oIgN8akrlPxrFziSZe', 'role' => 'recruteur', 'remember_token' => null, 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43'],
            ['id' => 7, 'name' => 'Adam Dim', 'email' => 'hosanaconsulting@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$5yJtHiUi1iFZixz5OtGeh.ALSKDVnxrXGKahf8j.g8Zq4ZNRghBsS', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-04-30 18:19:42', 'updated_at' => '2025-04-30 18:19:42'],
            ['id' => 8, 'name' => 'dimitriadama9', 'email' => 'dimitriadama9@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$pcVB1q2Bo55Bu3zYLMJWbeY7mDPuirX3fxn.32Uov/A9TEUwguQzy', 'role' => 'recruteur', 'remember_token' => null, 'created_at' => '2025-04-30 18:29:37', 'updated_at' => '2025-04-30 18:29:37'],
            ['id' => 9, 'name' => 'Salomé HOUGNI', 'email' => 'salomehougni@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$ez9XSi4HKRRFT.rMViIlxuEX9HHJ5DSBzfKWScg.v68lRrql3Ozlu', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-04-30 23:11:28', 'updated_at' => '2025-04-30 23:11:28'],
            ['id' => 10, 'name' => 'Gbèkpo Fiacre GBOVI', 'email' => 'gbekpofiacre@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$Tgj2/UV3W3HFbqc8D8aZ5OzJYQy6KOcdXnQUYDkdN8XMpAWfS1c6u', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-01 06:38:38', 'updated_at' => '2025-05-01 06:38:38'],
            ['id' => 11, 'name' => 'Noël Nanoukon', 'email' => 'noelnanoukon@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$U6cuuUG/GHtIkejbMOEg/OZi23bZAPZTS1z7zf9MHvf2hlk41GkBe', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-01 12:59:57', 'updated_at' => '2025-05-01 12:59:57'],
            ['id' => 12, 'name' => 'contact', 'email' => 'contact@stagesbenin.com', 'email_verified_at' => null, 'password' => '$2y$10$MmIFszlMp.Qpo28DxcGjxejZE4DMRjekTqPXpxjcJIxhZF72s.J4G', 'role' => 'recruteur', 'remember_token' => 'lenHaYf40Vv91vwYHH0Tn2HKK857e6HyZLwKbDW10z4Psk93XSBgQC1x2rZn', 'created_at' => '2025-05-01 13:21:13', 'updated_at' => '2025-05-01 13:21:13'],
            ['id' => 13, 'name' => 'MASROURATH MORAYO AMAKÈ BOURAIMA', 'email' => 'masrourathb6@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$Lh/4zWIWFkNytYFKl0CFgOu/WzPsu0nRps0c7cgiivwJW9LesysDK', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-02 16:15:48', 'updated_at' => '2025-05-02 16:15:48'],
            ['id' => 14, 'name' => 'Aimée Dorcas HOUNGUE', 'email' => 'hounguedorcas99@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$mC4WpbYRQYSK/u448bkG7.G.fKurV4GHbaJ0OfQXC8Udf7aAf6EOe', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 11:33:58', 'updated_at' => '2025-05-03 11:33:58'],
            ['id' => 15, 'name' => 'DONALD JUNIOR KOFFI DIDAVI', 'email' => 'Donalddidavi583@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$ln5CAw7F7UURDTC7sQNsKuyGFOO28Eut2nDVS.cn5d3.MykgOPNp6', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 12:55:01', 'updated_at' => '2025-05-03 13:18:52'],
            ['id' => 16, 'name' => 'Marianne De souza', 'email' => 'mariannetaniasessid@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$tM5NyRgHu5amcw7hW6K5buRjm69JbC5PDUJH5Oe6mfeSMXK8jCsDG', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 13:15:33', 'updated_at' => '2025-05-03 13:15:33'],
            ['id' => 17, 'name' => 'Déo-Gratias Sègla GBEKPO', 'email' => 'asegla20@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$ES64bzXLDM0SdAd6DOz.NelfbdYxJIXl28wenklZ4xpcDGlwj9kKm', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 14:35:34', 'updated_at' => '2025-05-03 14:35:34'],
            ['id' => 18, 'name' => 'Judicaël Biodoun OYEDE', 'email' => 'judicaeloyede@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$NZ/RQLBCNNW5F2PJHO5SJOkHWL8JZLaMXtGhwwXk7ilSrx0Ma1n1G', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 14:55:14', 'updated_at' => '2025-05-03 14:55:14'],
            ['id' => 19, 'name' => 'Immaculée GUEDOU', 'email' => 'immaguedou@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$CIrw.G.fjuNFwhcUAsoyseJ13DuNN/PalAne0q5tnV6chuyEO.DTq', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 15:13:09', 'updated_at' => '2025-05-03 15:13:09'],
            ['id' => 20, 'name' => 'Alamou Raoul AIGBEDE', 'email' => 'aigbederaoul@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$IIZEW7uHtLoTCjyCtPDLKuj2rNCvchp4szj2vFpcxXzSJrx.d9uIK', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 15:25:56', 'updated_at' => '2025-05-03 15:25:56'],
            ['id' => 21, 'name' => 'Elysée Marcel DEGBEY', 'email' => 'degbeyelysee6@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$lretqcETN3j73LfG1gKAGuJTFerHu6JBO9JOTzp/JbcecmUogkarm', 'role' => 'etudiant', 'remember_token' => 'biCgnEqB6YGsp5HEtWlC4XlmpqJqwWgqMcXhn58hzWdgy7VKCifpcZ29OeCE', 'created_at' => '2025-05-03 15:28:14', 'updated_at' => '2025-05-03 15:28:14'],
            ['id' => 22, 'name' => 'Fouwad KAMAROU', 'email' => 'fouwadkamarou@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$GsasWB19oxB78YuCkUsFhOTzL7kTmc4saE/sfRSEum13yUlvIr8Ia', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 15:28:20', 'updated_at' => '2025-05-03 15:28:20'],
            ['id' => 23, 'name' => 'Gualillé Fidèle KPLE', 'email' => 'kplegualillefidele@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$E1.L3NXSIshCFirB3Am5q.A0xzn6rxilU5oaJFNPsvgYJ4SnWX1I.', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 15:37:44', 'updated_at' => '2025-05-03 15:37:44'],
            ['id' => 24, 'name' => 'Lydie Shalom Hocéane OUSSOU-ACCKRAH', 'email' => 'Shalomoussouacckrah@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$uGDpUDVFIR25g5HQ4xpK8.qprYVkArJd.DztXmKrSWwkexox6GFFy', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 16:22:17', 'updated_at' => '2025-05-03 16:22:17'],
            ['id' => 25, 'name' => 'Ahouefa Ashley Grâce AMOUSSOU', 'email' => 'shlamoussou@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$.NDTHvBRJCrFYp0RfsYV7.XfPxCsffDIB0Ek4psfBj9x973KxtIve', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 16:49:49', 'updated_at' => '2025-05-03 16:49:49'],
            ['id' => 26, 'name' => 'Rayane TOURE', 'email' => 't.rayane2001@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$878G.YpzYkMJwkxVuUz20OgpQ6UXfwT2tT/F7HM4sDImEw7xdgMRm', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 16:55:32', 'updated_at' => '2025-05-03 16:55:32'],
            ['id' => 27, 'name' => 'Justine T. GBOGBO', 'email' => 'justinegbogbo1@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$mK5ZuBgrkvLPS8FAOmyA7ea2Q0ePd6MbatjzUCTF.wbHtloHE7kCm', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 18:42:17', 'updated_at' => '2025-05-03 18:42:17'],
            ['id' => 28, 'name' => 'Florent Favi', 'email' => 'faviflorent78@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$mktB853uLeKTx.SCRcoQLu6sUZoZ7kJ1AIXmxQv7CDC2h4UVO0TzO', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 18:55:49', 'updated_at' => '2025-05-03 18:55:49'],
            ['id' => 29, 'name' => 'Simone GBEHOU', 'email' => 'gbehousimone@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$iMiAQp7vnArv.M6bKZBPAuukr6X8M68txHsBfwM91ALV4JZV/nnwy', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 20:00:27', 'updated_at' => '2025-05-03 20:00:27'],
            ['id' => 30, 'name' => 'Bayissin Célestin N\'KOUE', 'email' => 'celestinnkoue14@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$Yr3q68J8y1rzOtZrltSPROR9aQSxCNu1MVkDQ6q4jaGZPVsgDmUka', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 20:21:41', 'updated_at' => '2025-05-03 20:21:41'],
            ['id' => 31, 'name' => 'Ruth Assou', 'email' => 'assouariane@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$fGiM4ofhRJl33u61Mx9wuOUVfMwFLjBXrZEWZ9U5.zWOFfcQ8NX82', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 21:32:46', 'updated_at' => '2025-05-03 21:32:46'],
            ['id' => 32, 'name' => 'Ben Fernand Adégbité CHOLE', 'email' => 'choleben20@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$BpaIgl3D0koekBUePhjZcOP.dgU3..yR/rcSnEepV1mmP7mQilwwq', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 22:26:12', 'updated_at' => '2025-05-03 22:26:12'],
            ['id' => 33, 'name' => 'Prixson Abdias Sedjlo AZIFAN', 'email' => 'avatarnn2@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$Ap4FZve7MLNcNigsQ1l7oeIHne34khQ2FrB6ohUeORed3Cc81OPaq', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-03 23:29:13', 'updated_at' => '2025-05-03 23:29:13'],
            ['id' => 34, 'name' => 'Nicanore CAPO', 'email' => 'nicanorecapo64@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$j/HpqiE1NdOng8VVFYocDuCif6FylFD6T4W0l9j2hshn5MQwKw.VK', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-04 07:04:26', 'updated_at' => '2025-05-04 07:04:26'],
            ['id' => 35, 'name' => 'Kelly BOCO', 'email' => 'kellyboco110@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$MOPbUh9jCe7vZnJTbtudsuf3sH3/NYrv.qW59nTWDiNHkwJ3kVrCC', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-04 09:24:01', 'updated_at' => '2025-05-04 09:24:01'],
            ['id' => 36, 'name' => 'biotimperegouchristiane', 'email' => 'biotimperegouchristiane@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$.fPyyKv1Sp1zktkJdSi2fe.Cqu0ZLuvMKENH1Yhz3aEFaGNDeh6Bq', 'role' => 'recruteur', 'remember_token' => null, 'created_at' => '2025-05-04 13:26:32', 'updated_at' => '2025-05-04 13:26:32'],
            ['id' => 37, 'name' => 'Ghislain ADINGNI', 'email' => 'adingnighislain@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$dGERdPgpgahHJNCMldemS.6n0rNqpdPpZomPR8w3jHTYF1cHGt4DC', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-04 14:44:50', 'updated_at' => '2025-05-04 14:44:50'],
            ['id' => 38, 'name' => 'Chadrak TOSSOU-GBETE', 'email' => 'chadraktossougbete@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$L3YoEVKOYGAXfgeQRDL1c.FhhoQU9TUxct/X/eDnTW2R1NCF./I2W', 'role' => 'etudiant', 'remember_token' => '7mNZfv0pTOZmqAjv369Zd8F6791Yn4jx0n66q2z1cz6k29qcTzGPpsnLQOGb', 'created_at' => '2025-05-04 19:00:17', 'updated_at' => '2025-05-04 19:00:17'],
            ['id' => 39, 'name' => 'CASTRANCE MEDESSE MEDETONDJI', 'email' => 'castro02medetondji@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$/0HZjqpHbSU5ccPippaUpOHlyuuGqCBCTa1qLqfBRBOI8Udbun22S', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-04 21:11:52', 'updated_at' => '2025-05-04 21:11:52'],
            ['id' => 40, 'name' => 'Carmen ACCROMBESSI', 'email' => 'jenniferaccrombessi606@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$f7lBXUWCDnEd2Gynmj0kV.BaeSl5weq5Eqilp0Et6FLc6eJ9Lusvm', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-04 22:06:52', 'updated_at' => '2025-05-04 22:06:52'],
            ['id' => 41, 'name' => 'Esther SAÏZONOU', 'email' => 'esthersaizonou54@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$6727wtWeBJ0.DuvsLuFjFeg0fhVDM7ovLdaLtx3G3OfRCDjgX4QZa', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 05:08:43', 'updated_at' => '2025-05-05 05:08:43'],
            ['id' => 42, 'name' => 'Manoel CHOGOLOU', 'email' => 'manoelchogolou@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$SEkU0NR2He536Tck8dfDBe11AIsEbhpgjr.QRpbhBbm6wveCmIQVC', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 06:59:37', 'updated_at' => '2025-05-05 06:59:37'],
            ['id' => 43, 'name' => 'IRELE ALEX 1ER JUMEAU EZIN DANIEL', 'email' => 'alexireleezindaniel@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$QIM67G4.vqAR0v2/S0B5cOVAH0o8SiSbZQXAu9Hzm/II1TPWG/7Yu', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 07:40:32', 'updated_at' => '2025-05-05 07:40:32'],
            ['id' => 44, 'name' => 'Beryl QUENUM', 'email' => 'berylquenum@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$xScAty3.9hejBxkeJr3FwOWZ1/nUK7EnFu2U7HX.HZzsvvlKWv8di', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 07:54:04', 'updated_at' => '2025-05-05 07:54:04'],
            ['id' => 45, 'name' => 'Jésugnon Colette AHOUANVOEKE', 'email' => 'coletteahouanvoeke516@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$0n8F8hQ34reve8exfzJS0uk/XgqiU0iRmhnOU5KCdyRLF7w0i/sRW', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 08:21:44', 'updated_at' => '2025-05-05 08:21:44'],
            ['id' => 46, 'name' => 'Grâce ANANI', 'email' => 'graceanani6@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$.JVrUNn4iUvN42oncGUmBOM3Z11L9qTNdcHXZvBE1FTe8oJXl3dq2', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 08:51:18', 'updated_at' => '2025-05-05 08:51:18'],
            ['id' => 47, 'name' => 'Junior AKPI', 'email' => 'juniorakpi39@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$AP.G10sw.7qbiOszhE89Pui4X//SO0qbN31kknItxNk3YQPAKg2gu', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 09:02:45', 'updated_at' => '2025-05-05 09:02:45'],
            ['id' => 48, 'name' => 'Odette ALAYE', 'email' => 'odettealaye911@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$TeXnseumWHrVOvdxtem1zeje0ll.nCcblYGp1rOKeoIMWpHWKqHde', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 10:07:37', 'updated_at' => '2025-05-05 10:07:37'],
            ['id' => 49, 'name' => 'Nadiath ALASSANE', 'email' => 'alassanefadeilou9@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$rFVYlxli3zNuBe8BTktQkOiDGbpVmm296G4FJnuXJZ.oZUUkyZZa2', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 11:00:43', 'updated_at' => '2025-05-05 11:00:43'],
            ['id' => 50, 'name' => 'fdFadéilou ALASSANE', 'email' => 'afadeilou1@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$/kCtvpdosWSEttsjRVI5uOUEjhM6D/iSGLkHrLRFrnlt5unXI8rp.', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 11:04:32', 'updated_at' => '2025-05-05 11:04:32'],
            ['id' => 51, 'name' => 'Prosper Assogba', 'email' => 'assogbaprosper878@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$YjDrjvt6i7I90Ibf88aou.BjsqRIbW2pKvmCPw0f3tAmA04fX9OZu', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 11:20:23', 'updated_at' => '2025-05-05 12:19:56'],
            ['id' => 52, 'name' => 'Prudencia Gertrude Jessougnon AVOCETIEN', 'email' => 'avocetienmartin61@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$lx2VbVPmJUxdEBqScEY71u0BpusFS7J/RO427Y6KLlHjZlzLv7/SG', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 11:48:30', 'updated_at' => '2025-05-05 11:48:30'],
            ['id' => 53, 'name' => 'Eljus AHISSOU', 'email' => 'eljusahissou@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$u19OuAJDAP0.OXlO9xjbjOpDEnC7jP549MxPH4T/tPwP1yQkaczka', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 14:59:26', 'updated_at' => '2025-05-05 14:59:26'],
            ['id' => 54, 'name' => 'Cédrik Agbodjan', 'email' => 'agbodjancedrik@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$xA0cyuwUpdmklM3x/qeh8.hISAd5aXc762NcLsYNiJAqISc3tyY3a', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-05 16:58:40', 'updated_at' => '2025-05-05 16:58:40'],
            ['id' => 55, 'name' => 'SEBIO MAHOULOLO', 'email' => 'createurmeuble@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$7GEdy/vMVOApHDBqq.TFFe0LGkNkgesic2D769w1WG7TIUVX1Kc0S', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-06 06:31:49', 'updated_at' => '2025-05-06 06:31:49'],
            ['id' => 56, 'name' => 'ALASSANE Fadéilou', 'email' => 'afadeilou10@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$EqgxMO8kIeFiFOwpcvq8Ke7/YGbIQOIUqqnduKyEQQvgd5.Qwq1je', 'role' => 'etudiant', 'remember_token' => null, 'created_at' => '2025-05-06 07:52:17', 'updated_at' => '2025-05-06 07:52:17'],
        ]);

        // Seed Entreprises
        DB::table('entreprises')->insert([
             ['id' => 1, 'nom' => 'Tech Solutions Bénin', 'secteur' => 'Informatique - Développement Web', 'description' => 'Leader en solutions logicielles innovantes au Bénin.', 'adresse' => 'Lot 123, Zongo, Cotonou', 'email' => 'contact@techsolutions.bj', 'telephone' => '21001122', 'site_web' => 'https://techsolutions.bj', 'logo_path' => null, 'contact_principal' => 'David AKOTO', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43', 'user_id' => 5], // Matches user ID 5
             ['id' => 2, 'nom' => 'AgroPlus Sarl', 'secteur' => 'Agro-alimentaire', 'description' => 'Transformation et commercialisation de produits agricoles locaux.', 'adresse' => 'Quartier Haie Vive, Parakou', 'email' => 'info@agroplus.com', 'telephone' => '22334455', 'site_web' => 'https://agroplus.com', 'logo_path' => null, 'contact_principal' => 'Elise PADONOU', 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43', 'user_id' => 6], // Matches user ID 6
             ['id' => 3, 'nom' => 'FHC Groupe Sarl', 'secteur' => null, 'description' => null, 'adresse' => null, 'email' => 'dimitriadama9@gmail.com', 'telephone' => null, 'site_web' => null, 'logo_path' => null, 'contact_principal' => null, 'created_at' => '2025-04-30 18:29:37', 'updated_at' => '2025-04-30 18:29:37', 'user_id' => 8], // Matches user ID 8
             ['id' => 4, 'nom' => 'DIMI', 'secteur' => null, 'description' => null, 'adresse' => null, 'email' => 'contact@stagesbenin.com', 'telephone' => null, 'site_web' => null, 'logo_path' => null, 'contact_principal' => null, 'created_at' => '2025-05-01 13:21:13', 'updated_at' => '2025-05-01 13:21:13', 'user_id' => 12], // Matches user ID 12
             ['id' => 5, 'nom' => 'Christiane BIO TIMPEREGOU', 'secteur' => null, 'description' => null, 'adresse' => null, 'email' => 'biotimperegouchristiane@gmail.com', 'telephone' => null, 'site_web' => null, 'logo_path' => null, 'contact_principal' => null, 'created_at' => '2025-05-04 13:26:32', 'updated_at' => '2025-05-04 13:26:32', 'user_id' => 36], // Matches user ID 36
        ]);


        // Seed Etudiants (Adaptation needed)
        // Map old `etudiants`.`id` to new `etudiants`.`id` and old `etudiants`.`user_id` to new `etudiants`.`user_id`
        DB::table('etudiants')->insert([
             // --- Adapt data from old `etudiants` table ---
             // --- New columns: `status` (default 'pending'), `specialite_id` (default null) ---
            ['id' => 1, 'nom' => 'SOGLO', 'prenom' => 'Amina', 'email' => 'amina.soglo@example.com', 'status' => 'pending', 'telephone' => '97001122', 'formation' => 'Génie Logiciel', 'statut' => 1, 'niveau' => 'Licence 3', 'date_naissance' => '2003-05-15', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-04-30 14:30:42', 'updated_at' => '2025-04-30 14:30:42', 'user_id' => 2, 'specialite_id' => null],
            ['id' => 2, 'nom' => 'GUERA', 'prenom' => 'Bio', 'email' => 'bio.guera@example.com', 'status' => 'pending', 'telephone' => '66998877', 'formation' => 'Réseaux et Télécommunications', 'statut' => 1, 'niveau' => 'Master 1', 'date_naissance' => '2001-11-20', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_3/855keIOaQzaCou3VxSyXsovQyor3LbL93g0t0II2.png', 'created_at' => '2025-04-30 14:30:42', 'updated_at' => '2025-04-30 18:26:41', 'user_id' => 3, 'specialite_id' => null],
            ['id' => 3, 'nom' => 'HOUNSOOU', 'prenom' => 'Carine', 'email' => 'carine.hounsou@example.com', 'status' => 'pending', 'telephone' => '51234567', 'formation' => 'Marketing Digital', 'statut' => 1, 'niveau' => 'Licence 2', 'date_naissance' => '2004-02-10', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-04-30 14:30:43', 'updated_at' => '2025-04-30 14:30:43', 'user_id' => 4, 'specialite_id' => null],
            ['id' => 5, 'nom' => 'HOUGNI', 'prenom' => 'Salomé', 'email' => 'salomehougni@gmail.com', 'status' => 'pending', 'telephone' => '+2290197420955', 'formation' => 'Planification et gestion des projets', 'statut' => 1, 'niveau' => 'Licence', 'date_naissance' => '2025-05-01', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-04-30 23:11:28', 'updated_at' => '2025-04-30 23:18:03', 'user_id' => 9, 'specialite_id' => null],
            ['id' => 6, 'nom' => 'GBOVI', 'prenom' => 'Gbèkpo Fiacre', 'email' => 'gbekpofiacre@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-01 06:38:38', 'updated_at' => '2025-05-01 06:38:38', 'user_id' => 10, 'specialite_id' => null],
            ['id' => 7, 'nom' => 'Nanoukon', 'prenom' => 'Noël', 'email' => 'noelnanoukon@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-01 12:59:57', 'updated_at' => '2025-05-01 12:59:57', 'user_id' => 11, 'specialite_id' => null],
            ['id' => 8, 'nom' => 'BOURAIMA', 'prenom' => 'MASROURATH MORAYO AMAKÈ', 'email' => 'masrourathb6@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-02 16:15:48', 'updated_at' => '2025-05-02 16:15:48', 'user_id' => 13, 'specialite_id' => null],
            ['id' => 9, 'nom' => 'HOUNGUE', 'prenom' => 'Aimée Dorcas', 'email' => 'hounguedorcas99@gmail.com', 'status' => 'pending', 'telephone' => '+2290151675658', 'formation' => 'Géoscience appliquées', 'statut' => 1, 'niveau' => null, 'date_naissance' => '1999-09-06', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_14/nYRqFmWHeJkPG84jajXydQnC5fpxePPwUNcqn77L.jpg', 'created_at' => '2025-05-03 11:33:58', 'updated_at' => '2025-05-03 11:43:00', 'user_id' => 14, 'specialite_id' => null],
            ['id' => 10, 'nom' => 'DIDAVI', 'prenom' => 'DONALD JUNIOR KOFFI', 'email' => 'Donalddidavi583@gmail.com', 'status' => 'pending', 'telephone' => '59278843', 'formation' => 'Tci', 'statut' => 1, 'niveau' => 'Genie électrique et informatique à tci', 'date_naissance' => '2025-05-26', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 12:55:01', 'updated_at' => '2025-05-03 13:05:18', 'user_id' => 15, 'specialite_id' => null],
            ['id' => 11, 'nom' => 'De souza', 'prenom' => 'Marianne', 'email' => 'mariannetaniasessid@gmail.com', 'status' => 'pending', 'telephone' => '+2290190087425', 'formation' => 'Nutrition sciences et technologies alimentaires', 'statut' => 1, 'niveau' => 'Diplôme de licence', 'date_naissance' => '2001-10-03', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 13:15:33', 'updated_at' => '2025-05-03 13:21:13', 'user_id' => 16, 'specialite_id' => null],
            ['id' => 12, 'nom' => 'GBEKPO', 'prenom' => 'Déo-Gratias Sègla', 'email' => 'asegla20@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_17/ZdKLYS8n1dW6neRJrtcQAKnoP7UQrHRxGxx5oiRl.png', 'created_at' => '2025-05-03 14:35:34', 'updated_at' => '2025-05-03 14:44:27', 'user_id' => 17, 'specialite_id' => null],
            ['id' => 13, 'nom' => 'OYEDE', 'prenom' => 'Judicaël Biodoun', 'email' => 'judicaeloyede@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 14:55:14', 'updated_at' => '2025-05-03 14:55:14', 'user_id' => 18, 'specialite_id' => null],
            ['id' => 14, 'nom' => 'GUEDOU', 'prenom' => 'Immaculée', 'email' => 'immaguedou@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 15:13:09', 'updated_at' => '2025-05-03 15:13:09', 'user_id' => 19, 'specialite_id' => null],
            ['id' => 15, 'nom' => 'AIGBEDE', 'prenom' => 'Alamou Raoul', 'email' => 'aigbederaoul@gmail.com', 'status' => 'pending', 'telephone' => '+2290153756824', 'formation' => 'Mécanique automobile', 'statut' => 1, 'niveau' => 'Licence', 'date_naissance' => '2003-07-07', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 15:25:56', 'updated_at' => '2025-05-03 15:27:32', 'user_id' => 20, 'specialite_id' => null],
            ['id' => 16, 'nom' => 'DEGBEY', 'prenom' => 'Elysée Marcel', 'email' => 'degbeyelysee6@gmail.com', 'status' => 'pending', 'telephone' => '0198801847', 'formation' => 'Gestion des ressources humaines', 'statut' => 1, 'niveau' => 'Master 1', 'date_naissance' => '2003-06-14', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 15:28:14', 'updated_at' => '2025-05-03 15:29:47', 'user_id' => 21, 'specialite_id' => null],
            ['id' => 17, 'nom' => 'KAMAROU', 'prenom' => 'Fouwad', 'email' => 'fouwadkamarou@gmail.com', 'status' => 'pending', 'telephone' => '+2290169276472', 'formation' => null, 'statut' => 1, 'niveau' => 'Licence 3 en gestion des ressources humaines', 'date_naissance' => '2002-10-26', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_22/7yW5Jd6t9Eygfjm5k9LZeqeTejrNXRsZVkgWHeyo.jpg', 'created_at' => '2025-05-03 15:28:20', 'updated_at' => '2025-05-04 05:55:06', 'user_id' => 22, 'specialite_id' => null],
            ['id' => 18, 'nom' => 'KPLE', 'prenom' => 'Gualillé Fidèle', 'email' => 'kplegualillefidele@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 15:37:44', 'updated_at' => '2025-05-03 15:37:44', 'user_id' => 23, 'specialite_id' => null],
            ['id' => 19, 'nom' => 'OUSSOU-ACCKRAH', 'prenom' => 'Lydie Shalom Hocéane', 'email' => 'Shalomoussouacckrah@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 16:22:17', 'updated_at' => '2025-05-03 16:22:17', 'user_id' => 24, 'specialite_id' => null],
            ['id' => 20, 'nom' => 'AMOUSSOU', 'prenom' => 'Ahouefa Ashley Grâce', 'email' => 'shlamoussou@gmail.com', 'status' => 'pending', 'telephone' => '66608081', 'formation' => 'Master en contrôle de gestion audit et finance 1', 'statut' => 1, 'niveau' => 'Licence professionnelle', 'date_naissance' => '2004-07-13', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 16:49:49', 'updated_at' => '2025-05-03 16:52:30', 'user_id' => 25, 'specialite_id' => null],
            ['id' => 21, 'nom' => 'TOURE', 'prenom' => 'Rayane', 'email' => 't.rayane2001@gmail.com', 'status' => 'pending', 'telephone' => '0166979859', 'formation' => null, 'statut' => 1, 'niveau' => 'Licence 3', 'date_naissance' => '2001-04-01', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 16:55:32', 'updated_at' => '2025-05-03 16:58:48', 'user_id' => 26, 'specialite_id' => null],
            ['id' => 22, 'nom' => 'GBOGBO', 'prenom' => 'Justine T.', 'email' => 'justinegbogbo1@gmail.com', 'status' => 'pending', 'telephone' => '+2290151757768', 'formation' => 'Droit privé', 'statut' => 1, 'niveau' => 'Licence 3', 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 18:42:17', 'updated_at' => '2025-05-03 19:16:59', 'user_id' => 27, 'specialite_id' => null],
            ['id' => 23, 'nom' => 'Favi', 'prenom' => 'Florent', 'email' => 'faviflorent78@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 18:55:49', 'updated_at' => '2025-05-03 18:55:49', 'user_id' => 28, 'specialite_id' => null],
            ['id' => 24, 'nom' => 'GBEHOU', 'prenom' => 'Simone', 'email' => 'gbehousimone@gmail.com', 'status' => 'pending', 'telephone' => '0146320732', 'formation' => 'Aucun', 'statut' => 1, 'niveau' => 'Baccalauréat professionnel', 'date_naissance' => '2003-05-03', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 20:00:27', 'updated_at' => '2025-05-04 16:29:53', 'user_id' => 29, 'specialite_id' => null],
            ['id' => 25, 'nom' => 'N\'KOUE', 'prenom' => 'Bayissin Célestin', 'email' => 'celestinnkoue14@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 20:21:41', 'updated_at' => '2025-05-03 20:21:41', 'user_id' => 30, 'specialite_id' => null],
            ['id' => 26, 'nom' => 'Assou', 'prenom' => 'Ruth', 'email' => 'assouariane@gmail.com', 'status' => 'pending', 'telephone' => '0199472085', 'formation' => 'Entrepreneuriat et gestion des projets', 'statut' => 1, 'niveau' => 'Licence 3', 'date_naissance' => '2002-10-11', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_31/hHZpmpZHTdfFWXvN0nXG9lHlaGiVFytVXjEUW64D.jpg', 'created_at' => '2025-05-03 21:32:46', 'updated_at' => '2025-05-04 10:36:16', 'user_id' => 31, 'specialite_id' => null],
            ['id' => 27, 'nom' => 'CHOLE', 'prenom' => 'Ben Fernand Adégbité', 'email' => 'choleben20@gmail.com', 'status' => 'pending', 'telephone' => '0151838558', 'formation' => 'Administration des Finances et Trésor', 'statut' => 1, 'niveau' => 'Licence 3 en Administration des Finances et Trésor', 'date_naissance' => '2002-06-27', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_32/7acMzZsLN1dxpemYXzyLEY6iDI4VJiCiWepbVlzo.jpg', 'created_at' => '2025-05-03 22:26:12', 'updated_at' => '2025-05-03 22:32:16', 'user_id' => 32, 'specialite_id' => null],
            ['id' => 28, 'nom' => 'AZIFAN', 'prenom' => 'Prixson Abdias Sedjlo', 'email' => 'avatarnn2@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-03 23:29:13', 'updated_at' => '2025-05-03 23:29:13', 'user_id' => 33, 'specialite_id' => null],
            ['id' => 29, 'nom' => 'CAPO', 'prenom' => 'Nicanore', 'email' => 'nicanorecapo64@gmail.com', 'status' => 'pending', 'telephone' => '0197031793', 'formation' => 'Microbiologie et biotechnologie Alimentaire', 'statut' => 1, 'niveau' => 'Licence 3', 'date_naissance' => '1999-04-15', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-04 07:04:26', 'updated_at' => '2025-05-04 07:08:26', 'user_id' => 34, 'specialite_id' => null],
            ['id' => 30, 'nom' => 'BOCO', 'prenom' => 'Kelly', 'email' => 'kellyboco110@gmail.com', 'status' => 'pending', 'telephone' => '0166958251', 'formation' => 'Informatique', 'statut' => 1, 'niveau' => 'BAC', 'date_naissance' => '2005-10-18', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_35/eHEBnu0RtB69VzUXqGay0Q41Aa9oUFs4uyNdYrca.jpg', 'created_at' => '2025-05-04 09:24:01', 'updated_at' => '2025-05-05 07:55:35', 'user_id' => 35, 'specialite_id' => null],
            ['id' => 31, 'nom' => 'ADINGNI', 'prenom' => 'Ghislain', 'email' => 'adingnighislain@gmail.com', 'status' => 'pending', 'telephone' => '0169391976', 'formation' => 'Gestion Financière et Comptable', 'statut' => 1, 'niveau' => 'Licence 3', 'date_naissance' => '2003-08-04', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-04 14:44:50', 'updated_at' => '2025-05-04 14:47:47', 'user_id' => 37, 'specialite_id' => null],
            ['id' => 32, 'nom' => 'TOSSOU-GBETE', 'prenom' => 'Chadrak', 'email' => 'chadraktossougbete@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-04 19:00:17', 'updated_at' => '2025-05-04 19:00:17', 'user_id' => 38, 'specialite_id' => null],
            ['id' => 33, 'nom' => 'MEDETONDJI', 'prenom' => 'CASTRANCE MEDESSE', 'email' => 'castro02medetondji@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-04 21:11:52', 'updated_at' => '2025-05-04 21:11:52', 'user_id' => 39, 'specialite_id' => null],
            ['id' => 34, 'nom' => 'ACCROMBESSI', 'prenom' => 'Carmen', 'email' => 'jenniferaccrombessi606@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-04 22:06:52', 'updated_at' => '2025-05-04 22:06:52', 'user_id' => 40, 'specialite_id' => null],
            ['id' => 35, 'nom' => 'SAÏZONOU', 'prenom' => 'Esther', 'email' => 'esthersaizonou54@gmail.com', 'status' => 'pending', 'telephone' => '53888108', 'formation' => 'Aucune', 'statut' => 1, 'niveau' => 'Licence en Banque Finance et Assurance', 'date_naissance' => '2004-08-05', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 05:08:43', 'updated_at' => '2025-05-05 05:12:06', 'user_id' => 41, 'specialite_id' => null],
            ['id' => 36, 'nom' => 'CHOGOLOU', 'prenom' => 'Manoel', 'email' => 'manoelchogolou@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 06:59:37', 'updated_at' => '2025-05-05 06:59:37', 'user_id' => 42, 'specialite_id' => null],
            ['id' => 37, 'nom' => 'EZIN DANIEL', 'prenom' => 'IRELE ALEX 1ER JUMEAU', 'email' => 'alexireleezindaniel@gmail.com', 'status' => 'pending', 'telephone' => '95683959/40413962', 'formation' => 'Agronomie', 'statut' => 1, 'niveau' => 'Bac professionnel', 'date_naissance' => '1995-01-30', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 07:40:32', 'updated_at' => '2025-05-05 07:44:48', 'user_id' => 43, 'specialite_id' => null],
            ['id' => 38, 'nom' => 'QUENUM', 'prenom' => 'Beryl', 'email' => 'berylquenum@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 07:54:04', 'updated_at' => '2025-05-05 07:54:04', 'user_id' => 44, 'specialite_id' => null],
            ['id' => 39, 'nom' => 'AHOUANVOEKE', 'prenom' => 'Jésugnon Colette', 'email' => 'coletteahouanvoeke516@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 08:21:44', 'updated_at' => '2025-05-05 08:21:44', 'user_id' => 45, 'specialite_id' => null],
            ['id' => 40, 'nom' => 'ANANI', 'prenom' => 'Grâce', 'email' => 'graceanani6@gmail.com', 'status' => 'pending', 'telephone' => '0162983405', 'formation' => 'Sociologie Anthropologie', 'statut' => 1, 'niveau' => 'Licence Professionnelle', 'date_naissance' => '1999-06-05', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 08:51:18', 'updated_at' => '2025-05-05 08:53:14', 'user_id' => 46, 'specialite_id' => null],
            ['id' => 41, 'nom' => 'AKPI', 'prenom' => 'Junior', 'email' => 'juniorakpi39@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 09:02:45', 'updated_at' => '2025-05-05 09:02:45', 'user_id' => 47, 'specialite_id' => null],
            ['id' => 42, 'nom' => 'ALAYE', 'prenom' => 'Odette', 'email' => 'odettealaye911@gmail.com', 'status' => 'pending', 'telephone' => '+2290191135847', 'formation' => 'Marchés Publics', 'statut' => 1, 'niveau' => 'Licence en Droit privé', 'date_naissance' => '2002-04-20', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_48/Z6sPeDbsP7IkHk16lCf9P6NibZQsIseAf3SRA0Mp.jpg', 'created_at' => '2025-05-05 10:07:37', 'updated_at' => '2025-05-05 10:15:09', 'user_id' => 48, 'specialite_id' => null],
            ['id' => 43, 'nom' => 'ALASSANE', 'prenom' => 'Nadiath', 'email' => 'alassanefadeilou9@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 11:00:43', 'updated_at' => '2025-05-05 11:00:43', 'user_id' => 49, 'specialite_id' => null],
            ['id' => 44, 'nom' => 'ALASSANE', 'prenom' => 'fdFadéilou', 'email' => 'afadeilou1@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 11:04:32', 'updated_at' => '2025-05-05 11:04:32', 'user_id' => 50, 'specialite_id' => null],
            ['id' => 45, 'nom' => 'Assogba', 'prenom' => 'Prosper', 'email' => 'assogbaprosper878@gmail.com', 'status' => 'pending', 'telephone' => '0191149280', 'formation' => 'Logistique', 'statut' => 1, 'niveau' => 'Licence professionnelle', 'date_naissance' => '1994-06-24', 'cv_path' => null, 'photo_path' => 'etudiant_photos/user_51/fJcn6tfZWIcHLF3a7bmATCaG0CzPTdVe3XemJXBX.jpg', 'created_at' => '2025-05-05 11:20:23', 'updated_at' => '2025-05-05 12:19:04', 'user_id' => 51, 'specialite_id' => null],
            ['id' => 46, 'nom' => 'AVOCETIEN', 'prenom' => 'Prudencia Gertrude Jessougnon', 'email' => 'avocetienmartin61@gmail.com', 'status' => 'pending', 'telephone' => '0191310252', 'formation' => null, 'statut' => 1, 'niveau' => 'Licence', 'date_naissance' => '2003-07-17', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 11:48:30', 'updated_at' => '2025-05-05 11:54:20', 'user_id' => 52, 'specialite_id' => null],
            ['id' => 47, 'nom' => 'AHISSOU', 'prenom' => 'Eljus', 'email' => 'eljusahissou@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 14:59:26', 'updated_at' => '2025-05-05 14:59:26', 'user_id' => 53, 'specialite_id' => null],
            ['id' => 48, 'nom' => 'Agbodjan', 'prenom' => 'Cédrik', 'email' => 'agbodjancedrik@gmail.com', 'status' => 'pending', 'telephone' => '2290194810780', 'formation' => 'Développement web full stack', 'statut' => 1, 'niveau' => 'BAC', 'date_naissance' => '2004-09-05', 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-05 16:58:40', 'updated_at' => '2025-05-05 19:13:28', 'user_id' => 54, 'specialite_id' => null],
            ['id' => 50, 'nom' => 'ALASSANE', 'prenom' => 'Fadéilou', 'email' => 'afadeilou10@gmail.com', 'status' => 'pending', 'telephone' => '+2290168929853', 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-06 07:52:17', 'updated_at' => '2025-05-06 07:52:17', 'user_id' => 56, 'specialite_id' => null],
            // Old etudiant id 51 linked to user 55
             ['id' => 51, 'nom' => 'SEBIO', 'prenom' => 'MAHOULOLO', 'email' => 'createurmeuble@gmail.com', 'status' => 'pending', 'telephone' => null, 'formation' => null, 'statut' => 1, 'niveau' => null, 'date_naissance' => null, 'cv_path' => null, 'photo_path' => null, 'created_at' => '2025-05-06 06:31:49', 'updated_at' => '2025-05-06 06:31:49', 'user_id' => 55, 'specialite_id' => null],
        ]);


        // Seed CV Profiles (Corrected)
        DB::table('cv_profiles')->insert([
            // --- Ensure ALL 17 columns are present in each array ---
            [
                'id' => 1, 'etudiant_id' => 2, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-04-30 18:12:02', 'updated_at' => '2025-04-30 18:12:02'
            ],
            [
                'id' => 3, 'etudiant_id' => 5, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-04-30 23:14:33', 'updated_at' => '2025-04-30 23:14:33'
            ],
            [
                'id' => 4, 'etudiant_id' => 6, 'titre_profil' => 'Suivi-évaluation ',
                'resume_profil' => 'Jeune diplômé en Sciences Économiques, dynamique et rigoureux, disposant d\'une solide expérience en gestion logistique, suivi de stocks et gestion des moyens généraux. Fort d\'une capacité d’adaptation rapide et d’un sens élevé de l’organisation, je suis motivé pour intégrer un environnement exigeant afin de contribuer efficacement à l’optimisation des ressources matérielles et logistiques.',
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => 'Marié(e)', 'nationalite' => 'Béninoise ',
                'date_naissance' => '1996-08-27', 'lieu_naissance' => 'Aholouyèmè', 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-01 06:40:23', 'updated_at' => '2025-05-01 07:24:19'
            ],
            [
                'id' => 5, 'etudiant_id' => 7, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-01 22:21:34', 'updated_at' => '2025-05-01 22:21:34'
            ],
             [
                'id' => 6, 'etudiant_id' => 1, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-02 14:42:08', 'updated_at' => '2025-05-02 14:42:08'
            ],
            [
                'id' => 7, 'etudiant_id' => 8, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-02 16:18:03', 'updated_at' => '2025-05-02 16:18:03'
            ],
            [
                'id' => 8, 'etudiant_id' => 10, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 12:56:34', 'updated_at' => '2025-05-03 12:56:34'
            ],
            [
                'id' => 9, 'etudiant_id' => 9, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 13:04:33', 'updated_at' => '2025-05-03 13:04:33'
            ],
            [
                'id' => 10, 'etudiant_id' => 11, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 13:21:54', 'updated_at' => '2025-05-03 13:21:54'
            ],
            [
                'id' => 11, 'etudiant_id' => 12, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 14:45:50', 'updated_at' => '2025-05-03 14:45:50'
            ],
            [
                'id' => 12, 'etudiant_id' => 13, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 14:55:55', 'updated_at' => '2025-05-03 14:55:55'
            ],
            [
                'id' => 13, 'etudiant_id' => 14, 'titre_profil' => 'Gestion Financière Comptable ',
                'resume_profil' => '', 'adresse' => null, 'telephone_cv' => null, 'email_cv' => null,
                'linkedin_url' => null, 'portfolio_url' => null, 'situation_matrimoniale' => null,
                'nationalite' => null, 'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 15:13:34', 'updated_at' => '2025-05-03 15:14:14'
            ],
            [
                'id' => 14, 'etudiant_id' => 3, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 15:18:03', 'updated_at' => '2025-05-03 15:18:03'
            ],
            [
                'id' => 15, 'etudiant_id' => 15, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 15:27:51', 'updated_at' => '2025-05-03 15:27:51'
            ],
            [
                'id' => 16, 'etudiant_id' => 16, 'titre_profil' => 'Assistant RH ', 'resume_profil' => '',
                'adresse' => 'Godomey-Togoudo ', 'telephone_cv' => '0198801847', 'email_cv' => 'degbeyelysee6@gmail.com',
                'linkedin_url' => null, 'portfolio_url' => null, 'situation_matrimoniale' => 'Célibataire',
                'nationalite' => 'Béninoise ', 'date_naissance' => '2003-06-14', 'lieu_naissance' => 'Cotonou ',
                'photo_cv_path' => null, 'template_slug' => 'default', 'created_at' => '2025-05-03 15:35:01', 'updated_at' => '2025-05-03 16:09:19'
            ],
            [
                'id' => 17, 'etudiant_id' => 17, 'titre_profil' => 'Stagiaire RH',
                'resume_profil' => 'Jeune diplômée, je recherche un poste qui me permette de continuer à apprendre et à me perfectionner en fournissant un travail de \r\nqualité et qui m\'encourage à m\'épanouir en tant que gestionnaire des ressources humaines.',
                'adresse' => 'Cotonou', 'telephone_cv' => '+22969276472', 'email_cv' => 'fouwadkamarou@gmail.com',
                'linkedin_url' => 'https://www.linkedin.com/in/fouwad-kamarou-3213a6338?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app',
                'portfolio_url' => null, 'situation_matrimoniale' => 'Célibataire', 'nationalite' => 'Béninois ',
                'date_naissance' => '2002-10-26', 'lieu_naissance' => 'Cotonou ', 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 16:01:59', 'updated_at' => '2025-05-05 06:02:52'
            ],
            [
                'id' => 18, 'etudiant_id' => 21, 'titre_profil' => 'Gestionnaire Comptable',
                'resume_profil' => 'je suis activement à la recherche d\'une structure qui pourrait m\'accueillir dans le cadre d\'un stage professionnel, afin de mettre en pratique mes connaissances et approfondir mon expérience dans le domaine de la comptabilité et de la gestion financière.Au cours de mon parcours académique, j’ai acquis de solides compétences en comptabilité, en analyse financière et en gestion budgétaire. Intégrer une entreprise serait donc une opportunité précieuse pour moi d’appliquer mes connaissances et d’acquérir une expérience pratique enrichissante. Je suis persuadé que mon sérieux et mon engagement seront des atouts.',
                'adresse' => 'Vodjè/Cotonou', 'telephone_cv' => '0166979859', 'email_cv' => 't.rayane2001@gmail.com',
                'linkedin_url' => null, 'portfolio_url' => null, 'situation_matrimoniale' => 'Célibataire',
                'nationalite' => 'Béninoise', 'date_naissance' => '2001-04-01', 'lieu_naissance' => 'Djougou',
                'photo_cv_path' => null, 'template_slug' => 'default', 'created_at' => '2025-05-03 16:59:10', 'updated_at' => '2025-05-03 17:15:54'
            ],
            [
                'id' => 19, 'etudiant_id' => 22, 'titre_profil' => 'Comptable ',
                'resume_profil' => 'Titulaire d\'une licence professionnelle en Comptabilité Audit et Contrôle de Gestion ',
                'adresse' => 'Calavi iita', 'telephone_cv' => '+2290151757768', 'email_cv' => 'justinegbogbo1@gmail.com',
                'linkedin_url' => 'https://www.linkedin.com/in/justine-gbogbo-2b5485350', 'portfolio_url' => null,
                'situation_matrimoniale' => 'Célibataire', 'nationalite' => 'Béninoise ', 'date_naissance' => '2001-10-12',
                'lieu_naissance' => 'Bohicon ', 'photo_cv_path' => 'cv_photos/Q7Xg16JOS3Xn2aju3JittgpzdKAjRB2NzY23ocAH.jpg',
                'template_slug' => 'default', 'created_at' => '2025-05-03 18:49:37', 'updated_at' => '2025-05-03 19:06:39'
            ],
            [
                'id' => 20, 'etudiant_id' => 26, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 21:35:41', 'updated_at' => '2025-05-03 21:35:41'
            ],
            [
                'id' => 21, 'etudiant_id' => 27, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-03 22:31:30', 'updated_at' => '2025-05-03 22:31:30'
            ],
            [
                'id' => 22, 'etudiant_id' => 28, 'titre_profil' => 'Développeur Web & Mobile | À la recherche d’un stage',
                'resume_profil' => 'Développeur Web & Mobile passionné et Designer Graphique, je combine des compétences solides en programmation, design et cybersécurité pour créer des solutions numériques efficaces, esthétiques et sécurisées. J’ai une bonne maîtrise des technologies web (HTML, CSS, JavaScript, Node.js, MongoDB, mysql, php, java, wordpress) et je développe également des interfaces utilisateur attrayantes et intuitives. Je m’intéresse particulièrement à la création d’applications web dynamiques, au e-commerce, au design UI/UX et à la sécurité informatique. Je suis en recherche active d’une opportunité de stage pour renforcer mes compétences pratiques et contribuer au développement de projets innovants.',
                'adresse' => 'Rue 669b Cotonou', 'telephone_cv' => '+229 0196435810', 'email_cv' => null,
                'linkedin_url' => 'https://www.linkedin.com/in/abdias-azifan-966ab1310/', 'portfolio_url' => 'https://portfolio-web-dev1.vercel.app/',
                'situation_matrimoniale' => 'Célibataire', 'nationalite' => 'Béninoise', 'date_naissance' => '2003-12-21',
                'lieu_naissance' => 'Cotonou', 'photo_cv_path' => 'cv_photos/ecqLSxchE1eoKjB0Mx2AFXTxOIzr4LMNCgWDYVxx.jpg',
                'template_slug' => 'default', 'created_at' => '2025-05-03 23:29:58', 'updated_at' => '2025-05-03 23:55:30'
            ],
            [
                'id' => 23, 'etudiant_id' => 29, 'titre_profil' => 'CV professionnel ',
                'resume_profil' => 'Obtenir un stage professionnel pour acquérir plus d\'expérience ',
                'adresse' => 'Maison CAPO Cocotomey ', 'telephone_cv' => '0197031793', 'email_cv' => 'nicanorecapo64@gmail.com',
                'linkedin_url' => null, 'portfolio_url' => null, 'situation_matrimoniale' => 'Célibataire',
                'nationalite' => 'Beninoise ', 'date_naissance' => '1999-04-15', 'lieu_naissance' => 'Cotonou ',
                'photo_cv_path' => null, 'template_slug' => 'default', 'created_at' => '2025-05-04 07:09:48', 'updated_at' => '2025-05-04 07:17:19'
            ],
            [
                'id' => 24, 'etudiant_id' => 18, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-04 10:27:49', 'updated_at' => '2025-05-04 10:27:49'
            ],
            [
                'id' => 25, 'etudiant_id' => 31, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-04 14:48:11', 'updated_at' => '2025-05-04 14:48:11'
            ],
            [
                'id' => 26, 'etudiant_id' => 24, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-04 16:23:56', 'updated_at' => '2025-05-04 16:23:56'
            ],
            [
                'id' => 27, 'etudiant_id' => 33, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-04 21:12:14', 'updated_at' => '2025-05-04 21:12:14'
            ],
            [
                'id' => 28, 'etudiant_id' => 35, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-05 05:09:10', 'updated_at' => '2025-05-05 05:09:10'
            ],
            [
                'id' => 29, 'etudiant_id' => 37, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-05 07:45:29', 'updated_at' => '2025-05-05 07:45:29'
            ],
            [
                'id' => 30, 'etudiant_id' => 39, 'titre_profil' => 'Licence ',
                'resume_profil' => 'Licence professionnelle en Entrepreneuriat et Gestion des projets ',
                'adresse' => 'Porto Novo ', 'telephone_cv' => '62563457', 'email_cv' => 'coletteahouanvoeke516@gmail.com',
                'linkedin_url' => null, 'portfolio_url' => null, 'situation_matrimoniale' => 'Célibataire',
                'nationalite' => 'Béninoise ', 'date_naissance' => '2000-06-05', 'lieu_naissance' => 'Katagon',
                'photo_cv_path' => 'cv_photos/HDbmn7aP324cnWSQei2a17OixcfFpeyzSjVtOERA.jpg', 'template_slug' => 'default',
                'created_at' => '2025-05-05 08:22:35', 'updated_at' => '2025-05-05 08:28:44'
            ],
            [
                'id' => 31, 'etudiant_id' => 42, 'titre_profil' => 'Stagiaire en passation des marchés publics ',
                'resume_profil' => '', 'adresse' => 'Abomey-Calavi Ms KPAMEGAN', 'telephone_cv' => '+22991135847',
                'email_cv' => 'odettealaye911@gmail.com', 'linkedin_url' => null, 'portfolio_url' => null,
                'situation_matrimoniale' => 'Célibataire', 'nationalite' => 'Béninoise ', 'date_naissance' => '2002-04-20',
                'lieu_naissance' => 'Pobè ', 'photo_cv_path' => 'cv_photos/lkaoxE7s7NMuMyHTWuIWPkQ48Ad07j6iS9p1SuHd.jpg',
                'template_slug' => 'default', 'created_at' => '2025-05-05 10:15:54', 'updated_at' => '2025-05-05 10:50:08'
            ],
            [
                'id' => 32, 'etudiant_id' => 46, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-05 11:48:50', 'updated_at' => '2025-05-05 11:48:50'
            ],
            [
                'id' => 33, 'etudiant_id' => 47, 'titre_profil' => null, 'resume_profil' => null,
                'adresse' => null, 'telephone_cv' => null, 'email_cv' => null, 'linkedin_url' => null,
                'portfolio_url' => null, 'situation_matrimoniale' => null, 'nationalite' => null,
                'date_naissance' => null, 'lieu_naissance' => null, 'photo_cv_path' => null,
                'template_slug' => 'default', 'created_at' => '2025-05-05 15:00:06', 'updated_at' => '2025-05-05 15:00:06'
            ],
            [
                'id' => 34, 'etudiant_id' => 48, 'titre_profil' => 'Développeur web full stack ',
                'resume_profil' => '', 'adresse' => 'Cotonou ', 'telephone_cv' => '+2290194810780',
                'email_cv' => 'agbodjancedrik@gmail.com', 'linkedin_url' => null, 'portfolio_url' => null,
                'situation_matrimoniale' => 'Célibataire', 'nationalite' => 'Béninoise ', 'date_naissance' => '2004-09-05',
                'lieu_naissance' => 'Kpinnou', 'photo_cv_path' => null, 'template_slug' => 'default',
                'created_at' => '2025-05-05 16:59:34', 'updated_at' => '2025-05-05 17:05:55'
            ],
        ]);


        // Seed CV Competences
        DB::table('cv_competences')->insert([
            ['id' => 1, 'cv_profile_id' => 4, 'categorie' => 'Autres ', 'nom' => 'Gestion des stocks et inventaires', 'niveau' => 90, 'order' => 0, 'created_at' => '2025-05-01 07:16:36', 'updated_at' => '2025-05-01 07:16:36'],
            ['id' => 2, 'cv_profile_id' => 13, 'categorie' => 'Bonne capacité d’adaptation ', 'nom' => 'Maîtrise du logiciel Perfecto', 'niveau' => 50, 'order' => 0, 'created_at' => '2025-05-03 15:25:37', 'updated_at' => '2025-05-03 15:25:37'],
            ['id' => 3, 'cv_profile_id' => 13, 'categorie' => 'Autres', 'nom' => 'Dynamique et sociable ', 'niveau' => 50, 'order' => 0, 'created_at' => '2025-05-03 15:26:01', 'updated_at' => '2025-05-03 15:26:01'],
            ['id' => 4, 'cv_profile_id' => 16, 'categorie' => 'Autres', 'nom' => 'Maîtrise des logiciels Word Excel PowerPoint ', 'niveau' => 50, 'order' => 0, 'created_at' => '2025-05-03 16:36:43', 'updated_at' => '2025-05-03 16:36:43'],
            ['id' => 5, 'cv_profile_id' => 16, 'categorie' => 'Autres', 'nom' => 'Rigueur autonomie communication ', 'niveau' => 90, 'order' => 0, 'created_at' => '2025-05-03 16:42:49', 'updated_at' => '2025-05-03 16:42:49'],
            ['id' => 6, 'cv_profile_id' => 16, 'categorie' => 'Autres', 'nom' => 'Esprit d\'analyse ', 'niveau' => 100, 'order' => 0, 'created_at' => '2025-05-03 16:43:25', 'updated_at' => '2025-05-03 16:43:25'],
            ['id' => 7, 'cv_profile_id' => 19, 'categorie' => 'Autres', 'nom' => 'Maîtrise des logiciels comptables perfecto hypersoft et Sage 100', 'niveau' => 95, 'order' => 0, 'created_at' => '2025-05-03 19:09:20', 'updated_at' => '2025-05-03 19:09:20'],
            ['id' => 8, 'cv_profile_id' => 19, 'categorie' => 'Autres', 'nom' => 'Word', 'niveau' => 95, 'order' => 0, 'created_at' => '2025-05-03 19:13:07', 'updated_at' => '2025-05-03 19:13:07'],
            ['id' => 9, 'cv_profile_id' => 19, 'categorie' => 'Autres', 'nom' => 'Excel ', 'niveau' => 75, 'order' => 0, 'created_at' => '2025-05-03 19:13:58', 'updated_at' => '2025-05-03 19:13:58'],
            ['id' => 10, 'cv_profile_id' => 22, 'categorie' => 'Bases de données', 'nom' => 'très bien', 'niveau' => 50, 'order' => 0, 'created_at' => '2025-05-03 23:48:08', 'updated_at' => '2025-05-03 23:48:08'],
            ['id' => 11, 'cv_profile_id' => 22, 'categorie' => 'Maintenance informatique', 'nom' => 'bien', 'niveau' => 50, 'order' => 0, 'created_at' => '2025-05-03 23:48:28', 'updated_at' => '2025-05-03 23:48:28'],
            ['id' => 12, 'cv_profile_id' => 22, 'categorie' => 'designer graphique', 'nom' => 'bien', 'niveau' => 50, 'order' => 0, 'created_at' => '2025-05-03 23:49:10', 'updated_at' => '2025-05-03 23:49:10'],
            ['id' => 13, 'cv_profile_id' => 17, 'categorie' => 'Autres', 'nom' => 'Maîtrise de l\'outil informatique (Word, Excel et PowerPoint)', 'niveau' => 60, 'order' => 0, 'created_at' => '2025-05-04 06:07:35', 'updated_at' => '2025-05-04 06:07:35'],
            ['id' => 14, 'cv_profile_id' => 17, 'categorie' => 'Autres', 'nom' => 'La polyvalence', 'niveau' => 100, 'order' => 0, 'created_at' => '2025-05-05 05:52:50', 'updated_at' => '2025-05-05 05:52:50'],
            ['id' => 15, 'cv_profile_id' => 17, 'categorie' => 'Autres', 'nom' => 'Sens de l\'organisation', 'niveau' => 0, 'order' => 0, 'created_at' => '2025-05-05 05:53:56', 'updated_at' => '2025-05-05 05:53:56'],
        ]);

        // Seed CV Experiences
        DB::table('cv_experiences')->insert([
           ['id' => 1, 'cv_profile_id' => 13, 'poste' => 'Stagiaire ', 'entreprise' => 'ANSSFD ( Agence Nationale de Surveillance des Systèmes Financiers Décentralisés)', 'ville' => 'Cotonou', 'date_debut' => '2024-04-01', 'date_fin' => '2024-07-01', 'description' => '', 'tache_1' => '', 'tache_2' => '', 'tache_3' => '', 'order' => 0, 'created_at' => '2025-05-03 15:22:31', 'updated_at' => '2025-05-03 15:22:31'],
           ['id' => 2, 'cv_profile_id' => 19, 'poste' => 'Stagiaire Comptable ', 'entreprise' => 'Cabinet AGM & PARTNERS', 'ville' => 'Cotonou ', 'date_debut' => '2024-09-01', 'date_fin' => '2024-11-01', 'description' => "Stagiaire Comptable \n", 'tache_1' => 'Classement des pièces comptables ', 'tache_2' => 'Saisie des écritures comptables dans le logiciel perfecto ', 'tache_3' => 'Rapprochement bancaire ', 'order' => 0, 'created_at' => '2025-05-03 19:08:24', 'updated_at' => '2025-05-03 19:08:24'],
           ['id' => 3, 'cv_profile_id' => 17, 'poste' => 'Stagiaire en ressources humaines ', 'entreprise' => 'Mairie de Sèmè-Podji', 'ville' => 'Cotonou ', 'date_debut' => '2023-03-01', 'date_fin' => '2023-06-01', 'description' => 'Contribuer à la gestion des dossiers employés en veillant à ce que toutes les informations soient à jour et conformes', 'tache_1' => 'Aider à la réalisation des enquêtes de satisfaction des employés pour améliorer l\'environnement de travail.', 'tache_2' => '', 'tache_3' => '', 'order' => 0, 'created_at' => '2025-05-04 06:06:16', 'updated_at' => '2025-05-04 06:06:16'],
           ['id' => 4, 'cv_profile_id' => 17, 'poste' => 'Conseiller clientèle ', 'entreprise' => 'Aura Consulting ', 'ville' => 'Agla, Cotonou ', 'date_debut' => '2024-03-01', 'date_fin' => '2024-06-01', 'description' => 'Le Conseiller clientèle est celui qui, au sein d\'une entreprise, est responsable des relations avec les utilisateurs/les clients.', 'tache_1' => 'Analyser les besoins des clients et proposer des produits/services adaptés.', 'tache_2' => 'Établir des relations solides avec les clients pour favoriser leur fidélité.', 'tache_3' => '', 'order' => 0, 'created_at' => '2025-05-04 06:14:42', 'updated_at' => '2025-05-04 06:14:42'],
           ['id' => 5, 'cv_profile_id' => 31, 'poste' => 'Secrétaire Assistante en marchés publics ', 'entreprise' => 'Le Bienfaiteur SARL ', 'ville' => 'Cotonou ', 'date_debut' => '2024-09-01', 'date_fin' => '2025-01-01', 'description' => '', 'tache_1' => 'Montage des dossiers d\'appel d\'offres ', 'tache_2' => 'Soumission aux dossiers ', 'tache_3' => 'Suivi de la procédure de passation ', 'order' => 0, 'created_at' => '2025-05-05 10:31:06', 'updated_at' => '2025-05-05 10:31:06'],
           ['id' => 6, 'cv_profile_id' => 31, 'poste' => 'Stagiaire en passation des marchés publics ', 'entreprise' => 'ATDA Plateau ', 'ville' => 'Pobè ', 'date_debut' => '2024-02-01', 'date_fin' => '2024-08-01', 'description' => '', 'tache_1' => 'Aide aux montagnes des DAO', 'tache_2' => 'Aide à l\'ouverture et à l\'évaluation des offres', 'tache_3' => 'Rédaction des rapports', 'order' => 0, 'created_at' => '2025-05-05 10:34:17', 'updated_at' => '2025-05-05 10:34:17'],
           ['id' => 7, 'cv_profile_id' => 31, 'poste' => 'Stagiaire ', 'entreprise' => 'Préfecture du plateau ', 'ville' => 'Pobè ', 'date_debut' => '2023-04-01', 'date_fin' => '2023-06-01', 'description' => '', 'tache_1' => '', 'tache_2' => '', 'tache_3' => '', 'order' => 0, 'created_at' => '2025-05-05 10:35:59', 'updated_at' => '2025-05-05 10:35:59'],
           ['id' => 8, 'cv_profile_id' => 31, 'poste' => 'Rédactrice web ', 'entreprise' => 'Web Action ', 'ville' => 'Abomey Calavi ', 'date_debut' => '2020-01-01', 'date_fin' => '2023-10-01', 'description' => '', 'tache_1' => '', 'tache_2' => '', 'tache_3' => '', 'order' => 0, 'created_at' => '2025-05-05 10:37:13', 'updated_at' => '2025-05-05 10:37:13'],
        ]);

        // Seed CV Formations
        DB::table('cv_formations')->insert([
           ['id' => 1, 'cv_profile_id' => 13, 'diplome' => 'Licence professionnelle en Gestion Financière et Comptable ', 'etablissement' => 'ENEAM ( École Nationale d’Economie Appliquée et de Management)', 'ville' => 'Cotonou ', 'annee_debut' => 2021, 'annee_fin' => 2024, 'description' => '', 'order' => 0, 'created_at' => '2025-05-03 15:18:32', 'updated_at' => '2025-05-03 15:18:32'],
           ['id' => 2, 'cv_profile_id' => 15, 'diplome' => 'Bac C', 'etablissement' => 'CEG1 Sakété ', 'ville' => 'Sakété ', 'annee_debut' => 2018, 'annee_fin' => 2021, 'description' => '', 'order' => 0, 'created_at' => '2025-05-03 15:36:40', 'updated_at' => '2025-05-03 15:36:40'],
           ['id' => 3, 'cv_profile_id' => 15, 'diplome' => 'BAPET/Licence professionnelle ', 'etablissement' => 'ENSET-Lokossa', 'ville' => 'Lokossa ', 'annee_debut' => 2021, 'annee_fin' => 2024, 'description' => '', 'order' => 0, 'created_at' => '2025-05-03 15:37:47', 'updated_at' => '2025-05-03 15:37:47'],
           ['id' => 4, 'cv_profile_id' => 22, 'diplome' => 'DWM 1ere et 2eme anné', 'etablissement' => 'lycée technique et professionnel de Bopa', 'ville' => 'Possotomê', 'annee_debut' => 2021, 'annee_fin' => 2022, 'description' => 'programmation de site web et application mobile ', 'order' => 0, 'created_at' => '2025-05-03 23:42:26', 'updated_at' => '2025-05-03 23:42:26'],
           ['id' => 5, 'cv_profile_id' => 22, 'diplome' => 'formation DCLIC organisé par l\'OIF en en programmation web', 'etablissement' => 'Bougelabs', 'ville' => 'Ouidah', 'annee_debut' => 2024, 'annee_fin' => 2024, 'description' => 'programmation web', 'order' => 0, 'created_at' => '2025-05-03 23:44:30', 'updated_at' => '2025-05-03 23:44:30'],
           ['id' => 6, 'cv_profile_id' => 22, 'diplome' => 'formation en entrepreneuriat', 'etablissement' => 'Mairie de ouidah', 'ville' => 'Ouidah', 'annee_debut' => 2025, 'annee_fin' => null, 'description' => 'l\'éveil en intelligence financière et Déclic entrepreneurial', 'order' => 0, 'created_at' => '2025-05-03 23:46:36', 'updated_at' => '2025-05-03 23:46:36'],
           ['id' => 7, 'cv_profile_id' => 17, 'diplome' => 'Licence en gestion des ressources humaines ', 'etablissement' => 'Hecm ', 'ville' => 'Cotonou ', 'annee_debut' => 2020, 'annee_fin' => 2023, 'description' => '', 'order' => 0, 'created_at' => '2025-05-04 06:03:01', 'updated_at' => '2025-05-04 06:03:01'],
           ['id' => 8, 'cv_profile_id' => 17, 'diplome' => 'Formation en conseiller clientèle ', 'etablissement' => 'GNA conseil ', 'ville' => 'Abomey Calavi ', 'annee_debut' => 2024, 'annee_fin' => 2024, 'description' => '', 'order' => 0, 'created_at' => '2025-05-04 06:10:30', 'updated_at' => '2025-05-04 06:10:30'],
           ['id' => 9, 'cv_profile_id' => 17, 'diplome' => 'Baccalauréat ', 'etablissement' => 'CEG 1 EKPE', 'ville' => 'Sèmè-Podji ', 'annee_debut' => 2019, 'annee_fin' => 2020, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 06:07:03', 'updated_at' => '2025-05-05 06:07:03'],
           ['id' => 10, 'cv_profile_id' => 31, 'diplome' => 'Licence en Droit privé ', 'etablissement' => 'Université d\'Abomey Calavi ', 'ville' => 'Abomey Calavi ', 'annee_debut' => 2019, 'annee_fin' => 2023, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:23:13', 'updated_at' => '2025-05-05 10:23:13'],
           ['id' => 11, 'cv_profile_id' => 31, 'diplome' => 'Formation en anglais communicationnel ', 'etablissement' => 'TBC Bénin ', 'ville' => 'Cotonou ', 'annee_debut' => 2023, 'annee_fin' => 2023, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:24:08', 'updated_at' => '2025-05-05 10:24:08'],
           ['id' => 12, 'cv_profile_id' => 31, 'diplome' => 'Formation en rédaction web ', 'etablissement' => 'Web Action', 'ville' => 'Abomey Calavi ', 'annee_debut' => 2020, 'annee_fin' => 2021, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:25:02', 'updated_at' => '2025-05-05 10:25:02'],
           ['id' => 13, 'cv_profile_id' => 31, 'diplome' => 'Baccalauréat D', 'etablissement' => 'Collège d\'enseignement général 2 de pobè ', 'ville' => 'Pobè ', 'annee_debut' => 2018, 'annee_fin' => 2019, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:26:07', 'updated_at' => '2025-05-05 10:26:07'],
           ['id' => 14, 'cv_profile_id' => 31, 'diplome' => 'BEPC ', 'etablissement' => 'Collège catholique sainte Claire de pobè ', 'ville' => 'Pobè ', 'annee_debut' => 2015, 'annee_fin' => 2016, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:26:53', 'updated_at' => '2025-05-05 10:26:53'],
           ['id' => 15, 'cv_profile_id' => 31, 'diplome' => 'CEP', 'etablissement' => 'École catholique sainte Claire ', 'ville' => 'Pobè ', 'annee_debut' => 2011, 'annee_fin' => 2012, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:27:50', 'updated_at' => '2025-05-05 10:27:50'],
           ['id' => 16, 'cv_profile_id' => 31, 'diplome' => 'Formation en informatique ', 'etablissement' => 'INNO SPACE', 'ville' => 'Cotonou', 'annee_debut' => 2020, 'annee_fin' => 2020, 'description' => '', 'order' => 0, 'created_at' => '2025-05-05 10:38:17', 'updated_at' => '2025-05-05 10:38:17'],
        ]);

        // Seed CV Langues
        DB::table('cv_langues')->insert([
             ['id' => 1, 'cv_profile_id' => 4, 'langue' => 'François ', 'niveau' => 'Natif', 'order' => 0, 'created_at' => '2025-05-01 07:19:04', 'updated_at' => '2025-05-01 07:19:04'],
             ['id' => 2, 'cv_profile_id' => 16, 'langue' => 'Français ', 'niveau' => 'Courant', 'order' => 0, 'created_at' => '2025-05-03 16:39:57', 'updated_at' => '2025-05-03 16:39:57'],
             ['id' => 3, 'cv_profile_id' => 16, 'langue' => 'Anglais ', 'niveau' => 'Intermédiaire', 'order' => 0, 'created_at' => '2025-05-03 16:40:19', 'updated_at' => '2025-05-03 16:40:19'],
             ['id' => 4, 'cv_profile_id' => 22, 'langue' => 'français', 'niveau' => 'Courant', 'order' => 0, 'created_at' => '2025-05-03 23:50:16', 'updated_at' => '2025-05-03 23:50:16'],
             ['id' => 5, 'cv_profile_id' => 22, 'langue' => 'Anglais', 'niveau' => 'Débutant', 'order' => 0, 'created_at' => '2025-05-03 23:50:45', 'updated_at' => '2025-05-03 23:50:45'],
             ['id' => 6, 'cv_profile_id' => 17, 'langue' => 'Anglais ', 'niveau' => 'Débutant', 'order' => 0, 'created_at' => '2025-05-04 06:07:57', 'updated_at' => '2025-05-04 06:07:57'],
             ['id' => 7, 'cv_profile_id' => 17, 'langue' => 'Français ', 'niveau' => 'Natif', 'order' => 0, 'created_at' => '2025-05-04 06:08:21', 'updated_at' => '2025-05-04 06:08:21'],
             ['id' => 9, 'cv_profile_id' => 31, 'langue' => 'Anglais ', 'niveau' => 'Intermédiaire', 'order' => 0, 'created_at' => '2025-05-05 10:40:13', 'updated_at' => '2025-05-05 10:40:13'],
             ['id' => 10, 'cv_profile_id' => 31, 'langue' => 'Français ', 'niveau' => 'Natif', 'order' => 0, 'created_at' => '2025-05-05 10:40:34', 'updated_at' => '2025-05-05 10:51:32'],
             ['id' => 11, 'cv_profile_id' => 31, 'langue' => 'Nago/ Yoruba ', 'niveau' => 'Natif', 'order' => 0, 'created_at' => '2025-05-05 10:40:59', 'updated_at' => '2025-05-05 10:40:59'],
             ['id' => 12, 'cv_profile_id' => 31, 'langue' => 'Fon', 'niveau' => 'Débutant', 'order' => 0, 'created_at' => '2025-05-05 10:41:25', 'updated_at' => '2025-05-05 10:41:25'],
        ]);

        // Seed Catalogues
        DB::table('catalogues')->insert([
             [
                'id' => 1, 'titre' => 'EBENI EVENTS', 'secteur_activite' => 'Tourisme et loisirs (hôtellerie, restauration, évènementiel)',
                'description' => 'Plongez dans une expérience d\'événementiel empreinte de bien-être et de principes avec Aebeni Events. Nous vous offrons bien plus qu\'une simple célébration ; nous vous offrons une expérience qui enrichit votre âme tout en respectant notre planète. Faites confiance à notre équipe dévouée pour créer un événement qui vous ressemble.',
                'logo' => 'logo_6801261a857990.29319086.jpeg', 'localisation' => 'Bénin/AIBATIN DU COTE DE LA BANQUE NSIA', 'nb_activites' => 1,
                'activite_principale' => 'DECORATION ET EVENEMENT',
                'desc_activite_principale' => 'Aebeni Events est bien plus qu’une simple entreprise d’organisation d’événements ; c’est une véritable incarnation des valeurs de bien-être et de principes. Nous nous engageons à créer des expériences uniques et mémorables, en mettant l’accent sur le bien-être de nos clients et sur le respect de principes éthiques et durables dans tout ce que nous faisons.\n\nDans le cadre de nos services d’événementiel, nous nous efforçons de créer des expériences qui nourrissent l’âme et l’esprit. Que ce soit pour un mariage, une fête d’anniversaire, un événement d’entreprise ou toute autre occasion spéciale, notre équipe dévouée travaille en étroite collaboration avec nos clients pour donner vie à leur vision, en veillant à ce que chaque détail soit parfaitement orchestré.\n\nEn tant qu’entreprise axée sur les principes, nous attachons une grande importance à la durabilité environnementale et sociale dans toutes nos opérations. Nous travaillons avec des fournisseurs et des partenaires partageant les mêmes valeurs, privilégiant les produits locaux, durables et éthiques chaque fois que possible. De plus, nous nous efforçons de minimiser notre empreinte écologique en adoptant des pratiques respectueuses de l’environnement tout au long de notre processus de planification et d’exécution des événements.\n\nChez Aebeni Events, nous croyons que le bien-être de nos clients et de notre planète est étroitement lié. C’est pourquoi nous nous engageons à créer des événements qui non seulement enchantent les sens, mais qui aussi nourrissent l’âme et préservent notre précieuse planète pour les générations futures.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => 'bg_6801261a868385.19543804.jpg', 'status' => 0, 'is_blocked' => 0, 'created_at' => '2024-02-13 14:02:34', 'updated_at' => '2025-04-17 14:02:34'
             ],
             [
                'id' => 2, 'titre' => 'SMT', 'secteur_activite' => 'Industrie (manufacture, textile, automobile, chimie)',
                'description' => 'SMT, votre commissionnaire d\'engins de chantier dédié à simplifier vos opérations de construction. Notre entreprise est spécialisée dans la location et la gestion logistique d\'engins de chantier de haute qualité. Chez SMT, chaque machine est entretenue avec soin, chaque client bénéficie d\'un service personnalisé, et chaque projet de construction est.',
                'logo' => 'logo_6807559a0c66a4.20937480.jpg', 'localisation' => 'Bénin/GODOMEY', 'nb_activites' => 1,
                'activite_principale' => 'COMMISSIONNAIRE D ’ENGAINS DE CHANTIER',
                'desc_activite_principale' => 'Optimisez votre chantier avec SMT, où la fiabilité des engins rencontre une gestion logistique efficace. Nous ne sommes pas simplement des commissionnaires d’engins, nous sommes vos partenaires pour la réussite de vos projets de construction. Choisissez la performance et la flexibilité en optant pour nos services. Chez SMT, chaque client est un partenaire de construction, chaque engin est un atout pour votre chantier, chaque interaction est une collaboration pour la réussite. Faites équipe avec nous pour des opérations de chantier fluides et efficaces.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => 'bg_6807559a0cd631.97668463.jpg', 'status' => 0, 'is_blocked' => 0, 'created_at' => '2024-01-26 06:38:50', 'updated_at' => '2025-04-22 06:38:50'
            ],
            [
                'id' => 3, 'titre' => 'CONSODATE SARL', 'secteur_activite' => 'Commerce et distribution (boutiques, supermarchés, import-export)',
                'description' => 'CONSODATE SARL, votre partenaire de confiance en quincaillerie générale. Notre entreprise est dédiée à fournir des solutions complètes pour vos besoins en matériaux de construction, outillage, et équipements domestiques. Chez CONSODATE SARL, chaque produit est sélectionné pour sa qualité, chaque client est accueilli avec professionnalisme, et chaque visite est une.',
                'logo' => 'logo_68076de3b60369.85970082.jpg', 'localisation' => 'Bénin/GODOMEY', 'nb_activites' => 1,
                'activite_principale' => 'QUINCAILLERIE GENERALE',
                'desc_activite_principale' => 'Découvrez la praticité et la qualité chez CONSODATE SARL. Nous ne sommes pas simplement une quincaillerie générale, nous sommes les facilitateurs de vos projets de construction et de rénovation. Optez pour la fiabilité et la diversité en choisissant nos produits. Chez CONSODATE SARL, chaque client est un bâtisseur en puissance, chaque produit est un composant essentiel, chaque visite est une étape vers la concrétisation de vos projets. Faites équipe avec nous pour une quincaillerie complète et efficace.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => 'bg_68076de3b67ea4.18308973.jpeg', 'status' => 0, 'is_blocked' => 0, 'created_at' => '2024-01-26 08:22:27', 'updated_at' => '2025-04-22 08:22:27'
            ],
            [
                'id' => 4, 'titre' => 'ZMC SARL', 'secteur_activite' => 'Tourisme et loisirs (hôtellerie, restauration, évènementiel)',
                'description' => 'Explorez le concept novateur de ZMC SARL, où l\'art de la cuisine et de la coiffure fusionnent harmonieusement. Nous ne sommes pas simplement un bar restaurant-coiffure, nous sommes les créateurs de moments uniques. Optez pour la polyvalence et le raffinement en choisissant nos services. Chez ZMC SARL, chaque client est.',
                'logo' => 'logo_68076ed2eba9e1.82845545.jpeg', 'localisation' => 'Bénin/AIBATIN DU COTE DE LA BANQUE NSIA', 'nb_activites' => 1, // Note: Old dump says 1, but has primary+secondary
                'activite_principale' => 'BAR RESTAURANT',
                'desc_activite_principale' => 'Découvrez le mélange parfait de saveurs et d’atmosphère chez ZMC SARL. Nous ne sommes pas simplement un bar restaurant, nous sommes les artisans de moments mémorables. Optez pour la gourmandise et l’ambiance en choisissant nos services. Chez [Nom de l’entreprise], chaque client est un convive privilégié, chaque plat est une explosion de goûts, chaque soirée est une expérience à savourer. Faites équipe avec nous pour des instants culinaires inoubliables.',
                'activite_secondaire' => 'COIFFURE',
                'desc_activite_secondaire' => 'Notre salon de coiffure est un lieu dédié à la transformation et à l’embellissement de vos cheveux. Nos coiffeurs talentueux sont passionnés par la création de styles uniques qui reflètent votre personnalité. Chez ZMC SARL, chaque visite est une expérience de détente et de relooking, chaque coupe est réalisée avec précision pour mettre en valeur votre beauté naturelle.',
                'autres' => null, 'image' => 'bg_68076ed2ec3179.81055908.jpeg', 'status' => 1, 'is_blocked' => 0, 'created_at' => '2024-01-26 08:26:27', 'updated_at' => '2025-04-22 08:26:27'
            ],
             [
                'id' => 5, 'titre' => 'VOLCAN SECURITE', 'secteur_activite' => 'Services aux entreprises (consulting, marketing, sécurité)',
                'description' => 'VOLCAN SECURITE, votre partenaire de confiance dans le domaine du gardiennage et de la sécurité. Nous nous engageons à assurer la protection de vos biens et la sécurité de vos espaces. Chez VOLCAN SECURITE, chaque agent est formé pour répondre aux normes les plus élevées de professionnalisme et d\'efficacité.',
                'logo' => 'logo_68077533a67394.00391747.jpg', 'localisation' => 'Bénin/...', 'nb_activites' => 1,
                'activite_principale' => 'SOCIETE DE GARDIENAGE ET DE SECURITE',
                'desc_activite_principale' => 'Sécurisez vos espaces avec VOLCAN SECURITE. Nous ne sommes pas simplement une société de gardiennage, nous sommes les gardiens dévoués de votre tranquillité d’esprit. Optez pour la sûreté et la fiabilité en choisissant nos services. Chez VOLCAN SECURITE, chaque client est un partenaire de confiance, chaque agent est un protecteur vigilant, chaque mission est une garantie de sécurité. Faites équipe avec nous pour une protection sans compromis.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => 'bg_68077533a6f8c7.48748911.jpg', 'status' => 0, 'is_blocked' => 0, 'created_at' => '2024-01-26 08:53:39', 'updated_at' => '2025-04-22 08:53:39'
             ],
             [
                'id' => 6, 'titre' => 'SHALOM EMPIRE', 'secteur_activite' => 'Technologie et numérique (informatique, télécommunications, intelligence artificielle)',
                'description' => 'Créez avec précision et style avec SHALOM EMPIRE. Nous ne sommes pas simplement une imprimerie et une sérigraphie, nous sommes les artistes qui transforment vos concepts en réalité visuelle. Optez pour l\'excellence et la créativité en choisissant nos services. Chez SHALOM EMPIRE, chaque client est un collaborateur créatif, chaque impression.',
                'logo' => null, 'localisation' => 'Bénin/CARREFOUR ADJAHA', 'nb_activites' => 1, // Note: Old dump says 1, but has primary+secondary+autres
                'activite_principale' => 'IMPRIMERIE ET SERIGRAPHIE',
                'desc_activite_principale' => 'Bienvenue chez SHALOM EMPIRE, votre partenaire de confiance pour l’imprimerie et la sérigraphie. Nous sommes dévoués à donner vie à vos idées à travers des impressions de qualité exceptionnelle et des créations sérigraphiques uniques. Chez SHALOM EMPIRE, chaque projet est traité avec précision, créativité et un engagement total envers la satisfaction de nos clients.',
                'activite_secondaire' => 'icivp',
                'desc_activite_secondaire' => "Si vous ne souhaitez plus recevoir ces e-mails de la part de Meta, veuillez vous désabonner.\nMeta Platforms, Inc., Attention: Community Support, 1 Meta Way, Menlo Park, CA 94025\n   \n   \nPour contribuer à la protection de votre compte, veuillez ne pas transférer cet e-mail. En savoir plus",
                'autres' => "Si vous ne souhaitez plus recevoir ces e-mails de la part de Meta, veuillez vous désabonner.\nMeta Platforms, Inc., Attention: Community Support, 1 Meta Way, Menlo Park, CA 94025\n   \n   \nPour contribuer à la protection de votre compte, veuillez ne pas transférer cet e-mail. En savoir plus",
                'image' => null, 'status' => 1, 'is_blocked' => 0, 'created_at' => '2025-04-23 08:56:06', 'updated_at' => '2025-04-23 08:56:06'
             ],
             [
                'id' => 7, 'titre' => 'ANGO FASHION', 'secteur_activite' => 'Commerce et distribution (boutiques, supermarchés, import-export)',
                'description' => 'Exprimez votre style avec ANGO FASHION. Nous ne sommes pas simplement un magasin de prêt-à-porter, nous sommes les créateurs de vos looks préférés. Optez pour la mode et l\'originalité en choisissant nos collections. Chez ANGO FASHION, chaque client est un passionné de la mode, chaque vêtement est une pièce.',
                'logo' => null, 'localisation' => 'Bénin/AIBATIN DU COTE DE LA BANQUE NSIA', 'nb_activites' => 1,
                'activite_principale' => 'PRET A PORTER',
                'desc_activite_principale' => 'Bienvenue chez ANGO FASHION, votre destination de prêt-à-porter tendance et stylé. Nous sommes dédiés à vous offrir des collections élégantes qui reflètent les dernières tendances de la mode. Chez ANGO FASHION, chaque vêtement est soigneusement sélectionné pour vous offrir confort et style, mettant en avant votre personnalité unique.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => null, 'status' => 0, 'is_blocked' => 0, 'created_at' => '2025-04-23 09:00:06', 'updated_at' => '2025-04-23 09:00:06'
             ],
             [
                'id' => 8, 'titre' => 'FLASH INFO MEDIA', 'secteur_activite' => 'Technologie et numérique (informatique, télécommunications, intelligence artificielle)',
                'description' => 'Restez informé avec FLASH INFO MEDIA. Nous ne sommes pas simplement un média d\'information, nous sommes vos yeux sur le monde en temps réel. Optez pour la rapidité et la fiabilité en choisissant nos services. Chez FLASH INFO MEDIA, chaque lecteur est un chercheur de vérité, chaque article est une.',
                'logo' => null, 'localisation' => 'Bénin/GODOMEY', 'nb_activites' => 1,
                'activite_principale' => 'PRESSE',
                'desc_activite_principale' => 'Bienvenue chez FLASH INFO MEDIA, votre source d’informations rapide et fiable. Nous sommes une entreprise dédiée à fournir des nouvelles pertinentes, des reportages approfondis et une couverture médiatique de qualité. Chez FLASH INFO MEDIA, chaque actualité est traitée avec professionnalisme, apportant à nos lecteurs une perspective éclairée sur les événements du monde.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => null, 'status' => 0, 'is_blocked' => 0, 'created_at' => '2025-04-23 09:02:25', 'updated_at' => '2025-04-23 09:02:25'
             ],
             [
                'id' => 9, 'titre' => 'LABO GETMA', 'secteur_activite' => 'Technologie et numérique (informatique, télécommunications, intelligence artificielle)',
                'description' => 'Donnez vie à vos souvenirs avec LABO GETMA. Nous ne sommes pas simplement un service de traitement de photos et de tirage, nous sommes les artistes qui transforment vos moments en œuvres d\'art tangibles. Optez pour la qualité et la personnalisation en choisissant nos services. Chez LABO GETMA, chaque photo.',
                'logo' => null, 'localisation' => 'Bénin/GODOMEY', 'nb_activites' => 1,
                'activite_principale' => 'TRAITEMENT DE PHOTO ET TIRAGE',
                'desc_activite_principale' => 'Bienvenue chez LABO GETMA, votre laboratoire de confiance pour le traitement de photos et le tirage de qualité exceptionnelle. Nous nous engageons à donner vie à vos moments capturés avec une attention méticuleuse aux détails. Chez LABO GETMA, chaque image est traitée avec soin, et chaque tirage est une manifestation artistique de vos souvenirs.',
                'activite_secondaire' => null, 'desc_activite_secondaire' => null, 'autres' => null,
                'image' => null, 'status' => 0, 'is_blocked' => 0, 'created_at' => '2025-04-23 09:06:46', 'updated_at' => '2025-04-23 09:06:46'
             ],
        ]);

        // Seed Conversations
        DB::table('conversations')->insert([
            ['id' => 1, 'name' => null, 'is_group' => 0, 'created_at' => '2025-04-30 18:24:11', 'updated_at' => '2025-04-30 18:24:35'],
        ]);

        // Seed Conversation Participants
        DB::table('conversation_participants')->insert([
             ['id' => 1, 'conversation_id' => 1, 'user_id' => 2, 'last_read' => null, 'created_at' => '2025-04-30 18:24:11', 'updated_at' => '2025-04-30 18:24:11'],
             ['id' => 2, 'conversation_id' => 1, 'user_id' => 3, 'last_read' => '2025-04-30 18:24:35', 'created_at' => '2025-04-30 18:24:11', 'updated_at' => '2025-04-30 18:24:35'],
        ]);

        // Seed Messages
        DB::table('messages')->insert([
             ['id' => 1, 'conversation_id' => 1, 'user_id' => 3, 'body' => 'Bonjour ', 'type' => 'text', 'is_read' => 0, 'created_at' => '2025-04-30 18:24:11', 'updated_at' => '2025-04-30 18:24:11', 'deleted_at' => null],
             ['id' => 2, 'conversation_id' => 1, 'user_id' => 3, 'body' => 'Salut ', 'type' => 'text', 'is_read' => 0, 'created_at' => '2025-04-30 18:24:35', 'updated_at' => '2025-04-30 18:24:35', 'deleted_at' => null],
        ]);


        // Seed Events (Adaptation needed)
        DB::table('events')->insert([
             [
                'id' => 2, 'user_id' => 1, 'title' => 'SPECTACLE DE DANSE HORIZON',
                'description' => 'Le spectacle de lancement de l’Académie 3A, prévu pour le 17 mai 2025 à 18h à l’Espace Mayton de Zogbadjè, s’annonce comme un moment exceptionnel de valorisation de la culture béninoise à travers la danse. \r\nPlacé sous le thème « La danse, vecteur d’inclusion – un Pas vers l’Autre », cet événement rassemblera danses traditionnelles et modernes, avec un focus particulier sur la danse Achikpé, véritable joyau du patrimoine local. \r\nÀ travers cette soirée artistique, l’Académie 3A dévoilera aussi son programme de formation en musique, danse et ingénierie de son destiné aux enfants, jeunes et adultes.\r\n\r\nDes tickets de soutien sont disponibles pour celles et ceux qui souhaitent encourager cette initiative culturelle. Nous lançons également un appel aux sponsors et partenaires désireux d’accompagner ce projet porteur de valeurs, de talents et d’avenir.',
                'start_date' => '2025-05-17 18:00:00', 'end_date' => '2025-05-17 22:30:00', 'location' => 'ESPACE MAYTON DE ZOGBADJE',
                'type' => 'Autre', 'max_participants' => 300, 'image' => '1746138597.jpeg',
                'created_at' => '2025-05-01 22:29:57', 'updated_at' => '2025-05-01 22:30:23', 'is_published' => 1,
                'first_name' => null, 'last_name' => null, 'phone_number' => null, 'email' => null
             ],
             [
                'id' => 3, 'user_id' => 1, 'title' => 'LANCEMENTOFFICIEL DU PROGRMME D\'ACOMPAGNEMENT ET DE STAGE PROFESSIONNEL',
                'description' => '🎉 LANCEMENT OFFICIEL DES CANDIDATURES AU PROGRAMME PAPS🎉\r\nVous êtes étudiant(e) ou jeune diplômé(e) à la recherche d’un stage professionnel encadré ? \r\n\r\nVoici votre opportunité !\r\n\r\nSTAGESBENIN, entreprise du Groupe FHC, lance du Programme d’Accompagnement Professionnel et de Stage (PAPS)\r\n\r\n🎯 Objectif : Placer 1500 jeunes en stage dans 500 entreprises partenaires sur tout le territoire national pendant 6 mois.\r\n\r\n✅ Vous bénéficierez :\r\n\r\n🔹 D’un stage encadré dans une entreprise sérieuse\r\n\r\n🔹 D’un accompagnement professionnel (coaching, suivi, ateliers)\r\n\r\n🔹 D’un accès à un réseau dynamique d’opportunités',
                'start_date' => '2025-05-03 15:00:00', 'end_date' => '2025-06-05 17:59:00', 'location' => 'EN LIGNE',
                'type' => 'Networking', 'max_participants' => 1500, 'image' => '1746281343.jpg',
                'created_at' => '2025-05-03 14:09:03', 'updated_at' => '2025-05-03 14:11:14', 'is_published' => 1,
                'first_name' => null, 'last_name' => null, 'phone_number' => null, 'email' => null
             ],
        ]);

        // Seed Examens
        DB::table('examens')->insert([
             ['id' => 1, 'etudiant_id' => 17, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-03 15:32:14', 'updated_at' => '2025-05-03 15:32:14'],
             ['id' => 2, 'etudiant_id' => 16, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-03 15:41:38', 'updated_at' => '2025-05-03 15:41:38'],
             ['id' => 3, 'etudiant_id' => 16, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-03 15:41:59', 'updated_at' => '2025-05-03 15:41:59'],
             ['id' => 4, 'etudiant_id' => 28, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-03 23:56:28', 'updated_at' => '2025-05-03 23:56:28'],
             ['id' => 5, 'etudiant_id' => 28, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-03 23:58:02', 'updated_at' => '2025-05-03 23:58:02'],
             ['id' => 6, 'etudiant_id' => 30, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-04 09:28:49', 'updated_at' => '2025-05-04 09:28:49'],
             ['id' => 7, 'etudiant_id' => 17, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-05 06:09:26', 'updated_at' => '2025-05-05 06:09:26'],
             ['id' => 8, 'etudiant_id' => 37, 'user_id' => null, 'score' => 0, 'total_questions' => 0, 'created_at' => '2025-05-05 07:48:05', 'updated_at' => '2025-05-05 07:48:05'],
        ]);

        // Seed Tier (Adaptation needed)
         DB::table('tier')->insert([
             [
                 'id' => 1, 'user_id' => 3, 'title' => 'Boost 2000',
                 'description' => 'Visibilité basique pour votre profil', 'price' => 2000.00,
                 'duration' => 1, 'visibility_level' => 2, // Casted from '2'
                 'extra_features' => json_encode(["Accès à 2 entreprises ciblées","Visibilité dans 2 secteurs d'activité","Prix abordable pour débuter","Parfait pour les premières expériences"]), // Properly encode JSON
                 'transaction_id' => 'txn_681667bbd4cc9', 'payment_status' => 'paid',
                 'payment_date' => '2025-05-03 19:00:11', 'is_purchasable' => 1,
                 'created_at' => '2025-05-03 19:00:11', 'updated_at' => '2025-05-03 19:00:11'
             ],
             [
                 'id' => 7, 'user_id' => 3, 'title' => 'Boost 2000',
                 'description' => 'Visibilité basique pour votre profil', 'price' => 2000.00,
                 'duration' => 1, 'visibility_level' => 2,
                 'extra_features' => json_encode(["Accès à 2 entreprises ciblées","Visibilité dans 2 secteurs d'activité","Prix abordable pour débuter","Parfait pour les premières expériences"]),
                 'transaction_id' => 'txn_6816901a67f28', 'payment_status' => 'pending',
                 'payment_date' => '2025-05-03 21:52:26', // Original was null, using created_at based on SQL comment
                 'is_purchasable' => 1, 'created_at' => '2025-05-03 21:52:26', 'updated_at' => '2025-05-03 21:52:26'
             ],
              [
                 'id' => 8, 'user_id' => 3, 'title' => 'Boost 2000',
                 'description' => 'Visibilité basique pour votre profil', 'price' => 2000.00,
                 'duration' => 1, 'visibility_level' => 2,
                 'extra_features' => json_encode(["Accès à 2 entreprises ciblées","Visibilité dans 2 secteurs d'activité","Prix abordable pour débuter","Parfait pour les premières expériences"]),
                 'transaction_id' => 'txn_68173767eb4e5', 'payment_status' => 'pending',
                 'payment_date' => null, // Set explicitly to null if original was null
                 'is_purchasable' => 1, 'created_at' => '2025-05-04 09:46:15', 'updated_at' => '2025-05-04 09:46:15'
             ],
             [
                 'id' => 9, 'user_id' => 3, 'title' => 'Boost 2000',
                 'description' => 'Visibilité basique pour votre profil', 'price' => 2000.00,
                 'duration' => 1, 'visibility_level' => 2,
                 'extra_features' => json_encode(["Accès à 2 entreprises ciblées","Visibilité dans 2 secteurs d'activité","Prix abordable pour débuter","Parfait pour les premières expériences"]),
                 'transaction_id' => 'txn_681738c173b05', 'payment_status' => 'pending',
                 'payment_date' => null,
                 'is_purchasable' => 1, 'created_at' => '2025-05-04 09:52:01', 'updated_at' => '2025-05-04 09:52:01'
             ],
             [
                 'id' => 10, 'user_id' => 3, 'title' => 'Boost 2000',
                 'description' => 'Visibilité basique pour votre profil', 'price' => 2000.00,
                 'duration' => 1, 'visibility_level' => 2,
                 'extra_features' => json_encode(["Accès à 2 entreprises ciblées","Visibilité dans 2 secteurs d'activité","Prix abordable pour débuter","Parfait pour les premières expériences"]),
                 'transaction_id' => 'txn_68173b9b29fd0', 'payment_status' => 'pending',
                 'payment_date' => null,
                 'is_purchasable' => 1, 'created_at' => '2025-05-04 10:04:11', 'updated_at' => '2025-05-04 10:04:11'
             ],
         ]);


        // Seed Subscribers
        DB::table('subscribers')->insert([
            ['id' => 1, 'email' => 'joyaumaforikan@gmail.com', 'created_at' => '2025-05-06 06:53:54', 'updated_at' => '2025-05-06 06:53:54'],
        ]);

        // Add seeding for other tables if they had data in the old dump
        // Example: DB::table('actualites')->insert([...]);
        // Remember to adapt structures if necessary.

        Schema::enableForeignKeyConstraints();
    }
}