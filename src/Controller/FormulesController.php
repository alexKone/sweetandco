<?php

namespace App\Controller;

use App\Entity\Bagel;
use App\Entity\Base;
use App\Entity\Category;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Entity\SubCategory;
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
	 * @param Request $request
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
			$formule = $this->getDoctrine()->getRepository(Formule::class)->find($id);

			$item = [
				'name' => 'formule',
				'item_name' => $formule->getName(),
				'id' => $id,
				'base' => $base,
				'ingredients' => $ingredients,
				'sauce' => $sauce,
				'price' => $formule->getPrice()
			];
			$newSalade = new Salade();
			$newSalade->setBase($this->getDoctrine()->getRepository(Base::class)->find($datas['base']));
			$newSalade->setSauce($this->getDoctrine()->getRepository(Sauce::class)->find($datas['sauce']));

			foreach ($ingredients as $ingredient) {
				$newSalade->addIngredient($this->getDoctrine()->getRepository(Ingredient::class)->find($ingredient));
			}

			dump($newSalade);
			die();
//
//			if (!empty($session->get('items'))) {
//				$data = $session->get('items');
//				array_push($data, $item);
//				$session->set('items', $data);
//			} else {
//				$newArr = [];
////				$sessionItem = $session->get('items');
//				array_push($newArr, $item);
//				$session->set('items', $newArr);
////				dump($session->get('items'), $newArr);
////				die();
//			}
//
//			return $this->redirectToRoute('checkout');
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
			'bagels' => $this->getDoctrine()->getRepository(Bagel::class)->findAll(),
			'subCategory' => $this->getDoctrine()->getRepository(SubCategory::class)->findAll(),
			'boissons' => $this->getDoctrine()->getRepository(Category::class)->findOneBySlug('les-boissons'),
			'desserts' => $this->getDoctrine()->getRepository(Category::class)->findOneBySlug('les-desserts'),
		]);
	}

}
