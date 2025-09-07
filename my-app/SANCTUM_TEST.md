# 🧪 Test Sanctum - Authentification API

## ✅ **Problèmes Corrigés :**
1. **Laravel Sanctum installé** ✅
2. **Trait HasApiTokens ajouté** au modèle User ✅
3. **Migrations Sanctum exécutées** ✅
4. **Configuration Sanctum créée** ✅

## 🚀 **Test Rapide :**

### 1. **Démarrer l'Application**
```bash
php artisan serve
```

### 2. **Tester la Connexion API**
- Aller à : `http://localhost:8000/login`
- Sélectionner un rôle (Admin/Instructor/Student)
- Utiliser les comptes de test

### 3. **Comptes de Test Disponibles**

#### 🔑 **Admin**
- **Rôle** : Admin
- **Email** : `admin@example.com`
- **Mot de passe** : `password`

#### 👨‍🏫 **Instructor**
- **Rôle** : Instructor/Professor
- **Email** : `instructor@example.com`
- **Mot de passe** : `password`

#### 🎓 **Student**
- **Rôle** : Student
- **Email** : `student@example.com`
- **Mot de passe** : `password`

## 🔧 **Si l'Erreur Persiste :**

### Vérifier la Configuration
```bash
# Nettoyer le cache
php artisan config:clear
php artisan cache:clear

# Vérifier les routes
php artisan route:list --path=api
```

### Vérifier Sanctum
```bash
# Vérifier l'installation
composer show laravel/sanctum

# Republier la configuration
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## 📱 **Fonctionnalités à Tester :**

### ✅ **Connexion avec Rôle**
1. Sélectionner le bon rôle
2. Entrer email/mot de passe
3. Vérifier la création du token

### ✅ **API Endpoints**
- `POST /api/login` - Connexion
- `POST /api/signup` - Inscription
- `GET /api/user` - Informations utilisateur
- `POST /api/logout` - Déconnexion

### ✅ **Protection des Routes**
- Routes protégées par middleware `auth:sanctum`
- Vérification des rôles par middleware personnalisés

## 🎯 **Résultat Attendu :**

Après connexion réussie :
- **Token généré** et stocké dans localStorage
- **Redirection** vers le dashboard
- **API calls** fonctionnels avec le token
- **Interface adaptée** au rôle de l'utilisateur

## 🐛 **Messages d'Erreur Courants :**

### "Call to undefined method createToken()"
- **Solution** : ✅ Trait HasApiTokens ajouté au modèle User

### "Rate limiter not defined"
- **Solution** : ✅ Corrigé dans la configuration

### "Middleware::alias() error"
- **Solution** : ✅ Corrigé dans bootstrap/app.php

---

**Sanctum est maintenant configuré et fonctionnel !** 🎉

Testez la connexion et vérifiez que les tokens sont générés correctement.


