<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
	/**
	 * @Route("/checkout", name="checkout")
	 * @param Session $session
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index( Session $session ) {
//		dump($session->get('items'), $session->getId(), $session->all());
////		dump();

		$total_price = 0;
		\Stripe\Stripe::setApiKey('sk_test_hpOkRt0eanTpgDugo3ikLSGb00oLULJyLi');

//		$intent = \Stripe\PaymentIntent::create([
//			'amount' => 1099,
//			'currency' => 'eur',
//			'payment_method_types' => ['card'],
//			'metadata' => [
//				'customer_id' => $this->getUser()->getId(),
//				'order_id' => 2
//			]
//		]);

		foreach ( $session->get('items') as $item ) {
			$total_price += $item['price'];
//			dump($item['price']);
		}





		return $this->render('pages/checkout/index.html.twig', [
//			'intent_client_secret' => $intent->client_secret,
//			'cart_value' => $intent->amount
		]);
	}



}
