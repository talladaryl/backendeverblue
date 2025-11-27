# Solution aux Erreurs HTTP - Méthodes Incorrectes

## 🔴 ERREUR 1: "The GET method is not supported for route api/auth/register"

### Problème
Tu utilises **GET** au lieu de **POST**

### ❌ INCORRECT
```
GET http://127.0.0.1:8000/api/auth/register
```

### ✅ CORRECT
```
POST http://127.0.0.1:8000/api/auth/register
```

### Pourquoi?
- `/auth/register` est une route **POST** uniquement
- Elle crée un nouvel utilisateur (création = POST)
- GET est pour récupérer des données, pas pour créer

---

## 🔴 ERREUR 2: "The GET method is not supported for route api/aiimage/generate-image"

### Problème
Tu utilises **GET** au lieu de **POST**

### ❌ INCORRECT
```
GET http://127.0.0.1:8000/api/aiimage/generate-image
```

### ✅ CORRECT
```
POST http://127.0.0.1:8000/api/aiimage/generate-image
```

### Pourquoi?
- `/aiimage/generate-image` est une route **POST** uniquement
- Elle génère une image (action = POST)
- GET est pour récupérer des données, pas pour générer

---

## 📋 GUIDE DES MÉTHODES HTTP

### GET - Récupérer des données
```
GET http://127.0.0.1:8000/api/templates
GET http://127.0.0.1:8000/api/events
GET http://127.0.0.1:8000/api/guests
GET http://127.0.0.1:8000/api/auth/me
GET http://127.0.0.1:8000/api/aiimage/versions
GET http://127.0.0.1:8000/api/aiimage/recent-images
```

### POST - Créer ou envoyer des données
```
POST http://127.0.0.1:8000/api/auth/register
POST http://127.0.0.1:8000/api/auth/login
POST http://127.0.0.1:8000/api/templates
POST http://127.0.0.1:8000/api/events
POST http://127.0.0.1:8000/api/guests
POST http://127.0.0.1:8000/api/rsvps
POST http://127.0.0.1:8000/api/mailings
POST http://127.0.0.1:8000/api/mailings/{id}/send
POST http://127.0.0.1:8000/api/mailings/{id}/test
POST http://127.0.0.1:8000/api/aiimage/generate-image
```

### PUT - Mettre à jour des données
```
PUT http://127.0.0.1:8000/api/templates/{id}
PUT http://127.0.0.1:8000/api/events/{id}
PUT http://127.0.0.1:8000/api/guests/{id}
PUT http://127.0.0.1:8000/api/rsvps/{id}
PUT http://127.0.0.1:8000/api/mailings/{id}
```

### DELETE - Supprimer des données
```
DELETE http://127.0.0.1:8000/api/templates/{id}
DELETE http://127.0.0.1:8000/api/events/{id}
DELETE http://127.0.0.1:8000/api/guests/{id}
DELETE http://127.0.0.1:8000/api/rsvps/{id}
DELETE http://127.0.0.1:8000/api/mailings/{id}
DELETE http://127.0.0.1:8000/api/aiimage/images/{id}
```

---

## 🔧 Comment corriger dans Postman

### Étape 1: Sélectionner la bonne méthode
1. Ouvrez Postman
2. En haut à gauche, vous verrez un dropdown avec "GET"
3. Cliquez dessus et sélectionnez **POST**

### Étape 2: Entrer l'URL
```
http://127.0.0.1:8000/api/auth/register
```

### Étape 3: Ajouter le Body (pour POST)
1. Cliquez sur l'onglet "Body"
2. Sélectionnez "raw"
3. Sélectionnez "JSON" dans le dropdown
4. Entrez votre JSON:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Étape 4: Envoyer
Cliquez sur "Send"

---

## 📊 Tableau de Référence Rapide

| Route | Méthode | Action |
|-------|---------|--------|
| /auth/register | **POST** | Créer un utilisateur |
| /auth/login | **POST** | Connecter un utilisateur |
| /auth/logout | **POST** | Déconnecter |
| /auth/me | **GET** | Obtenir le profil |
| /templates | **GET** | Lister les templates |
| /templates | **POST** | Créer un template |
| /templates/{id} | **GET** | Obtenir un template |
| /templates/{id} | **PUT** | Mettre à jour un template |
| /templates/{id} | **DELETE** | Supprimer un template |
| /events | **GET** | Lister les événements |
| /events | **POST** | Créer un événement |
| /aiimage/versions | **GET** | Obtenir les versions |
| /aiimage/generate-image | **POST** | Générer une image |
| /aiimage/recent-images | **GET** | Obtenir les images récentes |

---

## ✅ Checklist de Correction

- [ ] Vérifier la méthode HTTP (GET, POST, PUT, DELETE)
- [ ] Vérifier l'URL complète
- [ ] Ajouter le token dans Authorization (si nécessaire)
- [ ] Ajouter le Body en JSON (pour POST/PUT)
- [ ] Vérifier le Content-Type: application/json
- [ ] Cliquer sur Send

---

## 🎯 Résumé

**Les erreurs que tu as reçues signifient:**
1. Tu utilises GET pour une route POST
2. Postman refuse car la méthode n'est pas autorisée
3. Solution: Change GET en POST

**Règle simple:**
- **Créer/Envoyer** = POST
- **Récupérer** = GET
- **Mettre à jour** = PUT
- **Supprimer** = DELETE

---

**Utilise toujours la bonne méthode HTTP!**
