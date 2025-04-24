-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 avr. 2025 à 11:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stagesbenin`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

CREATE TABLE `actualites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `date_publication` datetime NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actualites`
--

INSERT INTO `actualites` (`id`, `titre`, `contenu`, `image_path`, `date_publication`, `categorie`, `auteur`, `created_at`, `updated_at`) VALUES
(1, 'EBENI EVENTS', 'RUTSDFVY', '1744906467_actu.jpg', '2025-04-19 17:14:00', 'Formation', 'JAEN', '2025-04-17 15:14:27', '2025-04-17 15:14:27');

-- --------------------------------------------------------

--
-- Structure de la table `catalogue`
--

CREATE TABLE `catalogue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duree` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `niveau` varchar(100) DEFAULT NULL,
  `pre_requis` text DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `catalogues`
--

CREATE TABLE `catalogues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `localisation` varchar(255) NOT NULL,
  `nb_activites` int(11) NOT NULL,
  `activite_principale` varchar(255) NOT NULL,
  `desc_activite_principale` text NOT NULL,
  `activite_secondaire` varchar(255) DEFAULT NULL,
  `desc_activite_secondaire` text DEFAULT NULL,
  `autres` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogues`
--

INSERT INTO `catalogues` (`id`, `titre`, `description`, `logo`, `localisation`, `nb_activites`, `activite_principale`, `desc_activite_principale`, `activite_secondaire`, `desc_activite_secondaire`, `autres`, `image`, `created_at`, `updated_at`) VALUES
(1, 'EBENI EVENTS', 'UYSDYH UHS USF', 'logo_6801261a857990.29319086.jpeg', 'Bénin/GODOMEY', 1, 'DECORATION ET EVENEMENT', 'ECECRVTTTTTTTTTTE', NULL, NULL, 'CTRVYTYE2CR', 'bg_6801261a868385.19543804.jpg', '2025-04-17 15:02:34', '2025-04-17 15:02:34');

-- --------------------------------------------------------

--
-- Structure de la table `cv_centre_interets`
--

CREATE TABLE `cv_centre_interets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_certifications`
--

CREATE TABLE `cv_certifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `organisme` varchar(255) NOT NULL,
  `annee` year(4) DEFAULT NULL,
  `url_validation` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_competences`
--

CREATE TABLE `cv_competences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `categorie` varchar(255) NOT NULL DEFAULT 'Autres',
  `nom` varchar(255) NOT NULL,
  `niveau` tinyint(3) UNSIGNED NOT NULL DEFAULT 50 COMMENT 'Niveau de 0 à 100',
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_experiences`
--

CREATE TABLE `cv_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `poste` varchar(255) NOT NULL,
  `entreprise` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `tache_1` text DEFAULT NULL,
  `tache_2` text DEFAULT NULL,
  `tache_3` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_formations`
--

CREATE TABLE `cv_formations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `etablissement` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `annee_debut` year(4) NOT NULL,
  `annee_fin` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_langues`
--

CREATE TABLE `cv_langues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `langue` varchar(255) NOT NULL,
  `niveau` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_profiles`
--

CREATE TABLE `cv_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `etudiant_id` bigint(20) UNSIGNED NOT NULL,
  `titre_profil` varchar(255) DEFAULT NULL COMMENT 'Ex: Ingénieur Développement Web',
  `resume_profil` text DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone_cv` varchar(20) DEFAULT NULL,
  `email_cv` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL,
  `situation_matrimoniale` varchar(255) DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) DEFAULT NULL,
  `photo_cv_path` varchar(255) DEFAULT NULL,
  `template_slug` varchar(255) NOT NULL DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cv_profiles`
--

