# Guide de Test - API Everblue Envelope

## 🚀 Démarrage rapide

### 1. Configuration initiale

```bash
# Cloner le projet
git clone <repo>
cd everblue-envelope

# Installer les dépendances
composer install
npm install

# Copier l'environnement
cp .env.example .env

# Générer la clé
php artisan key:generate

# Exécuter les migrations
php artisan migrate

# Démarrer le serveur
php artisan serve
```

### 2. Configurer les variables d'environnement

Modifiez `.env`:
```env
TWILIO_SID=your_account_sid
TWILIO_TOKEN=your_auth_token
TWILIO_PHONE_NUMBER=+1234567890
TWILIO_WHATSAPP_NUMBER=whatsapp:+1234567890
GAMMA_API_KEY=your_gamma_api_key
```

## 🧪 Tests avec cURL

### 1. Authentification

#### Inscription
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Réponse attendue:**
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

#### Connexion
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Sauvegardez le token:**
```bash
TOKEN="1|abc123..."
```

#### Obtenir le profil
```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer $TOKEN"
```

### 2. Gestion des événements

#### Créer une organisation
```bash
curl -X POST http://localhost:8000/api/organizations \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "My Company",
    "description": "Event management company"
  }'
```

#### Créer un événement
```bash
curl -X POST http://localhost:8000/api/events \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "organization_id": 1,
    "title": "Wedding Party",
    "description": "A beautiful wedding celebration",
    "event_date": "2024-12-25T18:00:00Z",
    "location": "Paris, France",
    "status": "active"
  }'
```

#### Lister les événements
```bash
curl -X GET http://localhost:8000/api/events \
  -H "Authorization: Bearer $TOKEN"
```

### 3. Gestion des invités

#### Créer un invité
```bash
curl -X POST http://localhost:8000/api/guests \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "phone": "+33612345678"
  }'
```

#### Importer des invités en masse
```bash
curl -X POST http://localhost:8000/api/events/1/guests/import \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
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
  }'
```

### 4. Mailing - Email

#### Créer un mailing email
```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "subject": "Invitation to our wedding",
    "body": "We are delighted to invite you to our wedding celebration",
    "channel": "email",
    "recipient_type": "guest"
  }'
```

#### Envoyer un message de test
```bash
curl -X POST http://localhost:8000/api/mailings/1/test \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "recipient": "test@example.com"
  }'
```

#### Envoyer le mailing
```bash
curl -X POST http://localhost:8000/api/mailings/1/send \
  -H "Authorization: Bearer $TOKEN"
```

### 5. Mailing - SMS

#### Créer un mailing SMS
```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "body": "Reminder: Our wedding is tomorrow at 6 PM!",
    "channel": "sms",
    "recipients": ["+33612345678", "+33687654321"]
  }'
```

#### Envoyer le SMS
```bash
curl -X POST http://localhost:8000/api/mailings/2/send \
  -H "Authorization: Bearer $TOKEN"
```

### 6. Mailing - WhatsApp

#### Créer un mailing WhatsApp
```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "body": "Welcome to our wedding! 🎉",
    "channel": "whatsapp",
    "recipients": ["+33612345678"]
  }'
```

#### Envoyer le WhatsApp
```bash
curl -X POST http://localhost:8000/api/mailings/3/send \
  -H "Authorization: Bearer $TOKEN"
```

### 7. Mailing - MMS

#### Créer un mailing MMS
```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "body": "Here is your wedding invitation",
    "channel": "mms",
    "recipients": ["+33612345678"],
    "media_urls": ["https://example.com/invitation.jpg"]
  }'
```

#### Envoyer le MMS
```bash
curl -X POST http://localhost:8000/api/mailings/4/send \
  -H "Authorization: Bearer $TOKEN"
```

### 8. Statistiques de mailing

#### Obtenir les statistiques
```bash
curl -X GET http://localhost:8000/api/events/1/mailings/statistics \
  -H "Authorization: Bearer $TOKEN"
```

**Réponse attendue:**
```json
{
  "total_mailings": 4,
  "sent": 3,
  "failed": 0,
  "draft": 1,
  "scheduled": 0,
  "by_channel": {
    "email": 1,
    "sms": 1,
    "whatsapp": 1,
    "mms": 1
  },
  "total_sent": 10,
  "total_failed": 0
}
```

### 9. Génération d'images

#### Obtenir les versions disponibles
```bash
curl -X GET http://localhost:8000/api/aiimage/versions \
  -H "Authorization: Bearer $TOKEN"
```

#### Générer une image
```bash
curl -X POST http://localhost:8000/api/aiimage/generate-image \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "prompt": "A beautiful wedding invitation design",
    "style": "artistic",
    "size": "1024x1024",
    "quality": "high",
    "event_id": 1
  }'
```

#### Obtenir les images récentes
```bash
curl -X GET http://localhost:8000/api/aiimage/recent-images?limit=10 \
  -H "Authorization: Bearer $TOKEN"
```

#### Vérifier l'utilisation des crédits
```bash
curl -X GET http://localhost:8000/api/aiimage/usage \
  -H "Authorization: Bearer $TOKEN"
```

