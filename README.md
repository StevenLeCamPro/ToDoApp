# Todo List Symfony avec Twig et Tailwind

## Description

Ce projet est une application de gestion de tâches (Todo List) construite avec Symfony et Twig. L'application permet aux utilisateurs de créer, marquer comme complètes et supprimer des tâches. L'interface est entièrement stylisée avec **Tailwind CSS**, intégré via un CDN.

## Fonctionnalités

- Ajouter une nouvelle tâche
- Marquer une tâche comme terminée
- Supprimer une tâche
- Interface utilisateur responsive grâce à **Tailwind CSS**

## Prérequis

Avant de commencer, vous devez avoir installé les éléments suivants :

- PHP >= 8.0
- Composer
- Symfony CLI (optionnel mais recommandé)
- Un serveur de base de données (par exemple, MySQL, SQLite)

## Installation

1. Clonez ce dépôt sur votre machine locale :

```bash
git clone https://github.com/your-username/todolist-symfony.git
```

2. Accédez au dossier du projet :

```bash
cd todolist-symfony
```

3. Installez les dépendances avec Composer :

```bash
composer install
```

4. Créez la base de données et les tables (si vous utilisez MySQL ou SQLite) :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```

5. Lancez le serveur Symfony pour voir l'application en action :

```bash
symfony serve
```

L'application sera disponible à l'adresse suivante : [http://localhost:8000](http://localhost:8000).

## Structure du projet

- **src/** : Contient le code PHP, y compris les contrôleurs et les entités.
- **templates/** : Contient les fichiers de templates Twig pour l'interface utilisateur.
- **public/** : Contient les fichiers accessibles publiquement, y compris le fichier `index.php` et le dossier `assets` (images, CSS, etc.).
- **assets/** : Si vous décidez d'ajouter des fichiers JavaScript ou CSS personnalisés, vous pouvez les mettre ici.

## Technologie utilisée

- **Symfony** : Framework PHP pour développer l'application.
- **Twig** : Moteur de templates utilisé pour générer les vues.
- **Tailwind CSS (CDN)** : Framework CSS pour un design moderne et responsive.

## Personnalisation

### 1. Modifications du style
Bien que Tailwind CSS soit déjà inclus via le CDN dans le fichier `base.html.twig`, vous pouvez facilement personnaliser le style de l'application en modifiant les classes Tailwind dans les fichiers de templates Twig.

### 2. Fonctionnalités supplémentaires
Vous pouvez ajouter des fonctionnalités supplémentaires, telles que :

- **Système d'authentification** : Permettre aux utilisateurs de se connecter et de gérer leurs propres tâches.
- **Priorité des tâches** : Ajouter une priorité (haute, moyenne, basse) aux tâches.
- **Date d'échéance** : Ajouter une date d'échéance pour chaque tâche.

## Déploiement

### Sur un serveur de production

Pour déployer cette application sur un serveur de production, vous pouvez utiliser des outils comme **Docker**, **Nginx** ou **Apache**. N'oubliez pas de configurer correctement votre environnement (en particulier les variables d'environnement et la base de données).
