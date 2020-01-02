<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Service\Slugify;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


Class CategoryController extends AbstractController
{
    /**
     * Show all rows from Category's entity
     * @Route("/addcategory", name="category")
     * @return Response A response instance
     */

    public function add(Request $request, Slugify $slugify): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        if (!$categories) {
            throw $this->createNotFoundException(
                'No category found in category\'s table.'
            );
        }

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        $slug = $slugify->generate($category->getName());
        $category->setSlug($slug);

        if ($form->isSubmitted()) {
            $category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category');
        }
            return $this->render(
                '/category/addcategory.twig.html',
                ['category' => $categories,
                 'form' => $form->createView(), ]

            );
        }

}



