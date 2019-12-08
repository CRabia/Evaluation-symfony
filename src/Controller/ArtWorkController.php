<?php

namespace App\Controller;

use App\Entity\ArtWork;
use App\Entity\Category;
use App\Repository\ArtWorkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArtWorkController extends AbstractController
{
    /**
     * @Route("/oeuvres", name="artwork.index")
     */
    public function index(ArtWorkRepository $artWorkRepository, CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        foreach ($categories as $category)
            $artworks[$category->getName()]=$artWorkRepository->findBy(['category'=>$category]);

        return $this->render('ArtWork/index.html.twig',[
            'artworks'=>$artworks
        ]);
    }

    /**
     * @Route("/oeuvre/{artwork}", name="artwork.show")
     */
    public function show($artwork, ArtWorkRepository $artWorkRepository)
    {
        $artWork = $artWorkRepository->find($artwork);
        return $this->render('ArtWork/artwork.html.twig',[
            'artwork'=>$artWork,
        ]);
    }

    /**
     * @Route("/oeuvres/{id}", name="artwork.category")
     */
    public function showby($id, ArtWorkRepository $artWorkRepository)
    {
        $category=$this->getDoctrine()->getRepository(Category::class)->find($id);
        $artWorks[$category->getName()] = $artWorkRepository->findBy(['category'=>$category]);

        return $this->render('ArtWork/index.html.twig',[
            'artworks'=>$artWorks
        ]);
    }
}
