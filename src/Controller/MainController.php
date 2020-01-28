<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render("main/index.html.twig",
            [
                "joueurs" => ['pierre', 'paul', 'jack'],
                "dateDuJour" => new \DateTime(),
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
