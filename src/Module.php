<?php
namespace BasicInvoices\Iso;

class Module
{
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'CountrySelect' => Form\Element\Service\CountrySelectFactory::class,
            )
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'formCountrySelect' => function($sm) {
                    $helper = new View\Helper\FormCountrySelect() ;
                    return $helper;
                }
            )
        );
    }
}