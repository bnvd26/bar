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
     * @Route("/bar", name="home")
     */
    public function index(): Response
    {   
        $beers = $this->beerRepo->findById();

        return $this->render('bar/index.html.twig', compact('beers'));
    }

    /**
     * @Route("/beer/{id}", name="show_beer")
     */
    public function showBeer($id): Response
    {   
        $beer = $this->beerRepo->find($id);

        return $this->render('bar/show.html.twig', compact('beer'));
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

    private function beers_api(): Array
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
     * @Route("/statistics", name="statistics")
     */
    public function statitstics()
    {
        $customers = $this->customerRepo->findAll();

        return $this->render('bar/statistics.html.twig', compact('customers'));
    }
}
