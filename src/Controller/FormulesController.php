<?php

namespace App\Controller;

use App\Entity\Bagel;
use App\Entity\Base;
use App\Entity\Boisson;
use App\Entity\Category;
use App\Entity\Dessert;
use App\Entity\Formule;
use App\Entity\Ingredient;
use App\Entity\Panini;
use App\Entity\Salade;
use App\Entity\Sauce;
use App\Entity\SubCategory;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
			$pattern2 = '#^opt_ingredient_[0-9]+$#i';

			$em = $this->getDoctrine()->getManager();

			$datas = $request->request->all();
			$qty = 1;
			if (intval($datas['quantity']) !== 0) {
				$qty = intval($datas['quantity']);
			}

			$keys = array_keys($datas);
			$ingredientKeys = [];
			$addonsIngredientKeys= [];
			$base = $datas['base'];
			$sauce = $datas['sauce'];
			$ingredients = [];
			$addonsBase = null;
			$addonsIngredients = [];

			foreach ($keys as $key) {
				if (preg_match($pattern, $key)) {
					array_push($ingredientKeys, $key);
				}
				if (preg_match($pattern2, $key)) {
					array_push($addonsIngredientKeys, $key);
				}
			}

			if (!empty($addonsIngredientKeys)) {
				foreach ($addonsIngredientKeys as $addons_ingredient_key) {
					array_push($addonsIngredients, $this->getDoctrine()->getRepository(Ingredient::class)->find($datas[$addons_ingredient_key]));
				}
			}

			foreach ($ingredientKeys as $ingredient_key) {
				array_push($ingredients, $datas[$ingredient_key]);
			}
			$session = new Session(new NativeSessionStorage(), new AttributeBag());
			$formule = $this->getDoctrine()->getRepository(Formule::class)->find($id);

			$newSalade = new Salade();
			$newSalade->setBase($this->getDoctrine()->getRepository(Base::class)->find($datas['base']));
			$newSalade->setSauce($this->getDoctrine()->getRepository(Sauce::class)->find($datas['sauce']));


			$item = [
				'name' => 'formule',
				'id' => $formule->getId(),
				'title' => $formule->getName(),
				'price' => $formule->getPrice(),
				'total_price' => $formule->getPrice(),
				'salade' => $newSalade,
				'quantity' => $qty,
				'addons' => [
					'price' => 0,
					'base' => [],
					'ingredients' => []
				]
			];


			if (!empty($addonsIngredients)) {
				$item['addons']['ingredients'] = $addonsIngredients;
				$item['addons']['price'] += 1.3;
			}


			foreach ($ingredients as $ingredient) {
				$newSalade->addIngredient($this->getDoctrine()->getRepository(Ingredient::class)->find($ingredient));
			}
			if ($request->request->get('opt_base')) {
				$item['addons']['base'] = $this->getDoctrine()->getRepository(Base::class)->find($request->request->get('opt_base'));
				$item['addons']['price'] += 2.3;
			}
			if ($request->request->get('boisson')) {
				$boisson = $this->getDoctrine()->getRepository(Boisson::class)->find($datas['boisson']);
				$item['boisson'] = $boisson;
			}
			if ($request->request->get('dessert')) {
				$dessert = $this->getDoctrine()->getRepository(Dessert::class)->find($datas['dessert']);
				$item['dessert'] = $dessert;
			}
			if ($request->request->get('panini')) {
				$panini = $this->getDoctrine()->getRepository(Panini::class)->find($datas['panini']);
				$item['panini'] = $panini;
			}
			if ($request->request->get('bagel')) {
				$bagel = $this->getDoctrine()->getRepository(Bagel::class)->find($datas['bagel']);
				$item['bagel'] = $bagel;
			}

			$item['total_price'] = $item['price'] + $item['addons']['price'];

			if (!empty($session->get('items'))) {
				$data = $session->get('items');
				array_push($data, $item);
				$session->set('items', $data);
			} else {
				$newArr = [];
				array_push($newArr, $item);
				$session->set('items', $newArr);
			}

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
			'bagels' => $this->getDoctrine()->getRepository(Bagel::class)->findAll(),
			'paninis' => $this->getDoctrine()->getRepository(Panini::class)->findAll(),
			'subCategory' => $this->getDoctrine()->getRepository(SubCategory::class)->findAll(),
			'boissons' => $this->getDoctrine()->getRepository(Boisson::class)->findAll(),
			'desserts' => $this->getDoctrine()->getRepository(Dessert::class)->findAll(),
		]);
	}

}
