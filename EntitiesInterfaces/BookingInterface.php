<?php
/**
 * Created by PhpStorm.
 * User: Familia Crespo Gude
 * Date: 24/01/2016
 * Time: 0:37
 */
namespace CarlosGude\BookingBundle\EntitiesInterfaces;

interface BookingInterface
{
    public function getDateStart();

    public function getDateEnd();

    public function getFinalized();

    public function getBookingElement();

    public function getQuantity();

    public function getTotal();

    public function getEmailUser();

}
