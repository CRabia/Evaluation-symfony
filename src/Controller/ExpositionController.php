<?php

namespace App\Controller;

use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExpositionController extends AbstractController
{
    /**
     * @Route("/exposition", name="exposition.index")
     */
    public function index(ExpositionRepository $expositionRepository)
    {
        $date =new \DateTime('now');
        $date->setTime(0,0,0,1);
        $expositions = $expositionRepository->findUncomingExpo($date);
        return $this->render('Exposition/index.html.twig',[
            'expositions'=>$expositions
        ]);
    }
}
