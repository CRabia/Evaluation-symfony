<?php

namespace App\Controller;

use App\Entity\ArtWork;
use App\Entity\Category;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\Model\ContactModel;
use App\Repository\ArtWorkRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(ArtWorkRepository $artWorkRepository)
    {
        $carousel = $artWorkRepository->findBy([],null,4,null);
        return $this->render('Homepage/home.html.twig', ['carousel'=>$carousel]);
    }

    /**
     * @Route("/mentions-legales", name="front.mention")
     */
    public function mention()
    {
        return $this->render('Homepage/mention.html.twig');
    }

    /**
     * @Route("/contact", name="front.contact")
     */
    public function form(Request $request)
    {
        $type = ContactType::class;
        $model = new Contact();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm($type, $model);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('notice', 'Votre message à bien été enregistré !');
            $entityManager->persist($model);
            $entityManager->flush();
            return $this->redirectToRoute('front.contact');
        }

        return $this->render('Homepage/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function header($app, CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('Inc/navbar.html.twig',[
            'categories'=>$categories,
            'app'=>$app
        ]);
    }

    public function footer(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('Inc/footer.html.twig',[
            'categories'=>$categories
        ]);
    }
}
