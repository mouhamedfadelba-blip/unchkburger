# Guide de Contribution Git & GitHub

## Méthodologie et Flux de Travail en Équipe

Ce document définit les standards et le flux de travail (**workflow**) obligatoires pour tous les membres de l'équipe de développement.

L'adoption stricte de ce protocole permet de :

* Garantir l'intégrité de la branche principale.
* Éviter les pertes accidentelles de code.
* Faciliter la revue de code par les pairs.
* Maintenir un historique Git propre et compréhensible.

---

# 1. Jour 1 : Configuration Initiale et Premier Clonage

Les étapes suivantes ne doivent être exécutées qu'une seule fois par chaque développeur lors de son intégration au projet.

## Étape 1.1 : Identification locale

Avant toute action, configurez votre identité Git globale afin que vos commits soient correctement attribués à votre compte GitHub.

```bash
git config --global user.name "Votre Prenom NOM"
git config --global user.email "votre.email@exemple.com"
```

---

## Étape 1.2 : Clonage du dépôt

Récupérez l'intégralité du projet sur votre machine locale.

```bash
git clone URL_DU_DEPOT_GITHUB
cd NOM_DU_DOSSIER_PROJET
```

---

## Étape 1.3 : Vérification de la branche par défaut

Assurez-vous que vous êtes positionné sur la branche principale stabilisée.

```bash
git checkout main
```

---

# 2. Flux de Travail Quotidien

Ce cycle de développement doit être répété pour chaque nouvelle fonctionnalité, correction de bug ou modification du projet.

---

## Phase A : Avant de commencer à coder (Routine du matin)

Il est impératif de synchroniser votre environnement local avec les dernières modifications validées par l'équipe afin de minimiser les conflits de fusion (*merge conflicts*).

### 1. Basculer sur la branche principale

```bash
git checkout main
```

### 2. Récupérer les dernières modifications

```bash
git pull origin main
```

### 3. Créer une branche dédiée à votre tâche

```bash
git checkout -b feature/nom-de-votre-tache
```

---

## Phase B : Pendant la session de développement

Effectuez vos modifications de manière modulaire et évitez les commits contenant des changements non liés.

### Vérifier l'état du dépôt

```bash
git status
```

### Ajouter les fichiers modifiés

```bash
git add .
```

### Enregistrer les changements

```bash
git commit -m "feat: integration du formulaire de connexion"
```

---

## Phase C : Fin de tâche – Intégration et Publication

Une fois le développement terminé et testé localement :

### 1. Récupérer les éventuelles mises à jour de `main`

```bash
git pull origin main
```

### 2. Publier votre branche sur GitHub

```bash
git push origin feature/nom-de-votre-tache
```

### 3. Ouvrir une Pull Request (PR)

Depuis l'interface GitHub :

1. Accédez au dépôt.
2. Sélectionnez votre branche.
3. Cliquez sur **Compare & Pull Request**.
4. Rédigez une description claire.
5. Demandez une revue de code.
6. Attendez la validation avant fusion.

---

# 3. Synthèse des Commandes Essentielles

| Fréquence / Moment         | Objectif                      | Commande                                    |
| -------------------------- | ----------------------------- | ------------------------------------------- |
| Jour 1 uniquement          | Télécharger le projet         | `git clone [URL]`                           |
| Chaque matin               | Synchroniser le dépôt local   | `git checkout main && git pull origin main` |
| Avant de coder             | Créer une branche dédiée      | `git checkout -b feature/nom-tache`         |
| Plusieurs fois par session | Sauvegarder l'avancement      | `git add . && git commit -m "..."`          |
| Fin de tâche               | Envoyer le travail sur GitHub | `git push origin feature/nom-tache`         |

---

# 4. Règles de Conduite et Bonnes Pratiques

## 🚫 Interdiction de pousser directement sur `main`

La branche `main` doit toujours rester :

* Stable
* Testée
* Fonctionnelle

Toute modification doit obligatoirement passer par une **Pull Request**.

---

## 🌿 Convention de nommage des branches

Utilisez les préfixes suivants :

### Nouvelle fonctionnalité

```text
feature/nom-fonctionnalite
```

### Correction de bug

```text
bugfix/nom-correction
```

### Documentation

```text
docs/nom-documentation
```

---

## 📝 Messages de commit professionnels

Privilégiez les **Conventional Commits** :

### Fonctionnalité

```bash
git commit -m "feat: ajout du système d'authentification"
```

### Correction

```bash
git commit -m "fix: correction du bug de connexion"
```

### Documentation

```bash
git commit -m "docs: mise à jour du guide d'installation"
```

### Refactoring

```bash
git commit -m "refactor: simplification du composant utilisateur"
```

---

# Workflow Résumé

```text
main
  │
  ├── git pull origin main
  │
  └── feature/ma-tache
          │
          ├── git add .
          ├── git commit
          ├── git push
          │
          └── Pull Request
                    │
                    ▼
                  main
```

---

## Rappel Important

✅ Toujours partir de `main` à jour.

✅ Toujours créer une branche dédiée.

✅ Faire des commits réguliers et explicites.

✅ Ouvrir une Pull Request pour chaque tâche.

❌ Ne jamais pousser directement sur `main`.

❌ Ne jamais fusionner du code non testé.

❌ Ne jamais travailler directement sur la branche principale.
