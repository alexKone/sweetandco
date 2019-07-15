<?php

namespace App\Controller;

use App\Entity\Bagel;
use App\Entity\Boisson;
use App\Entity\Dessert;
use App\Entity\Formule;
use App\Entity\Panini;
use App\Service\CustomMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


		return $this->render('pages/home/index.html.twig', [
			'formules' => $this->getDoctrine()->getRepository(Formule::class)->findAll(),
			'paninis' => $this->getDoctrine()->getRepository(Panini::class)->findAll(),
			'bagels' => $this->getDoctrine()->getRepository(Bagel::class)->findAll(),
			'boissons' => $this->getDoctrine()->getRepository(Boisson::class)->findAll(),
			'desserts' => $this->getDoctrine()->getRepository(Dessert::class)->findAll(),
		]);
	}

	/**
	 * @Route("/send-email", name="app_send-email")
	 */
	public function sendEmail( CustomMailService $mailService ) {
		return $mailService->sendMail('Alexandre');

	}
}
