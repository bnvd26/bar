<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BarController extends AbstractController
{
    public function __construct(HttpClientInterface $client, BeerRepository $beerRepo, CategoryRepository $categoryRepo, CustomerRepository $customerRepo)
    {
        $this->client = $client;
        $this->beerRepo = $beerRepo;
        $this->categoryRepo = $categoryRepo;
        $this->customerRepo = $customerRepo;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $beers = $this->beerRepo->findById();

        return $this->render('bar/index.html.twig', compact('beers'));
    }

    /**
    * @Route("/menu", name="menu")
    */
    public function mainMenu(string $category_id, string $routeName): Response{
        $categories = $this->categoryRepo->findByTerm('normal');

        return $this->render('partials/main_menu.html.twig', ['category_id' => $category_id, 'routeName' => $routeName, 'categories' => $categories ]);
    }

    /**
     * @Route("/beer/{id}", name="showBeer")
     */
    public function showBeer($id): Response
    {
        $beer = $this->beerRepo->find($id);

        return $this->render('beers/show.html.twig', compact('beer'));
    }

    /**
     * @Route("/mention", name="mention")
     */
    public function mention()
    {
        $title = 'Mentions légales';

        return $this->render('bar/mention.html.twig', compact('title'));
    }

    /**
     * @Route("/beers", name="beers")
     */
    public function beers()
    {
        $beers = $this->beers_api()['beers'];

        $title = 'Page des bières';

        return $this->render('beers/index.html.twig', compact('beers', 'title'));
    }

    private function beers_api(): array
    {
        $response = $this->client->request(
            'GET',
            'https://raw.githubusercontent.com/Antoine07/hetic_symfony/main/Introduction/Data/beers.json'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content ;
    }

    /**
     * @Route("/category/{id}", name="showCategory")
     */
    public function showCategory($id)
    {
        $category = $this->categoryRepo->find($id);

        $title = "Détail catégorie";

        return $this->render('categories/show.html.twig', compact('category', 'title'));
    }

    /**
     * @Route("/statistics", name="statistics")
     */
    public function statitstics()
    {
        $customers = $this->customerRepo->findAll();

        return $this->render('bar/statistics.html.twig', compact('customers'));
    }

    /**
     * @Route("/partie-4", name="partie-4")
     */
    public function partie4()
    {
        // Ici on observe que la méthode fournit dans la partie 4 ne fonctionne pas comme il faut. 
        // Effectivement elle devrait se trouver dans le BeerRepository car le paramètre $id est destiné
        // à être l'id d'une biere et non pas l'id d'une categorie. 
        // De plus le fait de mettre cette methode dans le CategoryRepository et non pas dans le BeerRepository, est faisable en soit mais porte à confusion
        // étant donné que le paramètre qu'elle attend est l'id d'une Bière
        // Enfin nous pensons que le fonctionnement global de cette methode était de s'assurer que la
        // bière en question fait bien partie d'une catégorie avec le champ term = special
        dd($this->categoryRepo->findCatSpecial(/* Saisir l'ID d'une biere et non pas d'une categorie*/));
    }
}
