<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/idea")
 */
class IdeaController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list()
    {
        $ideas = [
            'Manger avec pierre',
            'Manger avec paul',
            'Manger avec jack'
        ];

        return $this->render("idea/list.html.twig",
            [
                "ideas" => $ideas
            ]
        );
    }

    /**
     * @Route("/detail/", name="detail")
     */
    public function detail()
    {
        $idea = 'Manger avec pierre';

        return $this->render("idea/detail.html.twig",
            [
                "idea" => $idea
            ]
        );
    }


}
