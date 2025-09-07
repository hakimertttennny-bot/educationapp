# Système d'Authentification Complet

Ce système d'authentification permet aux utilisateurs de se connecter en tant qu'**Admin**, **Instructor/Professor** ou **Student**, avec la possibilité d'uploader et changer leur image de profil.

## 🚀 Fonctionnalités

### 🔐 Authentification
- **Connexion** : Email + mot de passe
- **Inscription** : Création de compte avec sélection de rôle
- **Déconnexion** : Gestion des tokens d'authentification
- **Rôles** : Admin, Instructor, Student

### 📸 Gestion des Images
- **Upload d'image** lors de l'inscription
- **Changement d'image** après connexion
- **Validation** : Types d'images supportés (JPEG, PNG, JPG, GIF)
- **Taille maximale** : 5MB
- **Stockage** : Dossier `storage/app/public/profile-images`

### 🎯 Rôles et Permissions
- **Admin** : Gestion complète de la plateforme
- **Instructor** : Création et gestion de cours
- **Student** : Inscription aux cours et suivi des professeurs

## 🛠️ Installation et Configuration

### 1. Prérequis
```bash
# Installer les dépendances
composer install
npm install

# Générer la clé d'application
php artisan key:generate
```

### 2. Configuration de la Base de Données
```bash
# Créer le fichier .env
cp .env.example .env

# Configurer la base de données dans .env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 3. Migration et Seeding
```bash
# Créer les tables
php artisan migrate

# Créer les utilisateurs de test
php artisan db:seed
```

### 4. Configuration du Stockage
```bash
# Créer le lien symbolique pour le stockage public
php artisan storage:link

# Démarrer le serveur
php artisan serve

# Dans un autre terminal, compiler les assets
npm run dev
```

## 📱 Utilisation

### Page de Connexion
- **URL** : `/login`
- **Fonctionnalités** :
  - Connexion avec email/mot de passe
  - Basculement vers le formulaire d'inscription
  - Gestion des erreurs

### Page d'Inscription
- **Champs requis** :
  - Nom complet
  - Email
  - Rôle (Student, Instructor, Admin)
  - Mot de passe + confirmation
  - Image de profil (optionnelle)

### Dashboard
- **Contenu dynamique** selon le rôle
- **Gestion du profil** avec changement d'image
- **Statistiques** spécifiques au rôle

## 🔧 Configuration des Middlewares

### Authentification
```php
// Routes protégées
Route::middleware('auth')->group(function () {
    // Routes nécessitant une connexion
});
```

### Rôles
```php
// Routes Admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Routes réservées aux admins
});

// Routes Instructor
Route::middleware(['auth', 'instructor'])->group(function () {
    // Routes réservées aux instructeurs
});

// Routes Student
Route::middleware(['auth', 'student'])->group(function () {
    // Routes réservées aux étudiants
});
```

## 📁 Structure des Fichiers

```
my-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php      # Gestion auth + images
│   │   │   ├── AdminController.php     # Actions admin
│   │   │   ├── InstructorController.php # Actions instructeur
│   │   │   └── StudentController.php   # Actions étudiant
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php     # Vérification admin
│   │       ├── InstructorMiddleware.php # Vérification instructeur
│   │       └── StudentMiddleware.php   # Vérification étudiant
│   └── Models/
│       ├── User.php                    # Modèle utilisateur
│       └── Instructor.php              # Modèle instructeur
├── resources/
│   └── js/
│       └── pages/
│           ├── Login.vue               # Page connexion/inscription
│           └── Dashboard.vue           # Dashboard avec gestion d'images
├── routes/
│   └── api.php                        # Routes API avec middleware
├── database/
│   ├── migrations/                     # Structure base de données
│   └── seeders/                       # Données de test
└── storage/
    └── app/
        └── public/
            └── profile-images/         # Stockage des images
```

## 🔒 Sécurité

### Validation des Images
- **Types autorisés** : JPEG, PNG, JPG, GIF
- **Taille maximale** : 5MB
- **Stockage sécurisé** : Dossier public avec validation

### Authentification
- **Tokens Sanctum** : Authentification par token
- **Validation des rôles** : Middleware de vérification
- **Protection CSRF** : Activée par défaut

### Base de Données
- **Hachage des mots de passe** : Bcrypt
- **Validation des données** : Règles Laravel
- **Relations sécurisées** : Clés étrangères avec cascade

## 🧪 Tests

### Comptes de Test
Après le seeding, vous pouvez utiliser :

#### Admin
- **Email** : admin@example.com
- **Mot de passe** : password
- **Accès** : Gestion complète de la plateforme

#### Instructor
- **Email** : instructor@example.com
- **Mot de passe** : password
- **Accès** : Création et gestion de cours

#### Student
- **Email** : student@example.com
- **Mot de passe** : password
- **Accès** : Inscription aux cours

## 🚀 Déploiement

### Production
```bash
# Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compiler les assets
npm run build
```

### Variables d'Environnement
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votre_base
DB_USERNAME=votre_user
DB_PASSWORD=votre_password

FILESYSTEM_DISK=public
```

## 🔧 Personnalisation

### Ajouter un Nouveau Rôle
1. Ajouter le rôle dans la migration `users`
2. Créer le middleware correspondant
3. Ajouter les routes dans `api.php`
4. Mettre à jour le frontend

### Modifier les Types d'Images
```php
// Dans AuthController.php
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
```

### Changer la Taille Maximale
```php
// Dans AuthController.php
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240' // 10MB
```

## 📞 Support

Pour toute question ou problème :
1. Vérifier les logs dans `storage/logs/laravel.log`
2. Vérifier la configuration de la base de données
3. Vérifier les permissions du dossier `storage`

## 🔄 Mises à Jour

### Ajouter de Nouvelles Fonctionnalités
1. Créer les migrations nécessaires
2. Mettre à jour les modèles
3. Ajouter les contrôleurs
4. Mettre à jour le frontend
5. Tester avec différents rôles

### Maintenance
```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Mettre à jour les dépendances
composer update
npm update
```

---

**Système prêt pour la production !** 🎉


