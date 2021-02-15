<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BarController extends AbstractController
{
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/bar", name="home")
     */
    public function index(): Response
    {   
        return $this->render('bar/index.html.twig');
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
}
