<?php

namespace CarlosGude\BookingBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowBookingsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {

        $this
            ->setName('booking:list')
            ->setDescription('Show all bookings or filter by booking type element or find one by ID')
            ->addArgument(
                'type',
                InputArgument::OPTIONAL,
                'Filter Bookings by type '
            )
            ->addOption('id','id',InputOption::VALUE_REQUIRED,'Show details of booking')

        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('doctrine')->getEntityManager();
        $bookingClass = $this->getContainer()->getParameter('app.booking')['class']['bookingEntity'];

        if (!is_null($id = $input->getOption('id')))
        {
            $bookings = $manager->getRepository($bookingClass)->findOneById($id);
        }else{
            $bookings = (is_null($type = $input->getArgument('type')))
                ? $bookings = $manager->getRepository($bookingClass)->findAll()
                : $bookings = $manager->getRepository($bookingClass)->getBookings($type);
        }

        $this->renderTable($output,$bookings);
    }

    public function renderTable($output, $bookings)
    {
        $table = new Table($output);

        $table->setHeaders(array('Id','Date Start', 'Date End','Days' ,'Room Type', 'Quantity', 'Total Price'));

        if (is_array($bookings)) foreach ($bookings as $booking) $table->addRow($this->getRow($booking));

        else $table->addRow($this->getRow($bookings));

        $table->render();
    }

    public function getRow($booking)
    {

        return [$booking->getId(),
                $booking->getDateStart()->format('d/m/Y'),
                $booking->getDateEnd()->format('d/m/Y'),
                $booking->getDateStart()->diff($booking->getDateEnd())->format('%a'),
                $booking->getBookingElement()->getName(),
                $booking->getQuantity(),
                $booking->getTotal() . ' '.$this->getBookingService()->getBookingConfiguration('money')];
    }

    private function getBookingService()
    {
        return $this->getContainer()->get('booking.service');
    }
}
