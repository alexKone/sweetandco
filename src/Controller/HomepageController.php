<?php

namespace App\Controller;

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
		return $this->render('pages/home.html.twig');
	}
//		$salade = new Salade();
//		$form = $this->createForm(SaladeType::class, $salade);
//		return $this->render('pages/home.html.twig', [
//			'form' => $form->createView()
//		]);
//	}
}
