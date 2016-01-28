<?php

namespace CarlosGude\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $booking = $this->get('booking.service')->newBooking();

        $booking->setDateStart(new \DateTime("now"))
                ->setDateEnd(new \DateTime("now". rand(3,10) ." days"))
                ->setBookingElement($this->get('booking.service')->findBookingElementBy(1))
                ->setQuantity(rand(1,3))
                ->setEmailUser('carlos.sgude@gmail.com');

        if($this->get('booking.service')->bookingRoom($booking))
        {
            $this->get('booking.service')->calculateRateDiary($booking);

            $this->get('email.service')->bookingEmail($booking);

            $this->get('booking.service')->saveEntity($booking);

        }


        return $this->render('CarlosGudeBookingBundle:Default:index.html.twig',
                                ['booking' => $booking,
                                 'days'    => $this->get('booking.service')->getDaysBooking($booking)]);
    }
}
