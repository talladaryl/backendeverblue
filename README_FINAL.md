# 🎉 Everblue Envelope API - Guide Complet

## ✅ État: PRÊT POUR LES TESTS

---

## 📚 Documentation Disponible

### 1. **POSTMAN_STEP_BY_STEP.md** ⭐ COMMENCEZ ICI
Guide étape par étape pour tester chaque endpoint dans Postman

### 2. **POSTMAN_QUICK_GUIDE.md**
Guide rapide avec tous les endpoints et les bonnes méthodes HTTP

### 3. **SOLUTION_ERREURS_HTTP.md**
Solutions aux erreurs HTTP courantes (GET vs POST, etc.)

### 4. **POSTMAN_ENDPOINTS.md**
Liste complète de tous les endpoints avec exemples

### 5. **CODE_VERIFICATION_REPORT.md**
Rapport de vérification du code (tous les endpoints vérifiés)

### 6. **COMPLETE_API_VERIFICATION.md**
Vérification complète de l'API

### 7. **TESTING_GUIDE.md**
Guide de test complet avec exemples cURL et JavaScript

---

## 🚀 Démarrage Rapide

### 1. Exécuter les migrations
```bash
php artisan migrate
```

### 2. Démarrer le serveur
```bash
php artisan serve
```

### 3. Ouvrir Postman
- Téléchargez Postman: https://www.postman.com/downloads/
- Créez une nouvelle requête

### 4. Tester le premier endpoint
```
POST http://127.0.0.1:8000/api/auth/register
```

Consultez **POSTMAN_STEP_BY_STEP.md** pour les détails!

---

## 📋 Endpoints Disponibles (50+)

### Authentification
- POST `/api/auth/register` - Inscription
- POST `/api/auth/login` - Connexion
- POST `/api/auth/logout` - Déconnexion
- GET `/api/auth/me` - Profil utilisateur

### Ressources CRUD
- `/api/templates` - Templates
- `/api/events` - Événements
- `/api/guests` - Invités
- `/api/rsvps` - RSVP
- `/api/mailings` - Mailings
- `/api/tickets` - Tickets
- `/api/assets` - Assets
- `/api/payments` - Paiements

### Fonctionnalités Spéciales
- POST `/api/mailings/{id}/send` - Envoyer un mailing
- POST `/api/mailings/{id}/test` - Tester un mailing
- GET `/api/events/{id}/mailings/statistics` - Statistiques
- POST `/api/events/{id}/guests/import` - Import en masse

### Génération d'Images IA
- GET `/api/aiimage/versions` - Versions disponibles
- POST `/api/aiimage/generate-image` - Générer une image
- GET `/api/aiimage/recent-images` - Images récentes
- GET `/api/aiimage/usage` - Utilisation des crédits

---

## 🔐 Configuration

### Variables d'environnement (.env)
```env
# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=everbluenewvelope
DB_USERNAME=root
DB_PASSWORD=

# Twilio
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_PHONE_NUMBER=+1234567890
TWILIO_WHATSAPP_NUMBER=whatsapp:+1234567890

# OpenAI
OPENAI_API_KEY=your_key

# Gamma
GAMMA_API_KEY=your_key

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:3000,localhost:8000,localhost:8080
```

---

## 🎯 Flux de Travail Recommandé

### 1. Authentification
```
POST /api/auth/register → Créer un compte
POST /api/auth/login → Se connecter (récupérer le token)
```

### 2. Configuration
```
POST /api/templates → Créer un template
POST /api/events → Créer un événement
```

### 3. Gestion des Invités
```
POST /api/guests → Ajouter des invités
POST /api/events/{id}/guests/import → Import en masse
```

### 4. Communication
```
POST /api/mailings → Créer un mailing
POST /api/mailings/{id}/test → Tester
POST /api/mailings/{id}/send → Envoyer
```

### 5. Génération d'Images
```
GET /api/aiimage/versions → Voir les options
POST /api/aiimage/generate-image → Générer une image
```

---

## 🔑 Authentification Postman

### Méthode 1: Bearer Token
1. Onglet "Authorization"
2. Type: "Bearer Token"
3. Token: Votre token obtenu lors de la connexion

### Méthode 2: Header personnalisé
1. Onglet "Headers"
2. Key: `Authorization`
3. Value: `Bearer YOUR_TOKEN`

---

## 📊 Canaux de Communication

### Email
```json
{
  "channel": "email",
  "subject": "Invitation",
  "body": "You are invited!"
}
```

### SMS
```json
{
  "channel":