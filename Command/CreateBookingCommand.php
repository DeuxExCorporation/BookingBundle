<?php

namespace CarlosGude\BookingBundle\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * Class CreateBookingCommand
 * @package CarlosGude\BookingBundle\Command
 *
 */
class CreateBookingCommand extends ContainerAwareCommand
{
    protected $regExp = '/^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}$/';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('booking:new')
            ->setDescription('Create a new booking')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $io = new SymfonyStyle($input, $output);


        $booking = $this->getContainer()->get('booking.service')->newBooking();

        $booking->setDateStart($this->getDateStart($input,$output))
                ->setDateEnd($this->getDateEnd($input,$output,$booking->getDateStart()))
                ->setBookingElement($this->getBookingElement($input,$output))
                ->setQuantity($this->getQuantity($input, $output, $booking->getBookingElement()))
                ->setEmailUser($this->getEmail($input, $output));

        if (!$this->getContainer()->get('booking.service')->checkDisponibility($booking))
            $io->error(['message' => 'Dont have '.
                                     $this->getContainer()->getParameter('app.booking')['bookingPropertyType'].
                                     ' free for this date' ]);

        $this->getContainer()->get('booking.service')->calculateRateDiary($booking);
        $this->getContainer()->get('booking.service')->saveEntity($booking);


        $this->renderTable($output,$booking);

        if ($this->getContainer()->get('email.service')->bookingEmail($booking))
            $output->writeln('A email is send whith the details of the booking');

        else $output->writeln('Error send email');

    }

    protected function getDateStart($input, $output)
    {
        $helper = $this->getHelper('question');

        $defaultDateStart = new \DateTime();

        $dateStart = new Question('Date Start of the booking ['.$defaultDateStart->format('d-m-Y').']: ', $defaultDateStart);

        $dateStart->setValidator(function ($answer) {

            if ((!is_object($answer)&&(!preg_match($this->regExp, $answer))))
                throw new \RuntimeException('The format of the date is invalid');

            return is_object($answer) ? $answer: new \DateTime($answer);
        });

        return $helper->ask($input, $output, $dateStart);

    }

    protected function getDateEnd($input, $output, $dateStart)
    {
        $helper = $this->getHelper('question');

        $defaultDateEnd = new \DateTime("now +1 day");

        $dateEnd = new Question('Date Start of the booking ['.$defaultDateEnd->format('d-m-Y').']: ', $defaultDateEnd);

        $dateEnd->setValidator(function ($answer) use ($dateStart)
        {

            if ((!is_object($answer)&&(!preg_match($this->regExp, $answer))))
                throw new \RuntimeException('The format of the date is invalid');

            if ((is_object($answer) ? $answer: new \DateTime($answer)) < $dateStart)
                throw new \RuntimeException('The date end must be upper to date start');

            return $answer;
        });

        return $helper->ask($input, $output, $dateEnd);
    }

    protected function getBookingElement($input,$output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $helper = $this->getHelper('question');

        $bookingElementClass = $this->getContainer()->getParameter('app.booking')['class']['bookingElementEntity'];
        $bookingType = $this->getContainer()->getParameter('app.booking')['bookingPropertyType'];

        $bookingElementsRepository = $em->getRepository($bookingElementClass);
        $bookingElements = $bookingElementsRepository->findAll();

        $bookingElement = new Question('Booking ' .$bookingType. '['.$bookingElements[0]->getName().']: ', $bookingElements[0]);

        $bookingElement->setValidator(function ($answer) use ($bookingElementsRepository)
                                        {
                                            if (is_string($answer))
                                                $answer = $bookingElementsRepository->findOneByName($answer);

                                            if (is_null($answer) || !is_object($answer))
                                                throw new \RuntimeException('The element do not exist');

                                            return $answer;
                                        }
                                    );


        return $helper->ask($input, $output, $bookingElement);
    }

    protected function getQuantity($input,$output, $bookingElement)
    {

        $helper = $this->getHelper('question');

        $bookingType = $this->getContainer()->getParameter('app.booking')['bookingPropertyType'];
        $maxOfElements = $bookingElement->getQuantity();
        $bookingQuantity = new Question('Quantity of ' .$bookingType. '[Max: '.$maxOfElements.']: ', 1);


        $bookingQuantity->setValidator(function ($answer) use ($maxOfElements)
                                        {

                                            if (preg_match('/[^0-9]/',$answer))
                                                throw new \RuntimeException('must be a number');

                                            $answer = (int) $answer;

                                            if ($answer > $maxOfElements)
                                                throw new \RuntimeException( $answer .' do no be upper '. $maxOfElements);

                                            return $answer <= 0 ? $answer : 1;
                                        }
                                    );


        return $helper->ask($input, $output, $bookingQuantity);
    }

    public function getEmail($input,$output)
    {
        $helper = $this->getHelper('question');

        $bookingEmail = new Question('Email of the booking: ');

        return $helper->ask($input, $output, $bookingEmail);
    }

    public function renderTable($output, $bookings)
    {
        $table = new Table($output);

        $table->setHeaders(array('Id','Date Start', 'Date End','Days' ,'Room Type', 'Quantity', 'Total Price'));

        $table->addRow($this->getRow($bookings));

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
            $booking->getTotal() . ' '.$this->getContainer()->get('booking.service')->getBookingConfiguration('money')];
    }

}
