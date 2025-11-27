# Liste Complète des Endpoints API - Postman

## 🔐 Configuration Postman

### Base URL
```
http://127.0.0.1:8000/api
```

### Headers par défaut
```
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN
```

---

## 🔑 AUTHENTIFICATION

### 1. Inscription
```
POST http://127.0.0.1:8000/api/auth/register
```
**Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### 2. Connexion
```
POST http://127.0.0.1:8000/api/auth/login
```
**Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### 3. Obtenir le profil
```
GET http://127.0.0.1:8000/api/auth/me
```
**Headers:** Authorization: Bearer TOKEN

### 4. Déconnexion
```
POST http://127.0.0.1:8000/api/auth/logout
```
**Headers:** Authorization: Bearer TOKEN

### 5. Utilisateur courant
```
GET http://127.0.0.1:8000/api/user
```
**Headers:** Authorization: Bearer TOKEN

---

## 📋 TEMPLATES

### 1. Lister tous les templates
```
GET http://127.0.0.1:8000/api/templates
```

### 2. Créer un template
```
POST http://127.0.0.1:8000/api/templates
```
**Body:**
```json
{
  "name": "Wedding Template",
  "description": "Beautiful wedding invitation template",
  "content": "<html>...</html>"
}
```

### 3. Obtenir un template
```
GET http://127.0.0.1:8000/api/templates/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/templates/1`

### 4. Mettre à jour un template
```
PUT http://127.0.0.1:8000/api/templates/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/templates/1`
**Body:**
```json
{
  "name": "Updated Template",
  "description": "Updated description"
}
```

### 5. Supprimer un template
```
DELETE http://127.0.0.1:8000/api/templates/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/templates/1`

---

## 🎉 ÉVÉNEMENTS

### 1. Lister tous les événements
```
GET http://127.0.0.1:8000/api/events
```

### 2. Créer un événement
```
POST http://127.0.0.1:8000/api/events
```
**Body:**
```json
{
  "organization_id": 1,
  "template_id": 1,
  "title": "Wedding Party",
  "description": "A beautiful wedding celebration",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris, France",
  "status": "active"
}
```

### 3. Obtenir un événement
```
GET http://127.0.0.1:8000/api/events/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/events/1`

### 4. Mettre à jour un événement
```
PUT http://127.0.0.1:8000/api/events/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/events/1`
**Body:**
```json
{
  "title": "Updated Event Title",
  "status": "completed"
}
```

### 5. Supprimer un événement
```
DELETE http://127.0.0.1:8000/api/events/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/events/1`

---

## 👥 INVITÉS

### 1. Lister tous les invités
```
GET http://127.0.0.1:8000/api/guests
```

### 2. Créer un invité
```
POST http://127.0.0.1:8000/api/guests
```
**Body:**
```json
{
  "event_id": 1,
  "name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+33612345678"
}
```

### 3. Obtenir un invité
```
GET http://127.0.0.1:8000/api/guests/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/guests/1`

### 4. Mettre à jour un invité
```
PUT http://127.0.0.1:8000/api/guests/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/guests/1`
**Body:**
```json
{
  "name": "Updated Name",
  "phone": "+33687654321"
}
```

### 5. Supprimer un invité
```
DELETE http://127.0.0.1:8000/api/guests/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/guests/1`

### 6. Importer des invités en masse
```
POST http://127.0.0.1:8000/api/events/{event_id}/guests/import
```
**Exemple:** `POST http://127.0.0.1:8000/api/events/1/guests/import`
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

### 1. Lister tous les RSVP
```
GET http://127.0.0.1:8000/api/rsvps
```

### 2. Créer un RSVP
```
POST http://127.0.0.1:8000/api/rsvps
```
**Body:**
```json
{
  "guest_id": 1,
  "status": "accepted",
  "response_date": "2024-11-26T10:00:00Z",
  "notes": "Will attend with +1"
}
```

### 3. Obtenir un RSVP
```
GET http://127.0.0.1:8000/api/rsvps/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/rsvps/1`

