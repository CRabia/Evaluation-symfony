<?php

namespace App\Controller\admin;

use App\Repository\ArtWorkRepository;
use App\Repository\CategoryRepository;
use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin.index")
     */
    public function index(ArtWorkRepository $artWorkRepository, CategoryRepository $categoryRepository, ExpositionRepository $expositionRepository )
    {
        $categories = $categoryRepository->findAll();
        $expositions = $expositionRepository->findAll();
        $artworks = $artWorkRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'artworks' => $artworks,
            'expositions' => $expositions,
            'categories' => $categories,
        ]);
    }

}
