<?php
namespace BasicInvoices\Iso\Form\Element\Service;

use Zend\ServiceManager\FactoryInterface;
use BasicInvoices\Iso\Form\Element\CountrySelect;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

class CountrySelectFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return CountrySelect
     * @throws ServiceNotCreatedException if Controllermanager service is not found in application service locator
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        //if (! $container->has('ControllerManager')) {
        //    throw new ServiceNotCreatedException(sprintf(
        //        '%s requires that the application service manager contains a "%s" service; none found',
        //        __CLASS__,
        //        'ControllerManager'
        //        ));
        //}
        //$controllers = $container->get('ControllerManager');
    
        return new CountrySelect();
    }
    
    /**
     * Create and return CountrySelect instance
     *
     * For use with zend-servicemanager v2; proxies to __invoke().
     *
     * @param ServiceLocatorInterface $container
     * @return CountrySelect
     */
    public function createService(ServiceLocatorInterface $container)
    {
        $parentContainer = $container->getServiceLocator() ?: $container;
        return $this($parentContainer, CountrySelect::class);
    }
}