## 🧪 Tests avec Postman

### 1. Importer la collection

Créez une nouvelle collection avec les endpoints suivants:

#### Authentification
- POST `/api/auth/register`
- POST `/api/auth/login`
- GET `/api/auth/me`
- POST `/api/auth/logout`

#### Événements
- GET `/api/events`
- POST `/api/events`
- GET `/api/events/{id}`
- PUT `/api/events/{id}`
- DELETE `/api/events/{id}`

#### Invités
- GET `/api/guests`
- POST `/api/guests`
- POST `/api/events/{id}/guests/import`

#### Mailing
- GET `/api/mailings`
- POST `/api/mailings`
- POST `/api/mailings/{id}/send`
- POST `/api/mailings/{id}/test`
- GET `/api/events/{id}/mailings/statistics`

#### Images
- GET `/api/aiimage/versions`
- POST `/api/aiimage/generate-image`
- GET `/api/aiimage/recent-images`
- GET `/api/aiimage/usage`

### 2. Configurer l'authentification

Dans Postman:
1. Allez à l'onglet "Authorization"
2. Sélectionnez "Bearer Token"
3. Collez votre token

## 🧪 Tests avec JavaScript

```javascript
// Configuration
const API_URL = 'http://localhost:8000/api';
let token = null;

// Authentification
async function login() {
  const response = await fetch(`${API_URL}/auth/login`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email: 'john@example.com',
      password: 'password123'
    })
  });
  const data = await response.json();
  token = data.token;
  console.log('Token:', token);
}

// Créer un événement
async function createEvent() {
  const response = await fetch(`${API_URL}/events`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      organization_id: 1,
      title: 'My Event',
      event_date: '2024-12-25T18:00:00Z',
      location: 'Paris'
    })
  });
  return response.json();
}

// Envoyer un email
async function sendEmail(eventId) {
  const mailing = await fetch(`${API_URL}/mailings`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      event_id: eventId,
      subject: 'Invitation',
      body: 'You are invited!',
      channel: 'email',
      recipient_type: 'guest'
    })
  }).then(r => r.json());

  return fetch(`${API_URL}/mailings/${mailing.id}/send`, {
    method: 'POST',
    headers: { 'Authorization': `Bearer ${token}` }
  }).then(r => r.json());
}

// Générer une image
async function generateImage(eventId) {
  return fetch(`${API_URL}/aiimage/generate-image`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      prompt: 'Beautiful wedding invitation',
      style: 'artistic',
      event_id: eventId
    })
  }).then(r => r.json());
}

// Exécuter les tests
async function runTests() {
  await login();
  const event = await createEvent();
  console.log('Event created:', event);
  
  const emailResult = await sendEmail(event.id);
  console.log('Email sent:', emailResult);
  
  const imageResult = await generateImage(event.id);
  console.log('Image generated:', imageResult);
}

runTests();
```

## 📊 Vérification des résultats

### Email
- ✅ Message reçu dans la boîte mail
- ✅ Sujet correct
- ✅ Corps du message correct

### SMS
- ✅ Message reçu sur le téléphone
- ✅ Numéro d'expéditeur correct
- ✅ Contenu du message correct

### WhatsApp
- ✅ Message reçu sur WhatsApp
- ✅ Formatage correct
- ✅ Emojis affichés correctement

### MMS
- ✅ Message reçu avec image
- ✅ Image affichée correctement
- ✅ Texte du message visible

### Images
- ✅ Image générée avec succès
- ✅ URL valide
- ✅ Image téléchargeable

## 🐛 Dépannage

### Erreur: "Unauthorized"
- Vérifiez que le token est valide
- Vérifiez que le token n'a pas expiré
- Vérifiez le format du header Authorization

### Erreur: "Invalid channel"
- Utilisez: email, sms, whatsapp, mms
- Vérifiez l'orthographe

### Erreur: "No recipients found"
- Vérifiez que les destinataires sont spécifiés
- Vérifiez que l'événement a des invités
- Vérifiez le format des numéros de téléphone

### Erreur: "Twilio API Error"
- Vérifiez les clés Twilio dans `.env`
- Vérifiez le solde du compte Twilio
- Vérifiez les logs: `storage/logs/laravel.log`

### Erreur: "Gamma API Error"
- Vérifiez la clé API Gamma dans `.env`
- Vérifiez le solde des crédits
- Vérifiez les logs: `storage/logs/laravel.log`

## 📝 Checklist de test

- [ ] Inscription réussie
- [ ] Connexion réussie
- [ ] Création d'événement réussie
- [ ] Import d'invités réussi
- [ ] Email envoyé avec succès
- [ ] SMS envoyé avec succès
- [ ] WhatsApp envoyé avec succès
- [ ] MMS envoyé avec succès
- [ ] Image générée avec succès
- [ ] Statistiques affichées correctement
- [ ] Tous les endpoints retournent les bons codes HTTP
- [ ] Validation des données fonctionne
- [ ] Gestion des erreurs fonctionne

---

**Tous les tests doivent passer avant le déploiement en production!**
