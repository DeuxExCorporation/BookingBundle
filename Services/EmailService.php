<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 06/04/2015
 * Time: 12:52
 */
namespace CarlosGude\BookingBundle\Services;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class EmailService
 * @package DeusExCorp\BackendBundle\Services
 *
 */

class EmailService
{
	protected $twig, $mailer, $bookingConfig;

	public function __construct (\Swift_Mailer $mailer, EngineInterface $templating, $bookingConfig)
	{
		$this->mailer = $mailer;
		$this->twig = $templating;
		$this->bookingConfig = $bookingConfig;
	}


	public function bookingEmail($booking)
	{
		$toEmail = $booking->getEmailUser();
		$subject = $this->bookingConfig['bookingEmailSubject'];
		$template = $this->twig->render($this->bookingConfig['emailTemplate'],['booking' =>$booking]);
		$from = $booking->getBookingElement()->getProperty()->getEmailBooking();

		$this->sendEmail($toEmail,$subject,$template, $from);

		return true;
	}

	public function listBookingsEmail($bookings)
	{
		$today = new \DateTime("now");
		$toEmail = 'carlos.sgude@gmail.com';
		$subject = $this->bookingConfig['bookingListEmailSubject'] . $today->format('d/m/Y');
		$template = $this->twig->render($this->bookingConfig['listBookingsEmailTemplate'],['bookings' =>$bookings]);
		$from = 'carlos.sgude@gmail.com';

		$this->sendEmail($toEmail,$subject,$template, $from);

		return true;
	}

	private function sendEmail ($toEmail,$subject,$template,$from)
	{

		$email = \Swift_Message::newInstance()
			->setSubject($subject)
			->setFrom($from)
			->setTo($toEmail)
			->setBody($template, 'text/html');

		$this->mailer->send($email);


	}

}
