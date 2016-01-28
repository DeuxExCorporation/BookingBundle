<?php

namespace CarlosGude\BookingBundle\Entity;


use CarlosGude\BookingBundle\EntitiesInterfaces\RateBookingInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * RateBooking
 *
 * @ORM\Table(name="rate_booking")
 * @ORM\Entity(repositoryClass="CarlosGude\BookingBundle\Repository\RateBookingRepository")
 */
class RateBooking implements  RateBookingInterface
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="CarlosGude\BookingBundle\Entity\RoomTypes", cascade={"persist"})
     * @ORM\JoinColumn(name="booking_element_id",nullable=false,referencedColumnName="id", onDelete="CASCADE")
     */
    private $bookingElement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="date", nullable=true)
     */
    private $dateStart;

    /**
     * @var string
     *
     * @ORM\Column(name="dateEnd", type="date",nullable=true)
     */
    private $dateEnd;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDefault", type="boolean")
     */
    private $isDefault;



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
     * Set name
     *
     * @param string $name
     *
     * @return RateBooking
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return RateBooking
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return RateBooking
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return RateBooking
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
     * @param string $dateEnd
     *
     * @return RateBooking
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return string
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return RateBooking
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     *
     * @return RateBooking
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set bookingElement
     *
     * @param \CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement
     *
     * @return RateBooking
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
}
