<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Formule;
use App\Entity\Salade;
use App\Form\SaladeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
	/**
	 * @Route("/", name="homepage")
	 */
	public function index(  ) {
//		$session = new Session(new NativeSessionStorage(), new AttributeBag());
//		$session->clear();
		$formules = $this->getDoctrine()->getRepository(Formule::class)->findAll();
		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
		$bagels = $this->getDoctrine()->getRepository(Category::class)->findOneBySlug('les-bagels');
		$paninis = $this->getDoctrine()->getRepository(Category::class)->findOneBySlug('les-paninis');

//		dump($categories);
//		die();
		return $this->render('pages/home/index.html.twig', [
			'formules' => $formules,
			'categories' => $categories
		]);
	}
}
