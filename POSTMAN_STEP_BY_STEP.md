# Guide Étape par Étape - Postman

## 🚀 Première Requête: Inscription

### Étape 1: Ouvrir Postman
- Lancez Postman
- Créez une nouvelle requête (Ctrl+N ou Cmd+N)

### Étape 2: Sélectionner la méthode POST
1. En haut à gauche, vous verrez un dropdown (par défaut "GET")
2. Cliquez dessus
3. Sélectionnez **POST**

### Étape 3: Entrer l'URL
```
http://127.0.0.1:8000/api/auth/register
```

### Étape 4: Ajouter les Headers
1. Cliquez sur l'onglet "Headers"
2. Ajoutez:
   - Key: `Content-Type`
   - Value: `application/json`

### Étape 5: Ajouter le Body
1. Cliquez sur l'onglet "Body"
2. Sélectionnez "raw"
3. Dans le dropdown à droite, sélectionnez "JSON"
4. Collez ce JSON:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Étape 6: Envoyer
Cliquez sur le bouton bleu "Send"

### Étape 7: Copier le Token
1. Regardez la réponse en bas
2. Vous verrez un token comme: `"token": "1|abc123..."`
3. Copiez ce token (sans les guillemets)

---

## 🔑 Deuxième Requête: Connexion

### Étape 1: Nouvelle requête
Créez une nouvelle requête (Ctrl+N)

### Étape 2: Sélectionner POST
Dropdown en haut à gauche → POST

### Étape 3: URL
```
http://127.0.0.1:8000/api/auth/login
```

### Étape 4: Headers
- Key: `Content-Type`
- Value: `application/json`

### Étape 5: Body (raw JSON)
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Étape 6: Envoyer
Cliquez "Send"

### Étape 7: Copier le Token
Copiez le token de la réponse

---

## 📋 Troisième Requête: Lister les Templates

### Étape 1: Nouvelle requête
Créez une nouvelle requête

### Étape 2: Sélectionner GET
Dropdown → GET

### Étape 3: URL
```
http://127.0.0.1:8000/api/templates
```

### Étape 4: Authorization
1. Cliquez sur l'onglet "Authorization"
2. Type: Sélectionnez "Bearer Token"
3. Token: Collez votre token

### Étape 5: Envoyer
Cliquez "Send"

---

## ➕ Quatrième Requête: Créer un Template

### Étape 1: Nouvelle requête
Créez une nouvelle requête

### Étape 2: Sélectionner POST
Dropdown → POST

### Étape 3: URL
```
http://127.0.0.1:8000/api/templates
```

### Étape 4: Authorization
1. Onglet "Authorization"
2. Type: "Bearer Token"
3. Token: Votre token

### Étape 5: Headers
- Key: `Content-Type`
- Value: `application/json`

### Étape 6: Body (raw JSON)
```json
{
  "name": "Wedding Template",
  "description": "Beautiful wedding invitation",
  "content": "<html><body>Wedding Invitation</body></html>"
}
```

### Étape 7: Envoyer
Cliquez "Send"

---

## 🎉 Cinquième Requête: Créer un Événement

### Étape 1: Nouvelle requête
Créez une nouvelle requête

### Étape 2: Sélectionner POST
Dropdown → POST

### Étape 3: URL
```
http://127.0.0.1:8000/api/events
```

### Étape 4: Authorization
Bearer Token avec votre token

### Étape 5: Headers
Content-Type: application/json

### Étape 6: Body (raw JSON)
```json
{
  "organization_id": 1,
  "template_id": 1,
  "title": "My Wedding",
  "description": "A beautiful wedding celebration",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris, France",
  "status": "active"
}
```

### Étape 7: Envoyer
Cliquez "Send"

---

## 👥 Sixième Requête: Créer un Invité

### Étape 1: Nouvelle requête
Créez une nouvelle requête

### Étape 2: Sélectionner POST
Dropdown → POST

### Étape 3: URL
```
http://127.0.0.1:8000/api/guests
```

### Étape 4: Authorization
Bearer Token

### Étape 5: Headers
Content-Type: application/json

### Étape 6: Body (raw JSON)
```json
{
  "event_id": 1,
  "name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+33612345678"
}
```

### Étape 7: Envoyer
Cliquez "Send"

---

## 📧 Septième Requête: Créer un Mailing

### Étape 1: Nouvelle requête
Créez une nouvelle requête

### Étape 2: Sélectionner POST
Dropdown → POST

### Étape 3: URL
```
http://127.0.0.1:8000/api/mailings
```

### Étape 4: Authorization
Bearer Token

### Étape 5: Headers
Content-Type: application/json

### Étape 6: Body (raw JSON)
```json
{
  "event_id": 1,
  "subject": "Invitation to our wedding",
  "body": "We are delighted to invite you to our wedding celebration",
  "channel": "email",
  "type": "bulk",
  "recipient_type": "guest"
}
```

### Étape 7: Envoyer
Cliquez "Send"

---

## 🤖 Huitième Requête: Générer une Image

### Étape 1: Nouvelle requête
Créez une nouvelle requête

### Étape 2: Sélectionner POST
Dropdown → POST

### Étape 3: URL
```
http://127.0.0.1:8000/api/aiimage/generate-image
```

### Étape 4: Authorization
Bearer Token

### Étape 5: Headers
Content-Type: application/json

### Étape 6: Body (raw JSON) - OpenAI
```json
{
  "prompt": "A beautiful wedding invitation design with flowers",
  "provider": "openai",
  "model": "dall-e-3",
  "size": "1024x1024",
  "quality": "standard",
  "num_images": 1,
  "event_id": 1
}
```

### Étape 7: Envoyer
Cliquez "Send"

---

## 📊 Résumé des Étapes Communes

### Pour TOUTE requête:
1. ✅ Sélectionner la bonne méthode (GET, POST, PUT, DELETE)
2. ✅ Entrer l'URL correcte
3. ✅ Ajouter Authorization (Bearer Token) - sauf pour register/login
4. ✅ Ajouter Headers (Content-Type: application/json)
5. ✅ Ajouter Body en JSON (pour POST/PUT)
6. ✅ Cliquer "Send"

---

## 🎯 Checklist Rapide

### Avant d'envoyer une requête:
- [ ] Méthode HTTP correcte? (GET/POST/PUT/DELETE)
- [ ] URL correcte?
- [ ] Authorization ajoutée? (sauf register/login)
- [ ] Headers corrects?
- [ ] Body en JSON? (pour POST/PUT)
- [ ] JSON valide? (pas d'erreurs de syntaxe)

---

## 💡 Conseils Postman

### Sauvegarder les requêtes
1. Cliquez sur "Save" en haut à droite
2. Donnez un nom à la requête
3. Créez une collection (ex: "Everblue API")

### Utiliser des variables
1. Cliquez sur l'icône "eye" en haut à droite
2. Cliquez sur "Environments"
3. Créez une variable `token` avec votre token
4. Utilisez `{{token}}` dans Authorization

### Tester rapidement
1. Créez une collection
2. Ajoutez toutes vos requêtes
3. Cliquez sur "Run" pour exécuter toutes les requêtes

---

## ✅ Vous êtes prêt!

Suivez ces étapes et vous pourrez tester tous les endpoints de l'API!

**Besoin d'aide?** Consultez `POSTMAN_QUICK_GUIDE.md` pour plus de détails.