INSERT INTO `cv_profiles` (`id`, `etudiant_id`, `titre_profil`, `resume_profil`, `adresse`, `telephone_cv`, `email_cv`, `linkedin_url`, `portfolio_url`, `situation_matrimoniale`, `nationalite`, `date_naissance`, `lieu_naissance`, `photo_cv_path`, `template_slug`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default', '2025-04-17 13:55:53', '2025-04-17 13:55:53'),
(2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default', '2025-04-17 14:04:56', '2025-04-17 14:04:56');

-- --------------------------------------------------------

--
-- Structure de la table `cv_projets`
--

CREATE TABLE `cv_projets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `url_projet` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `technologies` varchar(255) DEFAULT NULL COMMENT 'Ex: React, Node.js, MongoDB',
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv_references`
--

CREATE TABLE `cv_references` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cv_profile_id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `poste` varchar(255) DEFAULT NULL,
  `relation` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `secteur` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `site_web` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `contact_principal` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `nom`, `secteur`, `description`, `adresse`, `email`, `telephone`, `site_web`, `logo_path`, `contact_principal`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Tech Solutions Bénin', 'Informatique - Développement Web', 'Leader en solutions logicielles innovantes au Bénin.', 'Lot 123, Zongo, Cotonou', 'contact@techsolutions.bj', '21001122', 'https://techsolutions.bj', NULL, 'David AKOTO', '2025-04-17 10:34:07', '2025-04-17 10:34:07', 5),
(2, 'AgroPlus Sarl', 'Agro-alimentaire', 'Transformation et commercialisation de produits agricoles locaux.', 'Quartier Haie Vive, Parakou', 'info@agroplus.com', '22334455', 'https://agroplus.com', NULL, 'Elise PADONOU', '2025-04-17 10:34:07', '2025-04-17 10:34:07', 6);

-- --------------------------------------------------------

--
-- Structure de la table `entretiens`
--

CREATE TABLE `entretiens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `etudiant_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `entreprise_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `commentaires` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `formation` varchar(255) DEFAULT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `email`, `telephone`, `formation`, `niveau`, `date_naissance`, `cv_path`, `photo_path`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'SOGLO', 'Amina', 'amina.soglo@example.com', '97001122', 'Génie Logiciel', 'Licence 3', '2003-05-15', NULL, NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07', 2),
(2, 'GUERA', 'Bio', 'bio.guera@example.com', '66998877', 'Réseaux et Télécommunications', 'Master 1', '2001-11-20', NULL, NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07', 3),
(3, 'HOUNSOOU', 'Carine', 'carine.hounsou@example.com', '51234567', 'Marketing Digital', 'Licence 2', '2004-02-10', NULL, NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07', 4),
(4, 'SEBIO', 'Mahoulolo', 'createurmeuble@gmail.com', NULL, NULL, NULL, NULL, NULL, 'etudiant_photos/user_7/GjIVY1IjvnwNXrmRMEuqxqkFzco1vFZFxdMj50Pu.jpg', '2025-04-17 13:55:03', '2025-04-17 14:02:00', 7);

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_date`, `end_date`, `location`, `type`, `max_participants`, `image`, `created_at`, `updated_at`, `is_published`) VALUES
(1, 'cabro', 'pipopp', '2025-04-17 17:12:00', '2025-04-29 17:12:00', 'Cotonou, Littoral, Bénin', 'Salon', 1000, '1744906419.jpg', '2025-04-17 15:13:39', '2025-04-17 15:13:39', 0);

-- --------------------------------------------------------

--
-- Structure de la table `examens`
--

CREATE TABLE `examens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `etudiant_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_04_08_153418_create_actualites_table', 1),
(6, '2025_04_08_153512_create_catalogue_table', 1),
(7, '2025_04_08_153619_create_entreprises_table', 1),
(8, '2025_04_08_153720_create_etudiants_table', 1),
(9, '2025_04_08_153926_create_events_table', 1),
(10, '2025_04_08_154101_create_subscribers_table', 1),
(11, '2025_04_08_154208_create_recrutements_table', 1),
(12, '2025_04_08_154324_create_registrations_table', 1),
(13, '2025_04_09_094553_create_cv_profiles_table', 1),
(14, '2025_04_09_094602_create_cv_formations_table', 1),
(15, '2025_04_09_094607_create_cv_experiences_table', 1),
(16, '2025_04_09_094612_create_cv_competences_table', 1),
(17, '2025_04_09_094618_create_cv_langues_table', 1),
(18, '2025_04_09_094623_create_cv_centres_interet_table', 1),
(19, '2025_04_09_094627_create_cv_certifications_table', 1),
(20, '2025_04_09_094632_create_cv_projets_table', 1),
(21, '2025_04_10_084143_add_is_published_to_events_table', 1),
(22, '2025_04_10_113838_create_entretiens_table', 1),
(23, '2025_04_10_134317_create_examens_table', 1),
(24, '2025_04_10_141030_create_questions_table', 1),
(25, '2025_04_11_095553_add_options_column_to_questions_table', 1),
(26, '2025_04_12_000001_add_personal_info_to_cv_profiles_table', 1),
(27, '2025_04_15_171318_create_catalogues_table', 1),
(28, '2025_04_16_110139_add_personal_info_to_cv_profiles_table', 1),
(29, '2025_04_16_110600_create_cv_references_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `texte` varchar(255) NOT NULL,
  `bonne_reponse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `options` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recrutements`
--

CREATE TABLE `recrutements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entreprise_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `type_contrat` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `competences_requises` text DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `salaire` varchar(100) DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'etudiant',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin StagesBenin', 'admin@stagesbenin.com', '2025-04-17 10:34:06', '$2y$10$xN8WpGm0YVLb5E3f2RM30eHIjoR5cgq0ezaNq049sW82WwT3.AexS', 'admin', NULL, '2025-04-17 10:34:06', '2025-04-17 10:34:06'),
(2, 'Amina SOGLO', 'amina.soglo@example.com', '2025-04-17 10:34:07', '$2y$10$2QaKwQv48274ghx9I0bOC.mrM2v1QfB1fEZ21nILgBtHb.jLwefOq', 'etudiant', NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07'),
(3, 'Bio GUERA', 'bio.guera@example.com', '2025-04-17 10:34:07', '$2y$10$1W70khv2fXJ8j7.q0dm7X.6bFA4ZmetVFArMfKZsgJi20C34aoAWq', 'etudiant', NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07'),
(4, 'Carine HOUNSOOU', 'carine.hounsou@example.com', '2025-04-17 10:34:07', '$2y$10$UlunR/12XIsuUFjp94p4neCqjUpBNsDPylJTvO.xfFCcFr.F4CVeK', 'etudiant', NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07'),
(5, 'David AKOTO', 'david.akoto@techsolutions.bj', '2025-04-17 10:34:07', '$2y$10$6EXHMDbUbTOTnBa.SPvKluY8c.DCj/qqS6m2V8Dl7.S2AhXeNI3Cy', 'recruteur', NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07'),
(6, 'Elise PADONOU', 'elise.padonou@agroplus.com', '2025-04-17 10:34:07', '$2y$10$Mam85uk7/bsCEXd5U/s1b.ri42zQMO5/g4k9sI479Ltdn74THhx7.', 'recruteur', NULL, '2025-04-17 10:34:07', '2025-04-17 10:34:07'),
(7, 'Mahoulolo SEBIO', 'createurmeuble@gmail.com', NULL, '$2y$10$gBJjFyRpAfyQI5mvcpJ6Dun1F5crlYQvbbpP4BZQzdO5ULwt4Ixsu', 'etudiant', NULL, '2025-04-17 13:55:03', '2025-04-17 13:55:03');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualites`
--
ALTER TABLE `actualites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `catalogue`
--
ALTER TABLE `catalogue`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `catalogues`
--
ALTER TABLE `catalogues`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cv_centre_interets`
--
ALTER TABLE `cv_centre_interets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_centre_interets_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_certifications`
--
ALTER TABLE `cv_certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_certifications_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_competences`
--
ALTER TABLE `cv_competences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_competences_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_experiences`
--
ALTER TABLE `cv_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_experiences_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_formations`
--
ALTER TABLE `cv_formations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_formations_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_langues`
--
ALTER TABLE `cv_langues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_langues_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_profiles`
--
ALTER TABLE `cv_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_profiles_etudiant_id_foreign` (`etudiant_id`);

--
-- Index pour la table `cv_projets`
--
ALTER TABLE `cv_projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_projets_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `cv_references`
--
ALTER TABLE `cv_references`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_references_cv_profile_id_foreign` (`cv_profile_id`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `entreprises_user_id_unique` (`user_id`);

--
-- Index pour la table `entretiens`
--
ALTER TABLE `entretiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entretiens_etudiant_id_foreign` (`etudiant_id`),
  ADD KEY `entretiens_user_id_foreign` (`user_id`),
  ADD KEY `entretiens_entreprise_id_foreign` (`entreprise_id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `etudiants_email_unique` (`email`),
  ADD UNIQUE KEY `etudiants_user_id_unique` (`user_id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examens`
--
ALTER TABLE `examens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examens_etudiant_id_foreign` (`etudiant_id`),
  ADD KEY `examens_user_id_foreign` (`user_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recrutements`
--
ALTER TABLE `recrutements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recrutements_entreprise_id_foreign` (`entreprise_id`);

--
-- Index pour la table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrations_email_unique` (`email`),
  ADD KEY `registrations_event_id_foreign` (`event_id`);

--
-- Index pour la table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actualites`
--
ALTER TABLE `actualites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `catalogue`
--
ALTER TABLE `catalogue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `catalogues`
--
ALTER TABLE `catalogues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cv_centre_interets`
--
ALTER TABLE `cv_centre_interets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_certifications`
--
ALTER TABLE `cv_certifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_competences`
--
ALTER TABLE `cv_competences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_experiences`
--
ALTER TABLE `cv_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_formations`
--
ALTER TABLE `cv_formations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_langues`
--
ALTER TABLE `cv_langues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_profiles`
--
ALTER TABLE `cv_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cv_projets`
--
ALTER TABLE `cv_projets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cv_references`
--
ALTER TABLE `cv_references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `entretiens`
--
ALTER TABLE `entretiens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `examens`
--
ALTER TABLE `examens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recrutements`
--
ALTER TABLE `recrutements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cv_centre_interets`
--
ALTER TABLE `cv_centre_interets`
  ADD CONSTRAINT `cv_centre_interets_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_certifications`
--
ALTER TABLE `cv_certifications`
  ADD CONSTRAINT `cv_certifications_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_competences`
--
ALTER TABLE `cv_competences`
  ADD CONSTRAINT `cv_competences_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_experiences`
--
ALTER TABLE `cv_experiences`
  ADD CONSTRAINT `cv_experiences_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_formations`
--
ALTER TABLE `cv_formations`
  ADD CONSTRAINT `cv_formations_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_langues`
--
ALTER TABLE `cv_langues`
  ADD CONSTRAINT `cv_langues_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_profiles`
--
ALTER TABLE `cv_profiles`
  ADD CONSTRAINT `cv_profiles_etudiant_id_foreign` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_projets`
--
ALTER TABLE `cv_projets`
  ADD CONSTRAINT `cv_projets_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cv_references`
--
ALTER TABLE `cv_references`
  ADD CONSTRAINT `cv_references_cv_profile_id_foreign` FOREIGN KEY (`cv_profile_id`) REFERENCES `cv_profiles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD CONSTRAINT `entreprises_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entretiens`
--
ALTER TABLE `entretiens`
  ADD CONSTRAINT `entretiens_entreprise_id_foreign` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entretiens_etudiant_id_foreign` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entretiens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `examens`
--
ALTER TABLE `examens`
  ADD CONSTRAINT `examens_etudiant_id_foreign` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recrutements`
--
ALTER TABLE `recrutements`
  ADD CONSTRAINT `recrutements_entreprise_id_foreign` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`);

--
-- Contraintes pour la table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
