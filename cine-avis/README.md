# CinéAvis  — Projet Outils de développement web

Thème choisi : avis sur des films.

## Installation

1. Dézipper l’archive dans le dossier `htdocs` de XAMPP, MAMP, WAMP ou équivalent.
2. Lancer Apache avec PHP.
3. Ouvrir dans le navigateur : `http://localhost/site_avis/`
4. La base SQLite est créée automatiquement dans `data/site_avis.sqlite` au premier chargement.

## Comptes de test

Administrateur :
- pseudo : `admin`
- mot de passe : `admin123`

Utilisateur :
- pseudo : `demo`
- mot de passe : `demo123`

## Fonctionnalités incluses

- Inscription avec pseudo unique, email et mot de passe hashé.
- Connexion simple par pseudo et mot de passe.
- Ajout de films par utilisateur connecté.
- Dépôt d’avis avec note de 0 à 5 et commentaire.
- Affichage des avis d’un film.
- Affichage des avis d’un utilisateur via clic sur son pseudo.
- Page administrateur pour supprimer un film ou un avis.
- Navigation entre toutes les pages.
- Feuille CSS responsive.
- Statistiques : nombre d’avis, moyenne, répartition des notes.

## Remarque SQL

Le fichier `schema.sql` permet de recréer la structure de la base.
