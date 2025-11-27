# Intégration Gamma AI - Génération d'Images

## 📋 Vue d'ensemble

Cette intégration permet de générer des images en utilisant l'API Gamma AI. Le système est complètement intégré dans votre API Laravel avec authentification Sanctum.

## 🔧 Configuration

### 1. Clé API Gamma

Ajoutez votre clé API Gamma dans le fichier `.env`:

```env
GAMMA_API_KEY=your_gamma_api_key_here
```

### 2. Exécuter les migrations

```bash
php artisan migrate
```

Cela créera la table `generated_images` pour stocker les images générées.

## 📚 Endpoints API

### 1. Obtenir les versions et styles disponibles

**GET** `/api/aiimage/versions`

Retourne les versions disponibles, les styles, les tailles et les qualités.

**Réponse:**
```json
{
  "versions": ["gamma-1.0", "gamma-2.0"],
  "styles": ["realistic", "artistic", "cartoon", "abstract", "photorealistic", "oil_painting", "watercolor"],
  "sizes": ["512x512", "768x768", "1024x1024", "1024x576", "576x1024"],
  "qualities": ["low", "medium", "high", "ultra"]
}
```

### 2. Vérifier les générations actives

**GET** `/api/aiimage/check-availability`

Vérifie s'il y a des générations en cours.

**Réponse:**
```json
{
  "isActive": false,
  "activeCount": 0,
  "progress": 0
}
```

### 3. Générer une image

**POST** `/api/aiimage/generate-image`

Génère une ou plusieurs images basées sur un prompt.

**Paramètres:**
```json
{
  "prompt": "A beautiful sunset over the ocean",
  "negative_prompt": "blurry, low quality",
  "style": "photorealistic",
  "size": "1024x1024",
  "quality": "high",
  "num_images": 1,
  "event_id": null
}
```

**Paramètres optionnels:**
- `negative_prompt`: Éléments à éviter dans l'image
- `style`: Style de l'image (défaut: realistic)
- `size`: Taille de l'image (défaut: 1024x1024)
- `quality`: Qualité de l'image (défaut: high)
- `num_images`: Nombre d'images à générer (1-4, défaut: 1)
- `event_id`: ID de l'événement associé (optionnel)

**Réponse (201):**
```json
{
  "status": "success",
  "message": "Images generated successfully",
  "images": [
    {
      "id": 1,
      "user_id": 1,
      "event_id": null,
      "prompt": "A beautiful sunset over the ocean",
      "image_url": "https://...",
      "thumbnail_url": "https://...",
      "style": "photorealistic",
      "size": "1024x1024",
      "quality": "high",
      "status": "completed",
      "ai_model": "gamma",
      "created_at": "2024-11-26T10:30:00Z",
      "updated_at": "2024-11-26T10:30:00Z"
    }
  ],
  "task_id": null
}
```

### 4. Obtenir les images récentes

**GET** `/api/aiimage/recent-images?limit=10`

Retourne les 10 dernières images générées par l'utilisateur.

**Paramètres:**
- `limit`: Nombre d'images à retourner (défaut: 10)

**Réponse:**
```json
{
  "images": [...],
  "total": 5
}
```

### 5. Obtenir une image spécifique

**GET** `/api/aiimage/images/{id}`

Retourne les détails d'une image générée.

**Réponse:**
```json
{
  "id": 1,
  "user_id": 1,
  "prompt": "A beautiful sunset over the ocean",
  "image_url": "https://...",
  "status": "completed",
  "created_at": "2024-11-26T10:30:00Z"
}
```

### 6. Supprimer une image

**DELETE** `/api/aiimage/images/{id}`

Supprime une image générée.

**Réponse:**
```json
{
  "status": "success",
  "message": "Image deleted successfully"
}
```

### 7. Obtenir l'utilisation des crédits

**GET** `/api/aiimage/usage`

Retourne les informations d'utilisation des crédits.

**Réponse:**
```json
{
  "credits": 100,
  "used": 25,
  "remaining": 75
}
```

## 🔐 Authentification

