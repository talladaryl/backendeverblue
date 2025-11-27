# 🚀 Guide d'Exécution des Migrations

## ⚠️ IMPORTANT: Avant de commencer

Assurez-vous que:
1. ✅ La base de données MySQL est en cours d'exécution
2. ✅ Le fichier `.env` est correctement configuré
3. ✅ Les variables de base de données sont correctes:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=everbluenewvelope
   DB_USERNAME=root
   DB_PASSWORD=
   ```

---

## 📋 Méthode 1: Ligne de Commande (Recommandée)

### Étape 1: Ouvrir le terminal
- Windows: Ouvrez PowerShell ou CMD
- Mac/Linux: Ouvrez Terminal

### Étape 2: Naviguer vers le projet
```bash
cd C:\Users\DS\Documents\react\EVERBLUE\EverblueVelope1
```

### Étape 3: Exécuter les migrations
```bash
php artisan migrate
```

### Étape 4: Confirmer
Quand demandé, tapez `yes` ou `y` pour confirmer

**Résultat attendu:**
```
Migration table created successfully.
Migrating: 2024_11_26_000001_create_organizations_table
Migrated:  2024_11_26_000001_create_organizations_table (0.05 seconds)
Migrating: 2024_11_26_000002_create_templates_table
Migrated:  2024_11_26_000002_create_templates_table (0.04 seconds)
...
```

---

## 📋 Méthode 2: Script Batch (Windows)

### Étape 1: Double-cliquer sur le fichier
```
run_migrations.bat
```

Le script exécutera automatiquement les migrations.

---

## 📋 Méthode 3: Script PowerShell (Windows)

### Étape 1: Ouvrir PowerShell
- Appuyez sur `Win + X`
- Sélectionnez "Windows PowerShell (Admin)"

### Étape 2: Naviguer vers le projet
```powershell
cd C:\Users\DS\Documents\react\EVERBLUE\EverblueVelope1
```

### Étape 3: Exécuter le script
```powershell
.\run_migrations.ps1
```

---

## ✅ Vérifier les Migrations

### Après l'e