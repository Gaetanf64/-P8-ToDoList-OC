# Projet 8 OpenClassRooms - Développeur d'application PHP/Symfony

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/eb1adf2336844b14afa9b29ecf534b9f)](https://www.codacy.com/gh/Gaetanf64/P8-ToDoList-OC/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Gaetanf64/P8-ToDoList-OC&amp;utm_campaign=Badge_Grade)

## Contexte

Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product ou MVP).

Le choix du développeur précédent a été d’utiliser le framework PHP Symfony, un framework que vous commencez à bien connaître ! 

Bonne nouvelle ! ToDo & Co a enfin réussi à lever des fonds pour permettre le développement de l’entreprise et surtout de l’application.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

Ainsi, pour ce dernier projet de spécialisation, vous êtes dans la peau d’un développeur expérimenté en charge des tâches suivantes :

* l’implémentation de nouvelles fonctionnalités ;
* la correction de quelques anomalies ;
* et l’implémentation de tests automatisés.

Il vous est également demandé d’analyser le projet grâce à des outils vous permettant d’avoir une vision d’ensemble de la qualité du code et des différents axes de performance de l’application.

Il ne vous est pas demandé de corriger les points remontés par l’audit de qualité de code et de performance. Cela dit, si le temps vous le permet, ToDo & Co sera ravi que vous réduisiez la dette technique de cette application.

## Installation du projet 

* Cloner le projet avec gitclone 
```
https://github.com/Gaetanf64/P8-ToDoList-OC.git
```

* Installer les dépendances 
```
composer install
```

* Renommer le fichier .env en .env.local
  
* Mettre à jour la base de données en entrant votre nom d'utilisateur et le mot de passe dans le .env.local:
```
DATABASE_URL=mysql://votreusername:votrepassword@127.0.0.1:3306/todolist
```

* Créer la base de données si elle n'existe pas déjà en entrant cette commande à la racine du projet : 
```
php bin/console doctrine:database:create
```

* Créer les tables du projet en appliquant les migrations : 
```
php bin/console make:migration
```

```
php bin/console doctrine:migrations:migrate
```

* Installer les DataFixtures (données initiales) : 
```
php bin/console doctrine:fixtures:load
```


## Utiliser les DataFixtures

Il y a un administrateur pour ce projet:
* username : Gaetan
* password : Gaetan64

Il y a 7 autres users, en voici un
* username : Leo
* passxord : Passuser


## Utiliser les Tests

- Installer Xdebug ([ici](https://xdebug.org/docs/install))
- Entrez la commande suivante pour générer la documentation de couverture de test:
```
vendor\bin\phpunit --coverage-html coverage/   
```

## Utiliser Blackfire

- Installer Blackfire ([ici](https://blackfire.io/docs/up-and-running/installation?action=install&mode=full&version=latest&mode=quick&location=local&os=windows&language=php&agent=1123bc2b-a7e3-4847-936f-0854fc75cdc1))
- Entrez une des commandes suivantes pour lancer ou arrêter Blackfire:
```
sc.exe start Blackfire
```
```
sc.exe stop Blackfire
```