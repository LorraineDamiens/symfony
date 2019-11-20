<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




Class WildController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     * @Route("/wild", name="wild_index")
     * @return Response A response instance
     */

    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs){
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render(
            'wild/index.html.twig',
            ['programs'=>$programs]
        );
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", name="wild_show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }
    /**
     * Getting a category with a formatted categoryName for category name
     * @param string $categoryName
     * @Route("/wild/category/{categoryName}", requirements={"categoryName"="[a-z 0-9 -]+"}, name="show_category", defaults={"categoryName"=null})
     *@return Response
     */
    public function showByCategory(?string $categoryName) : response
    {
        if (!$categoryName){
            throw $this
                ->createNotFoundException('No category has been sent to find a category in category table');
        }
        $categoryName = preg_replace(
            '/-/', ' ', ucwords(trim(strip_tags($categoryName)), "-")
        );
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy([
                'name' => mb_strtolower($categoryName)
            ]);
        if (!$category){
            throw $this
                ->createNotFoundException('No category with'.$categoryName.'name found in category table');
        }
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ['category' => $category],
                ['id' => 'DESC'],
                3
            );
        if (!$program){
            throw $this
                ->createNotFoundException('No program found in program table');
        }
        return $this->render('wild/category.html.twig', [
            'categoryname' => ucwords(str_replace("-", " ", $categoryName)), 'category' => $category,
            'programs' => $program
        ]);
    }
}