<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
	/**
	 * @Route("/checkout", name="checkout")
	 */
	public function index( Session $session ) {
		dump($session->get('items'), $session->getId(), $session->all());
		return $this->render('pages/checkout/index.html.twig');
	}
}
