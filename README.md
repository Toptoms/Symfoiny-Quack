Installer Symfony:

Avant de créer votre première application Symfony, assurez-vous de répondre aux exigences suivantes:

Votre serveur a PHP 7.1 ou supérieur installé (et ces extensions PHP installées et activées par défaut par PHP);
Vous avez installé Composer(https://getcomposer.org/download/) , qui est utilisé pour installer les packages PHP;
Vous avez installé le serveur Web local Symfony (https://symfony.com/doc/current/setup/symfony_server.html), qui fournit tous les outils nécessaires au développement local de votre application.




Lancer votre application Symfony:

En production, vous devez utiliser un serveur Web tel que Nginx ou Apache (reportez-vous à la section configuration d'un serveur Web pour exécuter Symfony ). Mais pour le développement, il est plus pratique d’utiliser le serveur Web local Symfony installé précédemment.

Ce serveur local prend en charge HTTP / 2, TLS / SSL, la génération automatique de certificats de sécurité et de nombreuses autres fonctionnalités. Cela fonctionne avec n'importe quelle application PHP, pas seulement les projets Symfony, c'est donc un outil de développement très utile.

Ouvrez votre terminal, accédez au nouveau répertoire de votre projet et démarrez le serveur Web local comme suit:

 cd my-project/
 symfony server:start
Ouvrez votre navigateur et accédez à http://localhost:8000/. Si tout fonctionne, vous verrez une page d'accueil. Plus tard, lorsque vous avez fini de travailler, arrêtez le serveur en appuyant sur Ctrl+Cdepuis votre terminal.




Mettez en place la base de donnée:

Adaptez le fichier d'environment .env avec le compte et le mot de passe correspondant, et le nom de la basé de donnée voulu .
exemle:
# .env (or override DATABASE_URL in .env.local to avoid committing your changes)

# customize this line!
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"



1)Tout d'abord, installez le support Doctrine via le pack ORM, ainsi que le MakerBundle, qui vous aidera à générer du code:

 composer require symfony/orm-pack
 composer require --dev symfony/maker-bundle
 
 
2)puis effectuez les commandes suivante pour creer une base de donnée:

php bin/console doctrine:database:create


3)En-suite effectuez les commande suivantes pour creer une migration correspondant aux (entity):
 php bin/console make:migration
 
 
 4)Puis poussez les migration dan sla dase de donnée avec la commande suivante:
 
 php bin/console doctrine:migrations:migrate
 
composer require symfony/orm-pack
 composer require --dev symfony/maker-bundle

php bin/console doctrine:database:create