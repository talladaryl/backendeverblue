# Guide Rapide - Tester sur Postman

## 🚀 Démarrage rapide

### Base URL
```
http://127.0.0.1:8000/api
```

---

## 📋 ENDPOINTS RAPIDES À COPIER-COLLER

### 1️⃣ AUTHENTIFICATION

**Inscription:**
```
POST http://127.0.0.1:8000/api/auth/register
```

**Connexion:**
```
POST http://127.0.0.1:8000/api/auth/login
```

**Profil:**
```
GET http://127.0.0.1:8000/api/auth/me
```

---

### 2️⃣ TEMPLATES

```
GET http://127.0.0.1:8000/api/templates
POST http://127.0.0.1:8000/api/templates
GET http://127.0.0.1:8000/api/templates/1
PUT http://127.0.0.1:8000/api/templates/1
DELETE http://127.0.0.1:8000/api/templates/1
```

---

### 3️⃣ ÉVÉNEMENTS

```
GET http://127.0.0.1:8000/api/events
POST http://127.0.0.1:8000/api/events
GET http://127.0.0.1:8000/api/events/1
PUT http://127.0.0.1:8000/api/events/1
DELETE http://127.0.0.1:8000/api/events/1
```

---

### 4️⃣ INVITÉS

```
GET http://127.0.0.1:8000/api/guests
POST http://127.0.0.1:8000/api/guests
GET http://127.0.0.1:8000/api/guests/1
PUT http://127.0.0.1:8000/api/guests/1
DELETE http://127.0.0.1:8000/api/guests/1
POST http://127.0.0.1:8000/api/events/1/guests/import
```

---

### 5️⃣ RSVP

```
GET http://127.0.0.1:8000/api/rsvps
POST http://127.0.0.1:8000/api/rsvps
GET http://127.0.0.1:8000/api/rsvps/1
PUT http://127.0.0.1:8000/api/rsvps/1
DELETE http://127.0.0.1:8000/api/rsvps/1
```

---

### 6️⃣ MAILING

```
GET http://127.0.0.1:8000/api/mailings
POST http://127.0.0.1:8000/api/mailings
GET http://127.0.0.1:8000/api/mailings/1
PUT http://127.0.0.1:8000/api/mailings/1
DELETE http://127.0.0.1:8000/api/mailings/1
POST http://127.0.0.1:8000/api/mailings/1/send
POST http://127.0.0.1:8000/api/mailings/1/test
GET http://127.0.0.1:8000/api/events/1/mailings/statistics
```

---

### 7️⃣ TICKETS

```
GET http://127.0.0.1:8000/api/tickets
POST http://127.0.0.1:8000/api/tickets
GET http://127.0.0.1:8000/api/tickets/1
PUT http://127.0.0.1:8000/api/tickets/1
DELETE http://127.0.0.1:8000/api/tickets/1
```

---

### 8️⃣ ASSETS

```
GET http://127.0.0.1:8000/api/assets
POST http://127.0.0.1:8000/api/assets
GET http://127.0.0.1:8000/api/assets/1
PUT http://127.0.0.1:8000/api/assets/1
DELETE http://127.0.0.1:8000/api/assets/1
```

---

### 9️⃣ PAIEMENTS

```
GET http://127.0.0.1:8000/api/payments
POST http://127.0.0.1:8000/api/payments
GET http://127.0.0.1:8000/api/payments/1
PUT http://127.0.0.1:8000/api/payments/1
DELETE http://127.0.0.1:8000/api/payments/1
```

---

### 🔟 IMAGES IA

```
GET http://127.0.0.1:8000/api/aiimage/versions
GET http://127.0.0.1:8000/api/aiimage/check-availability
POST http://127.0.0.1:8000/api/aiimage/generate-image
GET http://127.0.0.1:8000/api/aiimage/recent-images
GET http://127.0.0.1:8000/api/aiimage/usage
GET http://127.0.0.1:8000/api/aiimage/images/1
DELETE http://127.0.0.1:8000/api/aiimage/images/1
```

---

## 📝 BODIES JSON RAPIDES

### Inscription
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Connexion
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Créer un événement
```json
{
  "organization_id": 1,
  "title": "Wedding Party",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris"
}
```

### Créer un invité
```json
{
  "event_id": 1,
  "name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+33612345678"
}
```

### Créer un mailing
```json
{
  "event_id": 1,
  "subject": "Invitation",
  "body": "You are invited!",
  "channel": "email"
}
```

### Générer une image (OpenAI)
```json
{
  "prompt": "A beautiful wedding invitation",
  "provider": "openai",
  "model": "dall-e-3",
  "size": "1024x1024"
}
```

### Générer une image (Gamma)
```json
{
  "prompt": "A beautiful wedding invitation",
  "provider": "gamma",
  "style": "artistic",
  "size": "1024x1024"
}
```

---

## ✅ TOTAL: 50+ ENDPOINTS TESTABLES

Tous les endpoints sont prêts à être testés sur Postman!

Consultez `POSTMAN_ENDPOINTS.md` pour la documentation complète.
