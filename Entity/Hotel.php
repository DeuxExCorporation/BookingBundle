<?php

namespace CarlosGude\BookingBundle\Entity;

use CarlosGude\BookingBundle\EntitiesInterfaces\MasterElementInterface;
use Doctrine\ORM\Mapping as ORM;
use CarlosGude\BookingBundle\Entity\BaseEntity as Base;
/**
 * Hotel
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity(repositoryClass="CarlosGude\BookingBundle\Repository\HotelRepository")
 */
class Hotel extends  Base implements  MasterElementInterface
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
     * @ORM\OneToMany(targetEntity="CarlosGude\BookingBundle\Entity\RoomTypes", mappedBy="property")
     * @ORM\OrderBy({"name" = "ASC"})
     **/
    private $bookingElements;

    /**
     * @var string
     *
     * @ORM\Column(name="emailBooking", type="string", length=13)
     */
    private $emailBooking;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->getName();
    }

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bookingElements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bookingElement
     *
     * @param \CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement
     *
     * @return Hotel
     */
    public function addBookingElement(\CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement)
    {
        $this->bookingElements[] = $bookingElement;

        return $this;
    }

    /**
     * Remove bookingElement
     *
     * @param \CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement
     */
    public function removeBookingElement(\CarlosGude\BookingBundle\Entity\RoomTypes $bookingElement)
    {
        $this->bookingElements->removeElement($bookingElement);
    }

    /**
     * Get bookingElements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBookingElements()
    {
        return $this->bookingElements;
    }

    /**
     * Set emailBooking
     *
     * @param string $emailBooking
     *
     * @return Hotel
     */
    public function setEmailBooking($emailBooking)
    {
        $this->emailBooking = $emailBooking;

        return $this;
    }

    /**
     * Get emailBooking
     *
     * @return string
     */
    public function getEmailBooking()
    {
        return $this->emailBooking;
    }
}
