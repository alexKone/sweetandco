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

		$products = [];
		$formules = [];

		foreach ($session->get('items') as $item) {
			if ($item['name'] === 'product') {
				$arr = [];
				$product = $this->getDoctrine()->getRepository(Product::class)->find($item['id']);
				array_push($arr, $product, $item['qty']);
//				$product['qty'] = $item['qty'];
				array_push($products, $arr);
//				dump($arr);
			}
			if ($item['name'] === 'formule') {
				$itemFormule = [];
				$ingredients = [];
				if (empty($item['ingredients'])) {}
				foreach ($item['ingredients'] as $ingredient) {
					$ingredient = $this->getDoctrine()
					                   ->getRepository(Ingredient::class)
					                   ->find($ingredient);
					array_push($ingredients, $ingredient);
				}
				$base = $this->getDoctrine()
				             ->getRepository(Base::class)
				             ->find($item['base']);
				$sauce= $this->getDoctrine()
				             ->getRepository(Sauce::class)
				             ->find($item['sauce']);

//				array_push($itemFormule, $base, $ingredients, $sauce, $item['id']);

				array_push($itemFormule, $base, $ingredients, $sauce);
				$fi = [
					'items' => $itemFormule,
					'formule' => $this->getDoctrine()->getRepository(Formule::class)->find($item['id']),
					'qty' => 1,
					'id' => $item['id']
				];
				array_push($formules, $fi);

			}
		}

		$total = array_merge($formules, $products);
//		dump($formules, $products);
//		dump($total);
//		die();

		return $this->render('pages/cart/index.html.twig', [
			'products' => $products,
			'formules' => $formules,
			'total' => $total
		]);

	}
}
