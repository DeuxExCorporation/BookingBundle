<?php


namespace CarlosGude\BookingBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class BookingService
 * @package CarlosGude\BookingBundle\Services
 */

class BookingService
{
    protected $bookingConfiguration;
    protected $em;

    /**
     * @param $bookingConfiguration
     * @param EntityManager $entityManager
     * @param FlashBag $flashBag
     */
    public function __construct($bookingConfiguration,EntityManager $entityManager, FlashBag $flashBag)
    {
        $this->bookingConfiguration = $bookingConfiguration;
        $this->em = $entityManager;
        $this->flash = $flashBag;

    }

    /**
     * @param $element
     * @param null $key
     * @return mixed
     */
    public function getBookingConfiguration($element,$key = null)
    {
        return (is_array($this->bookingConfiguration[$element]))
                ? $this->bookingConfiguration[$element][$key]
                : $this->bookingConfiguration[$element];
    }

    /**
     * @param $element
     * @return null|object
     */
    public function findMasterElementBy($element)
    {
        return $this->em->getRepository($this->getBookingConfiguration('class','masterElementEntity'))
                    ->findOneBy([$this->getBookingConfiguration('discriminatorElement') => $element]);
    }

    /**
     * @param $element
     * @return null|object
     */
    public function findBookingElementBy($element)
    {
        return $this->em->getRepository($this->getBookingConfiguration('class','bookingElementEntity'))
            ->findOneBy([$this->getBookingConfiguration('discriminatorElement') => $element]);
    }

    /**
     * @return mixed
     */
    public function newBooking()
    {
        $booking = $this->getBookingConfiguration('class','bookingEntity');

        return new $booking();
    }

    /**
     * @param $entity
     * @return $this
     */
    public function saveEntity($entity)
    {
        if (!is_object($entity)) throw new HttpException(500,$entity. " is not a a object");
        if ($this->getBookingConfiguration('autoSaveBooking'))
        {
            $this->em->persist($entity);
            $this->em->flush();
        }


        return $this;
    }

    /**
     * @param $booking
     * @param $day
     * @return int
     */
    protected function getFreeRoomTypes($booking, $day)
    {
        $class = $this->getBookingConfiguration('class','bookingElementEntity');
        $method = $this->getBookingConfiguration('methodSearchBookingElements');

        $rooms = $this->em->getRepository($class)->$method($booking, $day);

        $count = (count($rooms) === 0)
                    ? $booking->getBookingElement()->getQuantity()
                    : $booking->getBookingElement()->getQuantity() - count($rooms);

        return  ($count < 0 ) ? 0 : $count;

    }

    /**
     * @param $booking
     * @param $day
     * @return bool
     */
    public function getDisponibility($booking, $day)
    {

         return ($this->getFreeRoomTypes($booking, $day) - $booking->getQuantity() >= 0)
                    ? true
                    : false;
    }

    /**
     * @param $type
     * @param $message
     * @return $this
     */
    public function setFlashMessage($type, $message)
    {
        if ($this->getBookingConfiguration('showFlash')) $this->flash->add($type,$message);

        return $this;
    }

    /**
     * @param $booking
     * @param bool|true $days
     * @return int
     */
    public function getDaysBooking($booking, $days = true)
    {
        if ($this->getBookingConfiguration('hasDateEnd'))
            return ($days)
                    ? (int) $booking->getDateStart()->diff($booking->getDateEnd())->format('%a')
                    : $booking->getDateStart()->diff($booking->getDateEnd());

        else return 1;
    }

    /**
     * @param $booking
     * @return bool
     */
    public function checkDisponibility( $booking)
    {

        for ($day = 0; $day <= $this->getDaysBooking($booking) -1; $day++)
        {
            if (! $this->getDisponibility($booking, $day)) return false;

        }



        return true;
    }

    /**
     * @param $booking
     * @return bool
     */
    public function bookingRoom($booking)
    {

        if ($this->checkDisponibility($booking) && $this->validateDate($booking))
        {
            $this->setFlashMessage('sucess',['title' =>'Reserva correcta','message' => 'Reserva correcta']);
            return true;
        }

        $this->setFlashMessage('error',['title' =>'Reserva fallida','message' => 'Reserva fallida']);
        return false;

    }

    /**
     * @param $booking
     * @return array
     */
    public function getWeekDays($booking)
    {
        $days = $this->getDaysBooking($booking);

        $daysOfBooking = array();
        for ($day = 0; $day < $days -1; $day++)
        {
            $weekday = new \DateTime($booking->getDateStart()->format('Y-m-d'). '+'. $day .' days');
            $daysOfBooking[]=date('l', strtotime($weekday->format('Y-m-d')));
        }

        return $daysOfBooking;

    }


    /**
     * @param $booking
     * @return bool
     */
    public function validateDate($booking)
    {
        return $booking->getDateEnd() > $booking->getDateStart();
    }

    public function getRate($booking)
    {
        $class = $this->getBookingConfiguration('class','rateEntity');

        $rate = $this->em->getRepository($class)->calculatePrice($booking);

        return $rate;
    }

    // TODO: 6. Pendiente de mejorar
    public function calculateRateDiary($booking)
    {
        $total = $this->getDaysBooking($booking) * $this->getRate($booking)->getRate() * $booking->getQuantity();

        $booking->setPriceWithoutTax($total)->setTax(23)->setTotal($total *1.23);

    }

}