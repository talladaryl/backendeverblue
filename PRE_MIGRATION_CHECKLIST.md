# Checklist Pré-Migration

## ✅ Avant d'exécuter les migrations

### 1. Configuration de la base de données

Vérifiez que `.env` contient:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=everbluenewvelope
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Créer la base de données (si elle n'existe pas)

```sql
CREATE DATABASE everbluenewvelope CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Vérifier la connexion

```bash
php artisan tinker
# Puis tapez: DB::connection()->getPdo();
# Vous devriez voir une connexion réussie
```

### 4. Vérifier les migrations existantes

```bash
php artisan migrate:status
```

### 5. Vérifier les fichiers de migration

Tous les fichiers de migration doivent être dans `database/migrations/`:

- ✅ 2024_11_26_000001_create_organizations_table.php
- ✅ 2024_11_26_000002_create_templates_table.php
- ✅ 2024_11_26_000003_create_events_table.php
- ✅ 2024_11_26_000004_create_guests_table.php
- ✅ 2024_11_26_000005_create_rsvps_table.php
- ✅ 2024_11_26_000006_create_mailings_table.php
- ✅ 2024_11_26_000007_create_tickets_table.php
- ✅ 2024_11_26_000008_create_assets_table.php
- ✅ 2024_11_26_000009_create_payments_table.php
- ✅ 2024_11_26_000010_create_generated_images_table.php

## 🚀 Exécuter les migrations

```bash
php artisan migrate
```

## ✅ Après les migrations

### 1. Vérifier le statut

```bash
php artisan migrate:status
```

Tous les fichiers doivent afficher "Ran".

### 2. Vérifier les tables

```bash
php artisan tinker
# Puis tapez: DB::select('SHOW TABLES;');
```

### 3. Vérifier les colonnes

```bash
php artisan tinker
# Puis tapez: DB::select('DESCRIBE organizations;');
```

### 4. Tester les modèles

```bash
php artisan tinker
# Puis tapez: App\Models\User::count();
```

## 📊 Tables créées

| Table | Colonnes | Relations |
|-------|----------|-----------|
| organizations | 5 | user_id → users |
| templates | 5 | - |
| events | 8 | organization_id, template_id |
| guests | 8 | event_id |
| rsvps | 5 | guest_id |
| mailings | 15 | event_id |
| tickets | 5 | event_id, guest_id |
| assets | 5 | event_id |
| payments | 6 | event_id, guest_id |
| generated_images | 14 | user_id, event_id |

## 🔍 Vérification des relations

### Organizations
- Appartient à: User
- Contient: Events

### Events
- Appartient à: Organization, Template
- Contient: Guests, Mailings, Tickets, Assets, Payments

### Guests
- Appartient à: Event
- Contient: RSVPs, Tickets, Payments

### Mailings
- Appartient à: Event

### Tickets
- Appartient à: Event, Guest

### Assets
- Appartient à: Event

### Payments
- Appartient à: Event, Guest

### GeneratedImages
- Appartient à: User, Event

## 🐛 Dépannage

### Erreur: "Base de données n'existe pas"
```bash
# Créer la base de données
mysql -u root -p
CREATE DATABASE everbluenewvelope CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Erreur: "Connexion refusée"
- Vérifiez que MySQL est en cours d'exécution
- Vérifiez les paramètres de connexion dans `.env`
- Vérifiez le port MySQL (défaut: 3306)

### Erreur: "Syntax error"
- Vérifiez la version de MySQL (5.7+)
- Vérifiez que les colonnes JSON sont supportées
- Vérifiez les fichiers de migration

### Erreur: "Foreign key constraint fails"
- Vérifiez que les tables parent existent
- Vérifiez l'ordre des migrations
- Vérifiez que les IDs correspondent

## 📝 Commandes utiles

```bash
# Voir le statut des migrations
php artisan migrate:status

# Annuler la dernière migration
php artisan migrate:rollback

# Annuler toutes les migrations
php artisan migrate:reset

# Réinitialiser et relancer
php artisan migrate:refresh

# Réinitialiser avec seed
php artisan migrate:refresh --seed

# Voir les migrations en attente
php artisan migrate:status | grep Pending
```

## ✨ Prochaines étapes

1. ✅ Exécuter les migrations
2. ✅ Vérifier les tables
3. ✅ Tester les modèles
4. ✅ Créer des seeders (optionnel)
5. ✅ Tester les endpoints API

---

**Vous êtes prêt à exécuter les migrations!**
