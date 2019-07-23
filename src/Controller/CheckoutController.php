<?php

namespace App\Controller;

use App\Entity\Addons;
use App\Entity\Base;
use App\Entity\Billing;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Service\PaymentGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
	/**
	 * @Route("/checkout", name="checkout")
	 * @param Session $session
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index( Session $session, PaymentGateway $gateway ) {
		dump($session->get('items'), $session->getId(), $session->all());
//		die();


		$total_price = 0;
		\Stripe\Stripe::setApiKey('sk_test_hpOkRt0eanTpgDugo3ikLSGb00oLULJyLi');


		foreach ( $session->get('items') as $item ) {
			$total_price += $item['total_price'];
		}

//		dump($gateway->createStripeSession());
//		die();

//		$intent = \Stripe\PaymentIntent::create([
//			'amount' => $total_price * 10,
//			'currency' => 'eur',
//			'payment_method_types' => ['card'],
//			'metadata' => [
//				'order_id' => 2
//			]
//		]);
//
//
//
//
		return $this->render('pages/checkout/index.html.twig', [
			'total_price' => $total_price,
//			'intent_client_secret' => $intent->client_secret,
//			'cart_value' => $intent->amount
		]);
	}

	/**
	 * @Route("/validation", name="app_checkout_validation", methods={"POST"})
	 */
	public function validateCheckout(  ) {
		$session = new Session(new NativeSessionStorage());
		$em = $this->getDoctrine()->getManager();

		$billing = new Billing();
		$billing->setPaymentMethod('cart');
		$billing->setTotalPrice(12.3);
		$billing->setBillingAddress('4 residence des oiseaux');
		$billing->setBillingCity('chilly mazarin');
		$billing->setBillingZipcode('91380');

		foreach ($session->get('items') as $item) {
			$addons = new Addons();
			if ($item['addons']['price'] >= 0) {
				if (!empty($item['addons']['base'])) {
					$addons->addBasis($this->getDoctrine()->getRepository(Base::class)->find($item['addons']['base']->getId()));
				}
				if (!empty($item['addons']['ingredients'])) {
					foreach ($item['addons']['ingredients'] as $ingredient) {
						$addons->addIngredient($this->getDoctrine()->getRepository(Ingredient::class)->find($ingredient->getId()));
					}
				}
			}
			$formule = null;
			if ($item['name'] === 'formule') {
				$formule = $this->getDoctrine()->getRepository(Formule::class)->find($item['id']);
			}
			$salade = new Salade();
			$salade->setBase($this->getDoctrine()->getRepository(Base::class)->find($item['salade']->getBase()->getId()));
			$salade->setSauce($this->getDoctrine()->getRepository(Sauce::class)->find($item['salade']->getSauce()->getId()));
			$salade->setAddons($addons);
			foreach ($item['salade']->getIngredients() as $ingredient) {
				$salade->addIngredient($this->getDoctrine()->getRepository(Ingredient::class)->find($ingredient->getId()));
			}

			$billing->addSalade($salade);
			$billing->addFormule($formule);
		}

		$em->persist($billing);
		$em->flush();


		return $this->redirectToRoute('success_payment',[
			'billing' => $billing->getId()
		]);

//		$billing = new Billing();
		// sauvagarder session en db
		//  salade
	}

	/**
	 * @Route("/success", name="success_payment")
	 */
	public function success( Request $request ) {
		return $this->render('pages/checkout/success.html.twig', [
			'billing' => $this->getDoctrine()->getRepository(Billing::class)->find($request->query->get('billing'))
		]);
	}

	public function cancel( ) {

	}

}
