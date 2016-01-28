<?php

namespace CarlosGude\BookingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Validator\Constraints\EmailValidator;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 *
 * TODO: 2. Crear varaible para la plantilla del email reservas.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('carlos_gude_booking');

        $rootNode->children()
                    ->booleanNode('showFlash')
                        ->defaultTrue()
                    ->end()
                    ->booleanNode('autoSaveBooking')
                        ->defaultTrue()
                    ->end()
                    ->booleanNode('hasDateEnd')
                        ->defaultTrue()
                    ->end()
                    ->scalarNode('bookingElementName')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('discriminatorElement')
                        ->defaultValue('id')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('methodSearchBookingElements')
                        ->defaultValue('getFreeRoomTypes')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('money')
                        ->defaultValue('Euros')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('bookingPropertyType')
                        ->defaultValue('Rooms')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('emailTemplate')
                        ->defaultValue('CarlosGudeBookingBundle:Email:booking.html.twig')
                        ->cannotBeEmpty()
                    ->end()
                    ->arrayNode('class')
                        ->children()
                            ->scalarNode('masterElementEntity')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('bookingElementEntity')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('bookingEntity')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('rateEntity')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
