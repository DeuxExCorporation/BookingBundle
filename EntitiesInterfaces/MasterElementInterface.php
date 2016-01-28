<?php
/**
 * Created by PhpStorm.
 * User: Familia Crespo Gude
 * Date: 24/01/2016
 * Time: 0:37
 */
namespace CarlosGude\BookingBundle\EntitiesInterfaces;

interface MasterElementInterface
{
    public function getName();

    public function getBookingElements();

    public function getEmailBooking();

}
