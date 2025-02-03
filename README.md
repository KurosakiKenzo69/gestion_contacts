# Projet Kenzo VONGKINGKEO Unidrine

## Description

Ce projet est une application web pour la gestion des contacts. Elle permet aux utilisateurs de créer, modifier et supprimer des informations de contact. L'application est construite avec le framework Symfony et utilise une base de données pour stocker les informations des contacts.

## Fonctionnalités

- Ajouter de nouveaux contacts avec des informations telles que le nom, le prénom, l'email et le téléphone.
- Modifier les informations des contacts existants.
- Supprimer des contacts de la base de données.
- Lister tous les contacts enregistrés.

## Installation

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/yourusername/Kenzo_VONGKINGKEO_unidrine.git
   ```
2. Naviguer vers le répertoire du projet :
   ```bash
   cd Kenzo_VONGKINGKEO_unidrine
   ```
3. Installer les dépendances :
   ```bash
   composer install
   npm install
   ```
4. Configurer la base de données :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:update --force
   ```
5. Démarrer le serveur de développement :
   ```bash
   symfony server:start
   ```

## Utilisation

- Accéder à l'application dans votre navigateur web à l'adresse `http://localhost:8000`.
- Pour ajouter un contact, cliquez sur "Ajouter un contact" et remplissez le formulaire.
- Pour modifier un contact, cliquez sur "Modifier" à côté du contact que vous souhaitez modifier.
- Pour supprimer un contact, cliquez sur "Supprimer" à côté du contact que vous souhaitez supprimer.
