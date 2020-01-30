<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $newBook = new Book();

        $form = $this->createForm(BookType::class, $newBook);

        // Traitement du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($newBook);
            $em->flush();

            $this->addFlash("success", "Book created !!");

        }


        return $this->render(
            "main/index.html.twig",
            [
                "bookForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/fr/website/about/faq", name="faq")
     */
    public function faq()
    {
        $questions = [
            '<strong>So perhaps,</strong> you\'ve generated some fancy text, and you\'re content that you can now copy and paste ',
            'fancy text in the comments section of funny cat video',
            'Well, the answer is actually no - rather than generating ',
            'Amongst the hundreds of thousands of symbols which are in the unicode text specification'
        ];

        dump($questions);

        return $this->render(
            'main/faq.html.twig',
            ["questions" => $questions]
        );
    }
}