### 4. Mettre à jour un RSVP
```
PUT http://127.0.0.1:8000/api/rsvps/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/rsvps/1`
**Body:**
```json
{
  "status": "declined",
  "notes": "Cannot attend"
}
```

### 5. Supprimer un RSVP
```
DELETE http://127.0.0.1:8000/api/rsvps/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/rsvps/1`

---

## 📧 MAILING

### 1. Lister tous les mailings
```
GET http://127.0.0.1:8000/api/mailings
```

### 2. Créer un mailing
```
POST http://127.0.0.1:8000/api/mailings
```
**Body:**
```json
{
  "event_id": 1,
  "subject": "Invitation to our wedding",
  "body": "We are delighted to invite you",
  "channel": "email",
  "type": "bulk",
  "recipient_type": "guest"
}
```

### 3. Obtenir un mailing
```
GET http://127.0.0.1:8000/api/mailings/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/mailings/1`

### 4. Mettre à jour un mailing
```
PUT http://127.0.0.1:8000/api/mailings/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/mailings/1`
**Body:**
```json
{
  "subject": "Updated Subject",
  "body": "Updated body"
}
```

### 5. Supprimer un mailing
```
DELETE http://127.0.0.1:8000/api/mailings/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/mailings/1`

### 6. Envoyer un mailing
```
POST http://127.0.0.1:8000/api/mailings/{id}/send
```
**Exemple:** `POST http://127.0.0.1:8000/api/mailings/1/send`

### 7. Tester un mailing
```
POST http://127.0.0.1:8000/api/mailings/{id}/test
```
**Exemple:** `POST http://127.0.0.1:8000/api/mailings/1/test`
**Body:**
```json
{
  "recipient": "test@example.com"
}
```

### 8. Obtenir les statistiques de mailing
```
GET http://127.0.0.1:8000/api/events/{event_id}/mailings/statistics
```
**Exemple:** `GET http://127.0.0.1:8000/api/events/1/mailings/statistics`

---

## 🎫 TICKETS

### 1. Lister tous les tickets
```
GET http://127.0.0.1:8000/api/tickets
```

### 2. Créer un ticket
```
POST http://127.0.0.1:8000/api/tickets
```
**Body:**
```json
{
  "event_id": 1,
  "guest_id": 1,
  "ticket_number": "TICKET-001",
  "status": "active"
}
```

### 3. Obtenir un ticket
```
GET http://127.0.0.1:8000/api/tickets/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/tickets/1`

### 4. Mettre à jour un ticket
```
PUT http://127.0.0.1:8000/api/tickets/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/tickets/1`
**Body:**
```json
{
  "status": "used"
}
```

### 5. Supprimer un ticket
```
DELETE http://127.0.0.1:8000/api/tickets/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/tickets/1`

---

## 🖼️ ASSETS

### 1. Lister tous les assets
```
GET http://127.0.0.1:8000/api/assets
```

### 2. Créer un asset
```
POST http://127.0.0.1:8000/api/assets
```
**Body:**
```json
{
  "event_id": 1,
  "name": "Wedding Photo",
  "type": "image",
  "url": "https://example.com/photo.jpg"
}
```

### 3. Obtenir un asset
```
GET http://127.0.0.1:8000/api/assets/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/assets/1`

### 4. Mettre à jour un asset
```
PUT http://127.0.0.1:8000/api/assets/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/assets/1`
**Body:**
```json
{
  "name": "Updated Photo",
  "url": "https://example.com/updated.jpg"
}
```

### 5. Supprimer un asset
```
DELETE http://127.0.0.1:8000/api/assets/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/assets/1`

---

## 💳 PAIEMENTS

### 1. Lister tous les paiements
```
GET http://127.0.0.1:8000/api/payments
```

### 2. Créer un paiement
```
POST http://127.0.0.1:8000/api/payments
```
**Body:**
```json
{
  "event_id": 1,
  "guest_id": 1,
  "amount": 150.00,
  "status": "pending",
  "payment_date": "2024-11-26T10:00:00Z"
}
```

