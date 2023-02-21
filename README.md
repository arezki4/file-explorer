# file-explorer
Explorteur de fichier en python et Mysql, dans cette explorteur on peut importer des fichiers, creer des dossiers et sous-dossiers et faire des recherche de fichiers grace a une barre de recherche, et on stock le tout dans une base de donnée qu'on gere grace a l'outil PDO de PHP.

<h2>Technologies Utilisé:</h2>

j'ai utilisé du PHP pour le backend, du Mysql pour la base de donnée, le language SQL pour gérer cette derniére et du bootstrap pour le front Pour les outils il faut jute installer apache2 avec MySql et sur windows utiliser Wampp,Lampp avec Phpmyadmin, voici un petit lien pour installer apache2 avec Mysql: https://www.cherryservers.com/blog/how-to-install-linux-apache-mysql-and-php-lamp-stack-on-ubuntu-20-04

<h2>Installation du projet</h2>

Il faut télécharger les bases de donnée qui se trouve dans le fichier sql/Arbo4.sql et sql/Arborescence3.sql avec la ligne de commande suivante: **sudo mysql -u root -p < chemin du projet sur votre machine/sql/Arbo.sql.sql**

2/ mettre a jour le fichier **connexion.php** et **connexion_Arbo4.php** en mettant vos identifiant Mysql afin de vous connecter a la base de donnée, ex: **$db = new PDO('mysql:host=localhost;dbname=Formulaire_Securise',' votre nom d'utilisateur Mysql "généralement c'est root" ','votre mot de passe MySql');**

3/C'est pret le site est operationnel, vous pouvez aller sur votre localhost pour le tester
