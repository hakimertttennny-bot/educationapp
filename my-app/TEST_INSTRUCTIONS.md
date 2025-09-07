# 🧪 Instructions de Test - Système d'Authentification

## ✅ Problèmes Corrigés
1. **Rate limiter [api] is not defined** - ✅ Corrigé
2. **Sélection de rôle lors de la connexion** - ✅ Ajoutée  
3. **Erreur Middleware::alias()** - ✅ Corrigée

## 🚀 Test Rapide

### 1. Démarrer l'Application
```bash
cd my-app
php artisan serve
```

### 2. Tester la Connexion
- Aller à : `http://localhost:8000/login`
- **IMPORTANT** : Sélectionner le bon rôle avant de se connecter !

### 3. Comptes de Test

#### 🔑 Admin
- **Rôle** : Admin
- **Email** : `admin@example.com`
- **Mot de passe** : `password`

#### 👨‍🏫 Instructor
- **Rôle** : Instructor/Professor  
- **Email** : `instructor@example.com`
- **Mot de passe** : `password`

#### 🎓 Student
- **Rôle** : Student
- **Email** : `student@example.com`
- **Mot de passe** : `password`

## 🔧 Si l'Application ne Démarre Pas

### Vérifier la Base de Données
```bash
php artisan migrate:fresh --seed
```

### Vérifier les Permissions
```bash
php artisan storage:link
```

### Nettoyer le Cache
```bash
php artisan config:clear
php artisan cache:clear
```

## 📱 Test des Fonctionnalités

### ✅ Connexion avec Rôle
1. Sélectionner le bon rôle
2. Entrer email/mot de passe
3. Cliquer "Sign In"

### ✅ Upload d'Image (Inscription)
1. Cliquer "Sign up"
2. Remplir le formulaire
3. Ajouter une image (optionnel)
4. Créer le compte

### ✅ Changement d'Image (Dashboard)
1. Se connecter
2. Aller dans "My Profile"
3. Cliquer sur l'icône caméra
4. Sélectionner une nouvelle image

## 🐛 Messages d'Erreur Courants

### "Invalid role for this account"
- **Solution** : Sélectionner le bon rôle pour le compte

### "Rate limiter not defined"
- **Solution** : ✅ Corrigé dans la configuration

### "Middleware::alias() error"
- **Solution** : ✅ Corrigé dans bootstrap/app.php

## 🎯 Résultat Attendu

Après connexion réussie :
- Redirection vers le dashboard
- Interface adaptée au rôle (Admin/Instructor/Student)
- Possibilité de gérer le profil et les images

---

**Le système est maintenant stable et fonctionnel !** 🎉


