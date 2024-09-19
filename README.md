# Symfony-Docker-SIO

Ce dépôt permet la création d'un environnement contenerurisé pour développer une application symfony.

Il a été réalisé à partir du dépôt https://github.com/dunglas/symfony-docker, préconisé par Symfony pour le développement dans un conteneur Docker.


# Caratéristiques

* Serveur web [Caddy](https://caddyserver.com/)
* PHP 8.3
* MySQL 8.2
* PhpMyAdmin (latest)
* Symfony 7 (webapp)

 
# Installation

1. Cloner le dépôt

2. Supprimer le dossier .git (il faudra le recréer, via Github Desktop éventuellement)

3. Renommer le dossier comme souhaité (par exemple, sf-gsbveto-docker)

4. Modifier les variables d'environnement suivantes dans le fichier .env :

        PROJECT_NAME
        MYSQL_VERSION
        MYSQL_DATABASE
        MYSQL_ROOT_PASSWORD
        MYSQL_USER
        MYSQL_PASSWORD

5. Changer le nom du réseau dans le fichier compose.yaml (4 occurences)
 
6. Exécutez `docker compose build --no-cache` pour créer l'image

7. Exécutez `docker compose up -d --wait` pour créer les conteneurs et installez l'application Symfony

8. Afficher la page `https://localhost` dans votre navigateur pour vérifier que tout fonctionne

9. Il pourra être nécessaire d'arrêter puis de redémarrer les conteneurs :
    
        docker compose stop
        docker compose up -d --wait

10. Installer le certificat TSL (sos Windows)

* Créer un répertoire temp sur le bureau

* Exécutez la commande (en remplaçant VotreCompte !) : 

        docker compose cp php:/data/caddy/pki/authorities/local/root.crt C:/Users/VotreCompte/Desktop/temp/root.crt

* Pour installer le certificat, ouvrir un terminal en mode adminsitrateur et exécutez la commande (en remplaçant VotreCompte !) :
 
        certutil -addstore -f "ROOT" C:/Users/VotreCompte/Desktop/temp/root.crt

# Principales commandes pour utiliser vos conteneurs
       
* Pour créer/démarrer vos containers : `docker compose up -d –wait`

* Pour arrêter vos containers : `docker compose stop`	

* Pour vous connecter à l’un de vos conteneurs : `docker exec -ti <Nom du container> bash`

* Pour supprimer vos conteneurs : `docker compose down`

* Pour voir la liste des conteneurs démarrés : `docker ps`

 * Pour voir la liste de tous les conteneurs, démarrés ou non : `docker ps -a`   
