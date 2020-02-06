<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Library;
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

        $ideaForm = $this->createForm(BookType::class, $newBook);

        // Traitement du formulaire
        $ideaForm->handleRequest($request);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()) {
            $em->persist($newBook);
            $em->flush();

            $this->addFlash("success", "Book created !!");
        }


        return $this->render(
            "main/index.html.twig",
            [
                "bookForm" => $ideaForm->createView()
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

    /**
     * @Route("/demoEcriture")
     */
    public function demoEcriture(EntityManagerInterface $em, Request $request)
    {
        $guerreEtPaix = new Book();
        $guerreEtPaix->setTitle("Guerre et Paix");
        $guerreEtPaix->setAuthor("Toltrucs");
        $guerreEtPaix->setPages(999);
        $guerreEtPaix->setLanguage("RU");
        $em->persist($guerreEtPaix);

        // Bibliobus rezé
        //$bibliobusReze = $em->getRepository(Library::class)
        //    ->findOneBy(['name'=>'Bibliobus rezé']);

        $lib = new Library();
        $lib->setName("Librarie pour les gros livres");

        // Plus besoin, il y a cascade={"persist"}
        //$em->persist($lib);

        $guerreEtPaix->setLibrary($lib);

        $em->flush();

        return $this->render(
            "main/demo_ecriture.html.twig",
            [
            ]
        );
    }


    /**
     * @Route("/demoSupr")
     */
    public function demoSupr(EntityManagerInterface $em, Request $request)
    {
        // Bibliobus rezé
        $bibliobusReze = $em->getRepository(Library::class)
            ->findOneBy(['name' => 'Bibliobus rezé']);

        $em->remove($bibliobusReze);

        $em->flush();

        return $this->render(
            "main/demo_ecriture.html.twig",
            [
            ]
        );
    }

    /**
     * @Route("/demoLecture")
     */
    public function demoLecture(EntityManagerInterface $em, Request $request)
    {
        $harryPotter = $em->getRepository(Book::class)
            ->findOneBy(['title' => 'Harry Potter']);


        return $this->render(
            "main/demo_lecture.html.twig",
            [
                "harryPotter" => $harryPotter
            ]
        );
    }
}