Tous les endpoints AI Image nécessitent une authentification Sanctum:

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
     -H "Content-Type: application/json" \
     -X POST http://localhost:8000/api/aiimage/generate-image \
     -d '{
       "prompt": "A beautiful sunset over the ocean",
       "style": "photorealistic"
     }'
```

## 📦 Structure des fichiers créés

```
app/
├── Services/
│   └── Ai/
│       └── GammaService.php          # Service Gamma API
├── Models/
│   └── GeneratedImage.php            # Modèle pour les images générées
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── AIImageController.php # Contrôleur API
│   └── Requests/
│       └── AIImage/
│           ├── GenerateImageRequest.php
│           └── StoreGeneratedImageRequest.php
└── Providers/
    └── AppServiceProvider.php        # Enregistrement du service

database/
└── migrations/
    └── 2024_11_26_create_generated_images_table.php

config/
└── services.php                      # Configuration des services
```

## 🚀 Exemple d'utilisation

### Avec cURL

```bash
# 1. Authentification
TOKEN=$(curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }' | jq -r '.token')

# 2. Générer une image
curl -X POST http://localhost:8000/api/aiimage/generate-image \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "prompt": "A futuristic city at night",
    "style": "artistic",
    "size": "1024x1024",
    "quality": "high"
  }'

# 3. Obtenir les images récentes
curl -X GET http://localhost:8000/api/aiimage/recent-images \
  -H "Authorization: Bearer $TOKEN"
```

### Avec JavaScript/Fetch

```javascript
// Authentification
const loginResponse = await fetch('http://localhost:8000/api/auth/login', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    password: 'password'
  })
});

const { token } = await loginResponse.json();

// Générer une image
const generateResponse = await fetch('http://localhost:8000/api/aiimage/generate-image', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    prompt: 'A futuristic city at night',
    style: 'artistic',
    size: '1024x1024',
    quality: 'high'
  })
});

const result = await generateResponse.json();
console.log(result);
```

## ⚙️ Configuration avancée

### Personnaliser les styles

Modifiez la méthode `getStyles()` dans `GammaService.php` pour ajouter ou modifier les styles disponibles.

### Gérer les erreurs

Le service gère automatiquement les erreurs API et les enregistre dans les logs:

```
storage/logs/laravel.log
```

### Limiter les générations

Vous pouvez ajouter un rate limiting aux endpoints:

```php
Route::post('/generate-image', [AIImageController::class, 'generateImage'])
    ->middleware('throttle:5,1'); // 5 requêtes par minute
```

## 🔍 Dépannage

### Erreur: "API request failed"

Vérifiez que:
1. La clé API Gamma est correctement configurée dans `.env`
2. La clé API est valide et active
3. Vous avez des crédits disponibles

### Erreur: "Unauthorized"

Assurez-vous que:
1. Vous avez un token d'authentification valide
2. Le token n'a pas expiré
3. Vous accédez à vos propres images

### Erreur: "Invalid prompt"

Le prompt doit:
1. Contenir au moins 5 caractères
2. Ne pas dépasser 1000 caractères
3. Être en texte clair (pas de caractères spéciaux excessifs)

## 📝 Notes importantes

1. **Crédits**: Chaque génération consomme des crédits. Vérifiez votre solde avec `/api/aiimage/usage`
2. **Stockage**: Les images sont stockées dans la base de données avec leurs URLs
3. **Sécurité**: Seul l'utilisateur qui a généré l'image peut la voir ou la supprimer
4. **Performance**: Les générations peuvent prendre quelques secondes

## 🔄 Mise à jour future

Pour ajouter d'autres modèles d'IA:
1. Créez un nouveau service (ex: `OpenAIImageService.php`)
2. Implémentez les mêmes méthodes que `GammaService`
3. Mettez à jour le contrôleur pour supporter le nouveau modèle
4. Ajoutez les routes correspondantes

## 📞 Support

Pour toute question ou problème, consultez:
- Documentation Gamma: https://api.gamma.app/docs
- Documentation Laravel: https://laravel.com/docs
- Logs: `storage/logs/laravel.log`
