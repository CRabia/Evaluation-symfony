<?php

namespace App\Controller\admin;

use App\Entity\ArtWork;
use App\Form\ArtWorkType;
use App\Repository\ArtWorkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileService;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/artwork")
 */
class ArtWorkController extends AbstractController
{
    /**
     * @Route("/", name="admin.artwork.index")
     */
    public function index(ArtWorkRepository $artWorkRepository)
    {
        $results = $artWorkRepository->findAll();

        return $this->render('admin/artwork/index.html.twig', [
            'artworks' => $results
        ]);
    }

    /**
     * @Route("/form", name="admin.artwork.form")
     * @Route("/form/update/{id}", name="admin.artwork.form.update")
     */
    public function edit(Request $request, ArtWorkRepository $artWorkRepository, EntityManagerInterface $entityManager, int $id = null)
    {
        $model = $id ? $artWorkRepository->find($id) : new ArtWork();
        $type = ArtWorkType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message = $model->getId() ? "L'oeuvre a été modifié" : "L'oeuvre a été ajouté";

            $this->addFlash('notice', $message);
            $model->getId() ? null : $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('admin.artwork.index');
        }

        return $this->render('admin/artwork/artwork-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
