<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class ArticleController extends AbstractController
{
    /**
     * @JMS\Serializer\Annotation\Type("string")
     */
    private $articleDeserializer;

    /**
     * @Route("/articles/list", name="article_list", methods={"GET"})
     */
    public function index(
                        SerializerInterface $serializer,
                        ArticleRepository $repo
                    )
    {
        $articles = $repo->findAll();
        $data = $serializer->serialize($articles, 'json', SerializationContext::create()->setGroups(['list']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response; 
    }

    /**
     * @Route("/articles/{id}", name="article_show", methods={"GET"})
     */
    public function show(
                            $id,
                            SerializerInterface $serializer,
                            ArticleRepository $repo
                        )
    {
        $article = $repo->find($id);
        $data = $serializer->serialize($article, 'json', SerializationContext::create()->setGroups(['show_one']));
                                    // donnée    ,format,  choix du groupe de serialisation (dans Article) qu'on veut appelé

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/articles", name="article_create", methods={"POST", "GET"})
     */
    public function create(
                            EntityManagerInterface $manager, 
                            Request $request,
                            SerializerInterface $serializer
                        )
    {
        $data = $request->getContent();
        $this->articleDeserializer = $serializer->deserialize($data, 'App\Entity\Article', 'json');

        $manager->persist($this->articleDeserializer);
        $manager->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}
