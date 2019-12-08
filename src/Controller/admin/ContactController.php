<?php

namespace App\Controller\admin;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="admin.contact.index")
     */
    public function index(ContactRepository $contactRepository)
    {
        $results = $contactRepository->findAll();

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $results
        ]);
    }

}
