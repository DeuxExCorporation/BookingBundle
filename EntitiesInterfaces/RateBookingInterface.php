<?php
/**
 * Created by PhpStorm.
 * User: Familia Crespo Gude
 * Date: 24/01/2016
 * Time: 0:37
 */
namespace CarlosGude\BookingBundle\EntitiesInterfaces;

interface RateBookingInterface
{
    public function getDateStart();

    public function getDateEnd();

    public function getDefault();

    public function getRate();

    public function getBookingElement();

}
