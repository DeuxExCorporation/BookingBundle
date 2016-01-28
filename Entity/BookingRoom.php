<?php

namespace CarlosGude\BookingBundle\Entity;

use CarlosGude\BookingBundle\EntitiesInterfaces\BookingInterfaces;
use Doctrine\ORM\Mapping as ORM;

/**
 * BookingRoom
 *
 * @ORM\Table(name="booking_room")
 * @ORM\Entity(repositoryClass="CarlosGude\BookingBundle\Repository\BookingRoomRepository")
 */
class BookingRoom implements  BookingInterfaces
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="date")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="date")
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity="CarlosGude\BookingBundle\Entity\RoomTypes", cascade={"persist"})
     * @ORM\JoinColumn(name="booking_element_id",nullable=false,referencedColumnName="id", onDelete="CASCADE")
     */
    private $bookingElement;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="identificator", type="string", length=13)
     */
    private $identificator;

    /**
     * @var bool
     *
     * @ORM\Column(name="finalized", type="boolean")
     */
    private $finalized;

    /**
     * @var bool
     *
     * @ORM\Column(name="priceWithoutTax", type="float")
     */
    private $priceWithoutTax;

    /**
     * @var bool
     *
     * @ORM\Column(name="tax", type="integer")
     */
    private $tax;

    /**
     * @var bool
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="emailUser", type="string", length=13)
     */
    private $emailUser;


    public function __construct()
    {
        $this->identificator = uniqid();
        $this->finalized = false;
    }

    public function __toString()
    {
        return $this->getIdentificator();
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return BookingRoom
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return BookingRoom
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return BookingRoom
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set identificator
     *
     * @param string $identificator
     *
     * @return BookingRoom
     */
    public function setIdentificator($identificator)
    {
        $this->identificator = $identificator;

        return $this;
    }

    /**
     * Get identificator
     *
     * @return string
     */
    public function getIdentificator()
    {
        return $this->identificator;
    }

    /**
     * Set finalized
     *
     * @param boolean $finalized
     *
     * @return BookingRoom
     */
    public function setFinalized($finalized)
    {
        $this->finalized = $finalized;

        return $this;
    }

    /**
     * Get finalized
     *
     * @return boolean
     */
    public function getFinalized()
    {
        return $this->finalized;
    }

    /**
     * Set priceWithoutTax
     *
     * @param float $priceWithoutTax
     *
     * @return BookingRoom
     */
    public function setPriceWithoutTax($priceWithoutTax)
    {
        $this->priceWithoutTax = $priceWithoutTax;

        return $this;
    }

    /**
     * Get priceWithoutTax
     *
     * @return float
     */
    public function getPriceWithoutTax()
    {
        return $this->priceWithoutTax;
    }

    /**
     * Set tax
     *
     * @param integer $tax
     *
     * @return BookingRoom
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return integer
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return BookingRoom
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set bookingElement
     *
     * @param \CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement
     *
     * @return BookingRoom
     */
    public function setBookingElement(\CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement)
    {
        $this->bookingElement = $bookingElement;

        return $this;
    }

    /**
     * Get bookingElement
     *
     * @return \CarlosGude\BookingBundle\Entity\RoomTypes
     */
    public function getBookingElement()
    {
        return $this->bookingElement;
    }

    public function getUserEmail()
    {

    }

    /**
     * Set emailUser
     *
     * @param string $emailUser
     *
     * @return BookingRoom
     */
    public function setEmailUser($emailUser)
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    /**
     * Get emailUser
     *
     * @return string
     */
    public function getEmailUser()
    {
        return $this->emailUser;
    }
}
