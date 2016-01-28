<?php

namespace CarlosGude\BookingBundle\Entity;

use CarlosGude\BookingBundle\EntitiesInterfaces\ElementBookingInterfaces;
use Doctrine\ORM\Mapping as ORM;
use CarlosGude\BookingBundle\Entity\BaseEntity as Base;

/**
 * RoomTypes
 *
 * @ORM\Table(name="room_types")
 * @ORM\Entity(repositoryClass="CarlosGude\BookingBundle\Repository\RoomTypesRepository")
 */
class RoomTypes extends Base implements ElementBookingInterfaces
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="CarlosGude\BookingBundle\Entity\Hotel", cascade={"persist"}, inversedBy="bookingElements")
     * @ORM\JoinColumn(name="property_id",nullable=false,referencedColumnName="id", onDelete="CASCADE",)
     */
    private $property;


    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return RoomTypes
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }





    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set property
     *
     * @param \CarlosGude\BookingBundle\Entity\Hotel $property
     *
     * @return RoomTypes
     */
    public function setProperty(\CarlosGude\BookingBundle\Entity\Hotel $property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return \CarlosGude\BookingBundle\Entity\Hotel
     */
    public function getProperty()
    {
        return $this->property;
    }
}
