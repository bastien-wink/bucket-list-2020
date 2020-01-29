<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(EntityManagerInterface $em)
    {
        // Ancienne methode :
        //$em = $this->getDoctrine()->getManager();

        // Persist

//        $book = new Book();
//        $book->setTitle("Mémoire vives");
//        $book->setAuthor("Snowden");
//        $book->setPages(321);
//        $book->setLanguage("FR");
//        $em->persist($book);
//        $em->flush();

        // Exercise "selection"

        $bookRepository = $em->getRepository(Book::class);

//        $books = $bookRepository->findAll();
//        dump($books);

        //$book = $bookRepository->find(2);
        //dump($book);

        //$book = $bookRepository->findBookLess300Pages();


        return $this->render("main/index.html.twig",
            [
                "joueurs" => ['pierre', 'paul', 'jack'],
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

        return $this->render('main/faq.html.twig',
            ["questions" => $questions]
        );
    }
}
