<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
	/**
	 * @Route("/category/{slug}")
	 */
	public function details( $slug ) {
		$category = $this->getDoctrine()
		                 ->getRepository(Category::class)
		                 ->findOneBySlug($slug);
		return $this->render('pages/category/index.html.twig', [
			'category' => $category
		]);
	}
}
