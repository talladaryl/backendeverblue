# Guide Rapide Postman - Méthodes HTTP Correctes

## ⚠️ ERREURS COURANTES

### Erreur 1: "The GET method is not supported for route api/auth/register"
**Cause**: Tu utilises GET au lieu de POST
**Solution**: Utilise POST

### Erreur 2: "The GET method is not supported for route api/aiimage/generate-image"
**Cause**: Tu utilises GET au lieu de POST
**Solution**: Utilise POST

---

## 🔑 AUTHENTIFICATION (SANS TOKEN)

### 1. Inscription - ✅ POST (PAS GET!)
```
POST http://127.0.0.1:8000/api/auth/register
```
**Headers:**
```
Content-Type: application/json
```
**Body (raw JSON):**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```
**Réponse:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123..."
}
```

### 2. Connexion - ✅ POST (PAS GET!)
```
POST http://127.0.0.1:8000/api/auth/login
```
**Headers:**
```
Content-Type: application/json
```
**Body (raw JSON):**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```
**Réponse:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123..."
}
```

**⚠️ IMPORTANT**: Copie le token pour les prochaines requêtes!

---

## 🔐 AVEC TOKEN (Après connexion)

### Configuration Postman
1. Allez à l'onglet "Authorization"
2. Sélectionnez "Bearer Token"
3. Collez votre token dans le champ "Token"

OU ajoutez manuellement le header:
```
Authorization: Bearer YOUR_TOKEN
```

---

## 📋 TEMPLATES

### GET - Lister tous les templates
```
GET http://127.0.0.1:8000/api/templates
```
**Méthode**: GET ✅

### POST - Créer un template
```
POST http://127.0.0.1:8000/api/templates
```
**Méthode**: POST ✅
**Body:**
```json
{
  "name": "Wedding Template",
  "description": "Beautiful wedding invitation",
  "content": "<html>...</html>"
}
```

### GET - Obtenir un template
```
GET http://127.0.0.1:8000/api/templates/1
```
**Méthode**: GET ✅

### PUT - Mettre à jour un template
```
PUT http://127.0.0.1:8000/api/templates/1
```
**Méthode**: PUT ✅
**Body:**
```json
{
  "name": "Updated Template"
}
```

### DELETE - Supprimer un template
```
DELETE http://127.0.0.1:8000/api/templates/1
```
**Méthode**: DELETE ✅

---

## 🎉 ÉVÉNEMENTS

### GET - Lister tous les événements
```
GET http://127.0.0.1:8000/api/events
```
**Méthode**: GET ✅

### POST - Créer un événement
```
POST http://127.0.0.1:8000/api/events
```
**Méthode**: POST ✅
**Body:**
```json
{
  "organization_id": 1,
  "template_id": 1,
  "title": "Wedding Party",
  "description": "A beautiful wedding",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris, France",
  "status": "active"
}
```

### GET - Obtenir un événement
```
GET http://127.0.0.1:8000/api/events/1
```
**Méthode**: GET ✅

### PUT - Mettre à jour un événement
```
PUT http://127.0.0.1:8000/api/events/1
```
**Méthode**: PUT ✅
**Body:**
```json
{
  "title": "Updated Title"
}
```

### DELETE - Supprimer un événement
```
DELETE http://127.0.0.1:8000/api/events/1
```
**Méthode**: DELETE ✅

---

## 👥 INVITÉS

### GET - Lister tous les invités
```
GET http://127.0.0.1:8000/api/guests
```
**Méthode**: GET ✅

### POST - Créer un invité
```
POST http://127.0.0.1:8000/api/guests
```
**Méthode**: POST ✅
**Body:**
```json
{
  "event_id": 1,
  "name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+33612345678"
}
```

### POST - Importer des invités en masse
```
POST http://127.0.0.1:8000/api/events/1/guests/import
```
**Méthode**: POST ✅
**Body:**
```json
{
  "guests": [
    {
      "name": "Guest 1",
      "email": "guest1@example.com",
      "phone": "+33612345678"
    },
    {
      "name": "Guest 2",
      "email": "guest2@example.com",
      "phone": "+33687654321"
    }
  ]
}
```

