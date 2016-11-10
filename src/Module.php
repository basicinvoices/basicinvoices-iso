<?php
namespace BasicInvoices\Iso;

class Module
{
    /**
     * Retrieve default zend-db configuration for zend-mvc context.
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'service_manager' => [
                'factories' => [
                    Country\CountryManager::class => Country\Service\CountryManagerServiceFactory::class,
                ],
            ],
            'translator' => [
                'translation_file_patterns' => [
                    [
                        'type'        => 'gettext',
                        'base_dir'    => __DIR__ . '/../language/iso-3166-1',
                        'text_domain' => 'iso-3166-1',
                        'pattern'     => '%s.mo',
                    ],
                ],
            ],
        ];
    }
    
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
                'formCountrySelect' => Country\View\Helper\Service\FormCountrySelectFactory::class,
            )
        );
    }
}