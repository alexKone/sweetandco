<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Formule;
use App\Entity\Salade;
use App\Form\SaladeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
	/**
	 * @Route("/", name="homepage")
	 */
	public function index(  ) {
		$formules = $this->getDoctrine()->getRepository(Formule::class)->findAll();
		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
//		dump($categories);
//		die();
		return $this->render('pages/home/index.html.twig', [
			'formules' => $formules,
			'categories' => $categories
		]);
	}
}
