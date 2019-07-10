<?php

namespace App\Controller;

use App\Entity\Base;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Sauce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

class FormulesController extends AbstractController
{
	/**
	 * @Route("/formules/{id}", methods={"get","post"})
	 */
	public function details( Request $request, $id ) {
		if ($request->getMethod() == 'POST') {
			$pattern = '#^ingredient_[0-9]+$#i';

			$datas = $request->request->all();
			$keys = array_keys($datas);
			$ingredientKeys = [];
			$base = $datas['base'];
			$sauce = $datas['sauce'];
			$ingredients = [];

			foreach ($keys as $key) {
				if (preg_match($pattern, $key)) {
					array_push($ingredientKeys, $key);
				}
			}
			foreach ($ingredientKeys as $ingredient_key) {
				array_push($ingredients, $datas[$ingredient_key]);
			}
			$session = new Session(new NativeSessionStorage(), new AttributeBag());
//			$session->start();
//			$items = $session->all();
//			dump($items);
//			die();
			$item = [
				'formule_' . $id => [
					'base' => $base,
					'ingredients' => $ingredients,
					'sauce' => $sauce
				]
			];
			$session->set('items', $item);
			return $this->redirectToRoute('checkout');
		}
		$formule = $this->getDoctrine()
		                ->getRepository(Formule::class)
		                ->find($id);
		$bases = $this->getDoctrine()
		              ->getRepository(Base::class)
		              ->findAll();
		$ingredients = $this->getDoctrine()
		              ->getRepository(Ingredient::class)
		              ->findAll();
		$sauces = $this->getDoctrine()
		              ->getRepository(Sauce::class)
		              ->findAll();

		return $this->render('pages/formules/details.html.twig', [
			'formule' => $formule,
			'bases' => $bases,
			'ingredients' => $ingredients,
			'sauces' => $sauces,
		]);
	}

}
