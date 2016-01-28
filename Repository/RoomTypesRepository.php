<?php

namespace CarlosGude\BookingBundle\Repository;
use CarlosGude\BookingBundle\Entity\BookingRoom;

/**
 * RoomTypesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoomTypesRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFreeRoomTypes(BookingRoom $booking, $day, $type = null)
    {

        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder();

        $day = new \DateTime($booking->getDateStart()->format('Y-m-d'). '+'. $day .' days');

        return $query->select(['r'])
                     ->from('CarlosGudeBookingBundle:BookingRoom','r')
                     ->innerJoin('r.bookingElement','t')
                     ->where($query->expr()->eq('r.dateStart',':dateStart'))
                     ->andWhere($query->expr()->eq('r.finalized',':finalized'))
                     ->andWhere($query->expr()->eq('t.name',':room'))
                     ->setParameters(['dateStart' => $day->format('Y-m-d'),
                                      'room' =>(is_null($type)) ?  $booking->getBookingElement()->getName() : $type,
                                      'finalized' => true])
                     ->getQuery()->getResult();

    }
}
