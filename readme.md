# 💰 Cryptowallet 💰

Cryptowallet est une application web de cryptomonnaie qui sert de portefeuille électronique. Elle permet d'acheter, de vendre, d'envoyer des cryptomonnaies et de consulter l'historique des transactions.

## 🛠️ Technologies Utilisées

- **🐘 PHP 8.2**
- **🌐 Symfony 7**
- **🎨 Bootstrap (Sneat)**
- **📝 Twig**
- **🐬 MySQL**

## ⚙️ Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre machine :

- 🐘 PHP 8.2
- 🎼 Composer
- 📦 Node.js et npm
- 🌐 Symfony CLI
- 🐬 MySQL

## 🚀 Installation

Suivez les étapes ci-dessous pour configurer et démarrer le projet :

1. 📥 Clonez le dépôt :
    ```bash
    https://github.com/johannKionghat/Cryptowallet.git
    cd Cryptowallet
    ```

2. ⚙️ Installez les dépendances PHP :
    ```bash
    composer install
    ```

3. 📦 Installez les dépendances JavaScript et construisez les assets :
    ```bash
    npm install
    npm run build
    ```

4. ✉️ Démarrez le serveur de mail (Mailpit) :
    ```bash
    bin/mailpit
    ```

5. 🗄️ Créez la base de données :
    ```bash
    symfony console doctrine:database:create
    ```

6. 📜 Créez et appliquez les migrations :
    ```bash
    symfony console make:migration
    symfony console doctrine:migrations:migrate
    ```

7. 🔄 Chargez les fixtures de base :
    ```bash
    symfony console doctrine:fixtures:load
    ```

## 👤 Utilisation

L'utilisateur par défaut est :

- **✉️ Email** : `admin@admin.test`
- **🔑 Mot de passe** : `admin`

Lorsqu'un utilisateur crée un nouveau compte, le mot de passe par défaut pour ce compte est `user`.

## 🤝 Contribuer

Les contributions sont les bienvenues ! Veuillez soumettre une pull request ou ouvrir une issue pour discuter de ce que vous souhaitez changer.

---

Merci d'utiliser Cryptowallet ! Si vous avez des questions ou des suggestions, n'hésitez pas à nous contacter. 😊