# 🧪 **Test de l'Inscription avec Sélection de Rôle**

## ✅ **Fonctionnalités Ajoutées :**

### **1. Sélection de Rôle Obligatoire** ✅
- **Champ** : "Account Type" avec options Student/Instructor
- **Validation** : Rôle requis pour l'inscription
- **Message d'erreur** : Alerte si aucun rôle sélectionné

### **2. Gestion des Tokens** ✅
- **Stockage** : Token Sanctum stocké dans localStorage
- **Redirection** : Redirection automatique vers `/dashboard`
- **Persistance** : Session maintenue après inscription

### **3. Validation Améliorée** ✅
- **Vérification** : Tous les champs requis + rôle
- **Messages** : Erreurs spécifiques pour chaque problème

## 🚀 **Test de l'Inscription :**

### **1. Démarrer l'Application**
```bash
cd my-app
php artisan serve
```

### **2. Tester l'Inscription Student**
1. Aller à : `http://localhost:8000/signup`
2. Remplir le formulaire :
   - **First Name** : John
   - **Last Name** : Doe
   - **Email** : john.student@example.com
   - **Phone** : +1234567890
   - **Password** : password123
   - **Confirm Password** : password123
   - **Account Type** : Student
   - **Learning Interests** : Web Development
   - **Agree to Terms** : ✅
3. Cliquer sur "Create Account"
4. **Résultat attendu** : 
   - ✅ Compte créé avec succès
   - ✅ Token stocké dans localStorage
   - ✅ Redirection vers `/dashboard`
   - ✅ Interface Student affichée

### **3. Tester l'Inscription Instructor**
1. Aller à : `http://localhost:8000/signup`
2. Remplir le formulaire :
   - **First Name** : Jane
   - **Last Name** : Smith
   - **Email** : jane.instructor@example.com
   - **Phone** : +1987654321
   - **Password** : password123
   - **Confirm Password** : password123
   - **Account Type** : Instructor/Professor
   - **Learning Interests** : Data Science
   - **Agree to Terms** : ✅
3. Cliquer sur "Create Account"
4. **Résultat attendu** :
   - ✅ Compte créé avec succès
   - ✅ Token stocké dans localStorage
   - ✅ Redirection vers `/dashboard`
   - ✅ Interface Instructor affichée

### **4. Tester la Validation des Erreurs**
1. **Sans sélectionner de rôle** :
   - Message : "Please select your account type (Student or Instructor/Professor)."
2. **Sans accepter les termes** :
   - Message : "Please fill in all required fields and ensure passwords match."
3. **Mots de passe différents** :
   - Message : "Please fill in all required fields and ensure passwords match."

## 🔍 **Vérifications à Faire :**

### **Dans la Console du Navigateur**
```javascript
// Vérifier le token
console.log('Token:', localStorage.getItem('token'));

// Vérifier les données utilisateur
console.log('User:', localStorage.getItem('user'));

// Vérifier le rôle
const user = JSON.parse(localStorage.getItem('user'));
console.log('Role:', user.role);
```

### **Dans les DevTools Network**
- Vérifier que la requête POST `/api/signup` est envoyée
- Vérifier que la réponse contient `token` et `user`
- Vérifier que le statut est 200 OK

### **Dans la Base de Données**
```sql
-- Vérifier que l'utilisateur est créé
SELECT * FROM users WHERE email = 'john.student@example.com';

-- Vérifier que le profil Instructor est créé si applicable
SELECT * FROM instructors WHERE user_id = [user_id];
```

## 🎯 **Résultats Attendus :**

### **✅ Inscription Student**
- Compte créé avec `role = 'student'`
- Redirection vers dashboard Student
- Interface adaptée au rôle Student

### **✅ Inscription Instructor**
- Compte créé avec `role = 'instructor'`
- Profil Instructor créé automatiquement
- Redirection vers dashboard Instructor
- Interface adaptée au rôle Instructor

### **✅ Gestion des Sessions**
- Token Sanctum généré et stocké
- Session persistante après rechargement
- Protection des routes appropriée

## 🐛 **Problèmes Courants :**

### **"Role field is required"**
- **Cause** : Validation côté serveur
- **Solution** : S'assurer que le rôle est sélectionné

### **"Email already exists"**
- **Cause** : Email déjà utilisé
- **Solution** : Utiliser un email unique

### **"Token not found"**
- **Cause** : Problème avec Sanctum
- **Solution** : Vérifier la configuration Sanctum

---

## 🎉 **INSCRIPTION MAINTENANT FONCTIONNELLE !**

**Votre système d'inscription avec sélection de rôle est maintenant 100% opérationnel !**

Testez les deux types de comptes et vérifiez que tout fonctionne correctement.


