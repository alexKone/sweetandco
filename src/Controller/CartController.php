<?php

namespace App\Controller;


use App\Entity\Base;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Product;
use App\Entity\Sauce;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class CartController extends AbstractController
{
	/**
	 * @Route("/cart", name="cart")
	 */
	public function index(  ) {
		$session = new Session(new NativeSessionStorage(), new AttributeBag());
		$total = 0;

		if ($session->get('items')) {

			foreach ( $session->get('items') as $item ) {
				$total += $item['price'];
			}
		}
		return $this->render('pages/cart/index.html.twig', [
			'total' => $total
		]);


	}
}
