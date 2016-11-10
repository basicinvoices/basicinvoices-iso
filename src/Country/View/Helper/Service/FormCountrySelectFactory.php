<?php
namespace BasicInvoices\Iso\Country\View\Helper\Service;

use BasicInvoices\Iso\Country\CountryManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BasicInvoices\Iso\Country\View\Helper\FormCountrySelect;

class FormCountrySelectFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param null|array $options
     * @return \BasicInvoices\Iso\View\Helper\FormCountrySelect
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        // test if we are using Zend\ServiceManager v2 or v3
        if (! method_exists($container, 'configure')) {
            $container = $container->getServiceLocator();
        }
        
        $countryManager = $container->get(CountryManager::class);
        
        $helper = new FormCountrySelect($countryManager);
        
        return $helper;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $rName = null, $cName = null)
    {
        return $this($serviceLocator, $cName);
    }
}
