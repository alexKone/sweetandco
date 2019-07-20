<?php

namespace App\EventSubscriber;

use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Twig\Environment;

class RegistrationNotifySubscriber implements EventSubscriberInterface
{
	private $mailer;
	private $sender;
	private $templating;

	public function __construct(\Swift_Mailer $mailer, $sender, Environment $templating) {
		$this->mailer = $mailer;
		$this->sender = $sender;
		$this->templating = $templating;
	}

	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * The array keys are event names and the value can be:
	 *
	 *  * The method name to call (priority defaults to 0)
	 *  * An array composed of the method name to call and the priority
	 *  * An array of arrays composed of the method names to call and respective
	 *    priorities, or 0 if unset
	 *
	 * For instance:
	 *
	 *  * ['eventName' => 'methodName']
	 *  * ['eventName' => ['methodName', $priority]]
	 *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
	 *
	 * @return array The event names to listen to
	 */
	public static function getSubscribedEvents() {
		return [
			Events::USER_REGISTERED => 'onUserRegistrated',
			Events::PAYMENT_CONFIRMED => 'onPaymentValidated',
		];
	}

	public function onUserRegistrated( GenericEvent $event ) {
		$user = $event->getSubject();

		$subject = 'Bienvenue';
		$body = 'Bienvenue sur le site sweet and co';

		$message = (new \Swift_Message())
			->setSubject($subject)
			->setTo($user->getEmail())
			->setFrom($this->sender)
			->setBody($body, 'text/html')
			;
		$this->mailer->send($message);
	}

	public function onPaymentValidated( GenericEvent $event ) {

		$subject = 'Votre commande a ete confirmee';
		$message = (new \Swift_Message())
			->setSubject($subject)
			->setTo('mail@mail.com')
			->setFrom($this->sender)
			->setBody($this->templating->render('emails/payment_completed.mjml.twig', [
				'lastName' => $event->getSubject()['lastName'],
				'firstName' => $event->getSubject()['firstName']
			]), 'text/html')
		;
		$this->mailer->send($message);
	}
}
