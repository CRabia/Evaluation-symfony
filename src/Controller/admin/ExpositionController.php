<?php

namespace App\Controller\admin;

use App\Entity\ArtWork;
use App\Entity\Exposition;
use App\Form\ArtWorkType;
use App\Form\ExpositionType;
use App\Repository\ArtWorkRepository;
use App\Repository\ExpositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/exposition")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="admin.expo.index")
     */
    public function index(ExpositionRepository $expositionRepository)
    {
        $results = $expositionRepository->findAll();

        return $this->render('admin/expo/index.html.twig', [
            'expositions' => $results
        ]);
    }

    /**
     * @Route("/form", name="admin.expo.form")
     * @Route("/form/update/{id}", name="admin.expo.form.update")
     */
    public function edit(Request $request, ExpositionRepository $expositionRepository, EntityManagerInterface $entityManager, int $id = null)
    {
        $model = $id ? $expositionRepository->find($id) : new Exposition();
        $type = ExpositionType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message = $model->getId() ? "L'exposition a été modifié" : "L'exposition a été ajouté";

            $this->addFlash('notice', $message);
            $model->getId() ? null : $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('admin.expo.index');
        }

        return $this->render('admin/expo/expo-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
