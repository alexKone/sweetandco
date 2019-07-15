<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;

class CustomMailService
{
	private $mailer;

	public function __construct( \Swift_Mailer $mailer ) {
		$this->mailer = $mailer;
	}

	public function sendMail( $name) {
		$message = (new \Swift_Message('Hello Email'))
			->setFrom('send@example.com')
			->setTo('recipient@exemple.com')
			->setBody('hello ' . $name);
		$this->mailer->send($message);
		return new RedirectResponse('/');
	}

}
