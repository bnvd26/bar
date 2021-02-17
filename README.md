# bar

# Lancer le projet
## Si vous avez docker sur votre machine
Tappez la commande suivante à la racine du projet bar
<br>
```sh init.sh```
<br>
Puis rendez vous sur le http://localhost

## Si vous n'avez pas docker
Assurez que votre version de PHP est <= 7.4
<br>
Assurez vous que votre fichier .env est bien configuré avec votre environnement (DATABASE_URL).
<br>
Ensuite
<br>
```composer install```
<br>
```php bin/console doctrine:database:create```
<br>
```php bin/console doctrine:migrations:migrate```
<br>
```php bin/console doctrine:fixtures:load```
<br>
<br>
```npm install && npm run dev```
<br>
Enfin lancez cette commande qui vas vous permettre de démarrer votre serveur :
<br>
```symfony server:start```
<br>
Enfin (tout dépend du port sur lequel vous avez démarrez votre serveur): http://127.0.0.1:8000
# Fixtures

Nous avons décidez partir sur quelque chose de plus structuré pour nos Fixtures pour cela nous avons séparé de façon à ce que chaque Entités ai sa propre Fixtures ceci permet notemment une meilleure organisation pour les dependances entre chacune d'entre elles.

# Pour la partie 1 :

``
public function findCatSpecial(int $id)
{
return $this->createQueryBuilder('c')
->join('c.beers', 'b') // raisonner en terme de relation
->where('b.id = :id')
->setParameter('id', $id)
->andWhere('c.term = :term')
->setParameter('term', 'special')
->getQuery()
->getResult();
}
``

Cette fonction permet de rechercher les bières appertenant à une catégorie spéciale.
(exemple : retrouver toutes les bières appartenant à la catégorie "bio")

# Pour la partie 3 :

Nous avons fait le choix de ne pas mettre la colonne "category_id" car nous retrouver l'id de la catégorie avec la table "Beers" 

# Pour la partie 4 :

Fonction permettant de s'assurer que la biere passée en paramètre est bien une bière appartenant à uen catégorie qui a pour valeur term = 'special'
Un commentaire plus détaillé qui teste la méthode a été laissé dans le BarController à la ligne 121