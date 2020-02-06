<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Idea;
use App\Form\IdeaType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/idea")
 */
class IdeaController extends AbstractController
{
    /**
     * @Route("deleteCategory/{id}", name="deleteCategory")
     */
    public function deleteCategory($id, EntityManagerInterface $em)
    {
        $connectedUser = $this->getUser();


        $category = $em->getRepository(Category::class)->find($id);

        $this->addFlash("success", "Categorie ".$category->getName()." supprimé");

        $em->remove($category);
        $em->flush();


        return $this->redirectToRoute("categoryList");
    }


    /**
     * @Route("/categoryList", name="categoryList")
     */
    public function categoryList(EntityManagerInterface $em, Request $request)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash("danger", "NOOOOOOOOOOOOOOOON");

            return $this->redirectToRoute('list');
        }


        $categories = $em->getRepository(Category::class)->findBy([], ['name' => 'ASC']);

        return $this->render(
            "idea/categoryList.html.twig",
            [
                "categories" => $categories
            ]
        );
    }

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
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id = null, EntityManagerInterface $em, Request $request)
    {
        $idea = $em->getRepository(Idea::class)->find($id);
        $em->remove($idea);
        $em->flush();
        $this->addFlash('success', 'Idea Deleted');
        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/form/{id}", name="form")
     * @IsGranted("IS_AUTHENTICATED_FULLY");
     */
    public function form($id = null, EntityManagerInterface $em, Request $request)
    {
        if ($id == null) {
            $idea = new Idea();
        } else {
            $idea = $em->getRepository(Idea::class)->find($id);
        }

        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($id == null) {
                $idea->setDateCreated(new \DateTime());

                $currentUser = $this->getUser();
                $idea->setAuthor($currentUser);

                $em->persist($idea);
                $this->addFlash('success', 'Idea Created');
            } else {
                $this->addFlash('success', 'Idea Updated');
            }

            $em->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render(
            "idea/form.html.twig",
            [
                "ideaForm" => $form->createView()
            ]
        );
    }
}