---

## ✅ RSVP

### GET - Lister tous les RSVP
```
GET http://127.0.0.1:8000/api/rsvps
```
**Méthode**: GET ✅

### POST - Créer un RSVP
```
POST http://127.0.0.1:8000/api/rsvps
```
**Méthode**: POST ✅
**Body:**
```json
{
  "guest_id": 1,
  "status": "accepted",
  "response_date": "2024-11-26T10:00:00Z",
  "notes": "Will attend"
}
```

---

## 📧 MAILING

### GET - Lister tous les mailings
```
GET http://127.0.0.1:8000/api/mailings
```
**Méthode**: GET ✅

### POST - Créer un mailing
```
POST http://127.0.0.1:8000/api/mailings
```
**Méthode**: POST ✅
**Body:**
```json
{
  "event_id": 1,
  "subject": "Invitation",
  "body": "You are invited!",
  "channel": "email",
  "recipient_type": "guest"
}
```

### POST - Envoyer un mailing
```
POST http://127.0.0.1:8000/api/mailings/1/send
```
**Méthode**: POST ✅
**Body**: {} (vide)

### POST - Tester un mailing
```
POST http://127.0.0.1:8000/api/mailings/1/test
```
**Méthode**: POST ✅
**Body:**
```json
{
  "recipient": "test@example.com"
}
```

### GET - Statistiques de mailing
```
GET http://127.0.0.1:8000/api/events/1/mailings/statistics
```
**Méthode**: GET ✅

---

## 🎫 TICKETS

### GET - Lister tous les tickets
```
GET http://127.0.0.1:8000/api/tickets
```
**Méthode**: GET ✅

### POST - Créer un ticket
```
POST http://127.0.0.1:8000/api/tickets
```
**Méthode**: POST ✅
**Body:**
```json
{
  "event_id": 1,
  "guest_id": 1,
  "ticket_number": "TICKET-001",
  "status": "active"
}
```

---

## 🖼️ ASSETS

### GET - Lister tous les assets
```
GET http://127.0.0.1:8000/api/assets
```
**Méthode**: GET ✅

### POST - Créer un asset
```
POST http://127.0.0.1:8000/api/assets
```
**Méthode**: POST ✅
**Body:**
```json
{
  "event_id": 1,
  "name": "Wedding Photo",
  "type": "image",
  "url": "https://example.com/photo.jpg"
}
```

---

## 💳 PAIEMENTS

### GET - Lister tous les paiements
```
GET http://127.0.0.1:8000/api/payments
```
**Méthode**: GET ✅

### POST - Créer un paiement
```
POST http://127.0.0.1:8000/api/payments
```
**Méthode**: POST ✅
**Body:**
```json
{
  "event_id": 1,
  "guest_id": 1,
  "amount": 150.00,
  "status": "pending"
}
```

---

## 🤖 GÉNÉRATION D'IMAGES IA

### GET - Obtenir les versions disponibles
```
GET http://127.0.0.1:8000/api/aiimage/versions
```
**Méthode**: GET ✅

### GET - Vérifier les générations actives
```
GET http://127.0.0.1:8000/api/aiimage/check-availability
```
**Méthode**: GET ✅

### POST - Générer une image (OpenAI)
```
POST http://127.0.0.1:8000/api/aiimage/generate-image
```
**Méthode**: POST ✅ (PAS GET!)
**Body:**
```json
{
  "prompt": "A beautiful wedding invitation design",
  "provider": "openai",
  "model": "dall-e-3",
  "size": "1024x1024",
  "quality": "standard",
  "num_images": 1,
  "event_id": 1
}
```

### POST - Générer une image (Gamma)
```
POST http://127.0.0.1:8000/api/aiimage/generate-image
```
**Méthode**: POST ✅ (PAS GET!)
**Body:**
```json
{
  "prompt": "A beautiful wedding invitation design",
  "provider": "gamma",
  "style": "artistic",
  "size": "1024x1024",
  "quality": "high",
  "num_images": 1,
  "event_id": 1
}
```

### GET - Obtenir les images récentes
```
GET http://127.0.0.1:8000/api/aiimage/recent-images?limit=10
```
**Méthode**: GET ✅