### 3. Obtenir un paiement
```
GET http://127.0.0.1:8000/api/payments/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/payments/1`

### 4. Mettre à jour un paiement
```
PUT http://127.0.0.1:8000/api/payments/{id}
```
**Exemple:** `PUT http://127.0.0.1:8000/api/payments/1`
**Body:**
```json
{
  "status": "completed",
  "payment_date": "2024-11-26T11:00:00Z"
}
```

### 5. Supprimer un paiement
```
DELETE http://127.0.0.1:8000/api/payments/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/payments/1`

---

## 🤖 GÉNÉRATION D'IMAGES IA

### 1. Obtenir les versions disponibles
```
GET http://127.0.0.1:8000/api/aiimage/versions
```

### 2. Vérifier les générations actives
```
GET http://127.0.0.1:8000/api/aiimage/check-availability
```

### 3. Générer une image
```
POST http://127.0.0.1:8000/api/aiimage/generate-image
```
**Body (OpenAI):**
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

**Body (Gamma):**
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

### 4. Obtenir les images récentes
```
GET http://127.0.0.1:8000/api/aiimage/recent-images?limit=10
```

### 5. Obtenir une image spécifique
```
GET http://127.0.0.1:8000/api/aiimage/images/{id}
```
**Exemple:** `GET http://127.0.0.1:8000/api/aiimage/images/1`

### 6. Supprimer une image
```
DELETE http://127.0.0.1:8000/api/aiimage/images/{id}
```
**Exemple:** `DELETE http://127.0.0.1:8000/api/aiimage/images/1`

### 7. Obtenir l'utilisation des crédits
```
GET http://127.0.0.1:8000/api/aiimage/usage
```

---

## 📊 RÉSUMÉ DES ENDPOINTS

| Ressource | GET | POST | PUT | DELETE |
|-----------|-----|------|-----|--------|
| Templates | ✅ | ✅ | ✅ | ✅ |
| Events | ✅ | ✅ | ✅ | ✅ |
| Guests | ✅ | ✅ | ✅ | ✅ |
| RSVPs | ✅ | ✅ | ✅ | ✅ |
| Mailings | ✅ | ✅ | ✅ | ✅ |
| Tickets | ✅ | ✅ | ✅ | ✅ |
| Assets | ✅ | ✅ | ✅ | ✅ |
| Payments | ✅ | ✅ | ✅ | ✅ |

---

## 🔐 AUTHENTIFICATION POSTMAN

### Étape 1: Obtenir le token
1. Allez à l'onglet "Authorization"
2. Sélectionnez "Bearer Token"
3. Collez votre token obtenu lors de la connexion

### Étape 2: Utiliser le token
Tous les endpoints (sauf auth/register et auth/login) nécessitent le token dans le header:
```
Authorization: Bearer YOUR_TOKEN
```

---

## 🧪 ORDRE DE TEST RECOMMANDÉ

1. **Authentification**
   - POST `/api/auth/register`
   - POST `/api/auth/login` (récupérez le token)

2. **Templates**
   - POST `/api/templates` (créer)
   - GET `/api/templates` (lister)

3. **Événements**
   - POST `/api/events` (créer)
   - GET `/api/events` (lister)

4. **Invités**
   - POST `/api/guests` (créer)
   - POST `/api/events/{id}/guests/import` (importer en masse)

5. **RSVP**
   - POST `/api/rsvps` (créer)
   - GET `/api/rsvps` (lister)

6. **Mailing**
   - POST `/api/mailings` (créer)
   - POST `/api/mailings/{id}/test` (tester)
   - POST `/api/mailings/{id}/send` (envoyer)

7. **Images IA**
   - GET `/api/aiimage/versions` (voir les options)
   - POST `/api/aiimage/generate-image` (générer)

---

## ✅ Tous les endpoints sont testables sur Postman!


<!--  -->