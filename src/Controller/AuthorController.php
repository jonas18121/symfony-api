<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * serializer
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * manager
     * @var EntityManagerInterface
     */
    private $managerr;

    public function __construct(
                                    SerializerInterface $serializer,
                                    EntityManagerInterface $manager
                                )
    {
        $this->serializer = $serializer;
        $this->manager = $manager;
    }

    /**
     * @Route("/author", name="author")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }

    /**
     * @Route("/authors/{id}", name="author_show", methods={"GET"})
     */
    public function show(
                            $id, 
                            AuthorRepository $repo
                        )
    {
        $author = $repo->find($id);
        $data = $this->serializer->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/authors", name="author_create", methods={"POST", "GET"})
     */
    public function create(Request $request)
    {
        $data = $request->getContent();

        $author = $this->serializer->deserialize($data, 'App\Entity\Author', 'json');

        $this->manager->persist($author);
        $this->manager->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}
