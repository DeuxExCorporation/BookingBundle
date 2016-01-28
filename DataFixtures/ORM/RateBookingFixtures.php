<?php
namespace CarlosGude\BookingBundle\DataFixtures\ORM;
/**
 * Created by PhpStorm.
 * User: Familia Crespo Gude
 * Date: 27/01/2016
 * Time: 21:29
 */

use CarlosGude\BookingBundle\Entity\RateBooking;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CarlosGude\BookingBundle\Entity\Hotel;
use CarlosGude\BookingBundle\Entity\RoomTypes;

class RateBookingFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rooms = $manager->getRepository('CarlosGudeBookingBundle:RoomTypes')->findAll();
        $i= 0;
        foreach ($rooms as $room)
        {
            $rate = new RateBooking();

            $rate->setName('Tarifa '.$i)
                 ->setDescription('descripcion')
                 ->setRate(rand(10,20))
                 ->setBookingElement($room)
                 ->setIsDefault(true)
                 ->setStatus(true)
                ;

            $manager->persist($rate);
        }

        $manager->flush();


    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}