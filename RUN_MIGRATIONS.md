# 🚀 Exécuter les Migrations

## Commande à exécuter:

```bash
php artisan migrate
```

## Migrations qui seront exécutées:

1. Toutes les migrations existantes (si pas encore exécutées)
2. `2024_11_26_ensure_guests_columns.php` - Ajoute les colonnes manquantes à guests
3. `2024_11_26_ensure_templates_columns.php` - Ajoute le contenu à templates

## Vérifier le statut:

```bash
php artisan migrate:status
```

## Après les migrations:

L'API bulk-send sera prête à fonctionner avec la logique suivante:

1. **Créer un Template** → POST `/api/templates`
2. **Créer un Event** → POST `/api/events` (avec `template_id`)
3. **Ajouter des Guests** → POST `/api/guests` (avec `event_id`)
4. **Prévisualiser** → GET `/bulk-send/preview/{event_id}`
5. **Envoyer en masse** → POST `/bulk-send` (avec `event_id` et `channel`)

---

**Exécutez `php artisan migrate` maintenant!**
