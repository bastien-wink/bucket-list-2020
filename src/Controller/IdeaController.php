<?php

namespace App\Controller;

use App\Entity\Idea;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/idea")
 */
class IdeaController extends AbstractController
{
    /**
     * @Route("/list/by/{orderParam}", name="list_ordered")
     * @Route("/list", name="list")
     */
    public function list(EntityManagerInterface $em, Request $request, $orderParam = 'id')
    {
        $search = $request->get('search');

        $ideas = $em->getRepository(Idea::class)->search($search, $orderParam);
        //$ideas = $em->getRepository(Idea::class)->findBy(['isPublished' => true], [$orderParam => 'ASC']);

        return $this->render(
            "idea/list.html.twig",
            [
                "ideas" => $ideas
            ]
        );
    }

    /**
     * @Route("/list_recent", name="list_recent")
     */
    public function listRecent(EntityManagerInterface $em, $orderParam = 'id')
    {
        $ideas = $em->getRepository(Idea::class)
            ->findRecent();
        //    ->findBy(['isPublished' => true], [$orderParam => 'ASC']);

        return $this->render(
            "idea/list.html.twig",
            [
                "ideas" => $ideas
            ]
        );
    }


    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id = null, EntityManagerInterface $em)
    {
        $idea = $em->getRepository(Idea::class)->find($id);

        return $this->render(
            "idea/detail.html.twig",
            [
                "idea" => $idea
            ]
        );
    }
}
