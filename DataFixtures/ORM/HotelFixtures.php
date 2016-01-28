<?php

namespace CarlosGude\BookingBundle\DataFixtures\ORM;
/**
 * Created by PhpStorm.
 * User: Familia Crespo Gude
 * Date: 22/01/2016
 * Time: 11:36
 */


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CarlosGude\BookingBundle\Entity\Hotel;
use CarlosGude\BookingBundle\Entity\RoomTypes;

/**
 * Class HotelFixtures
 * @package CarlosGude\BookingBundle\DataFixtures\ORM
 *
 */
class HotelFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $hotel = new Hotel();
        $hotel->setName('Hotel California')->setEmailBooking('lol@localhost.com')->setDescription('El hotel de los corazopnes solitarios')->setStatus(true);

        $roomsTypes = ['single','double','premium'];

        $manager->persist($hotel);

        foreach ($roomsTypes as $type)
        {
            $room = new RoomTypes();
            $room->setName($type)->setQuantity(rand(2,5))->setProperty($hotel)->setStatus(true);

            $manager->persist($room);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}