### GET - Obtenir l'utilisation des crédits
```
GET http://127.0.0.1:8000/api/aiimage/usage
```
**Méthode**: GET ✅

### GET - Obtenir une image spécifique
```
GET http://127.0.0.1:8000/api/aiimage/images/1
```
**Méthode**: GET ✅

### DELETE - Supprimer une image
```
DELETE http://127.0.0.1:8000/api/aiimage/images/1
```
**Méthode**: DELETE ✅

---

## 📊 TABLEAU DES MÉTHODES HTTP

| Endpoint | Méthode | Exemple |
|----------|---------|---------|
| /auth/register | **POST** | POST http://127.0.0.1:8000/api/auth/register |
| /auth/login | **POST** | POST http://127.0.0.1:8000/api/auth/login |
| /auth/logout | **POST** | POST http://127.0.0.1:8000/api/auth/logout |
| /auth/me | **GET** | GET http://127.0.0.1:8000/api/auth/me |
| /templates | **GET** | GET http://127.0.0.1:8000/api/templates |
| /templates | **POST** | POST http://127.0.0.1:8000/api/templates |
| /templates/{id} | **GET** | GET http://127.0.0.1:8000/api/templates/1 |
| /templates/{id} | **PUT** | PUT http://127.0.0.1:8000/api/templates/1 |
| /templates/{id} | **DELETE** | DELETE http://127.0.0.1:8000/api/templates/1 |
| /events | **GET** | GET http://127.0.0.1:8000/api/events |
| /events | **POST** | POST http://127.0.0.1:8000/api/events |
| /guests | **GET** | GET http://127.0.0.1:8000/api/guests |
| /guests | **POST** | POST http://127.0.0.1:8000/api/guests |
| /rsvps | **GET** | GET http://127.0.0.1:8000/api/rsvps |
| /rsvps | **POST** | POST http://127.0.0.1:8000/api/rsvps |
| /mailings | **GET** | GET http://127.0.0.1:8000/api/mailings |
| /mailings | **POST** | POST http://127.0.0.1:8000/api/mailings |
| /mailings/{id}/send | **POST** | POST http://127.0.0.1:8000/api/mailings/1/send |
| /mailings/{id}/test | **POST** | POST http://127.0.0.1:8000/api/mailings/1/test |
| /tickets | **GET** | GET http://127.0.0.1:8000/api/tickets |
| /tickets | **POST** | POST http://127.0.0.1:8000/api/tickets |
| /assets | **GET** | GET http://127.0.0.1:8000/api/assets |
| /assets | **POST** | POST http://127.0.0.1:8000/api/assets |
| /payments | **GET** | GET http://127.0.0.1:8000/api/payments |
| /payments | **POST** | POST http://127.0.0.1:8000/api/payments |
| /aiimage/versions | **GET** | GET http://127.0.0.1:8000/api/aiimage/versions |
| /aiimage/generate-image | **POST** | POST http://127.0.0.1:8000/api/aiimage/generate-image |
| /aiimage/recent-images | **GET** | GET http://127.0.0.1:8000/api/aiimage/recent-images |
| /aiimage/usage | **GET** | GET http://127.0.0.1:8000/api/aiimage/usage |

---

## ✅ RÉSUMÉ

### Règles importantes:
1. **POST** = Créer ou envoyer des données
2. **GET** = Récupérer des données
3. **PUT** = Mettre à jour des données
4. **DELETE** = Supprimer des données

### Endpoints qui nécessitent POST:
- ✅ `/api/auth/register` - POST
- ✅ `/api/auth/login` - POST
- ✅ `/api/aiimage/generate-image` - POST
- ✅ `/api/mailings/{id}/send` - POST
- ✅ `/api/mailings/{id}/test` - POST

### Endpoints qui nécessitent GET:
- ✅ `/api/auth/me` - GET
- ✅ `/api/aiimage/versions` - GET
- ✅ `/api/aiimage/recent-images` - GET
- ✅ `/api/aiimage/usage` - GET

---

**Utilise toujours la bonne méthode HTTP!**
