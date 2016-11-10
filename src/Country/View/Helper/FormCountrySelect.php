<?php
namespace BasicInvoices\Iso\Country\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;
use BasicInvoices\Iso\Country\CountryManager;

class FormCountrySelect extends AbstractHelper
{
    protected $countryManager;
    
    /**
     * Attributes valid for select
     *
     * @var array
     */
    protected $validSelectAttributes = [
        'name'         => true,
        'autocomplete' => true,
        'autofocus'    => true,
        'disabled'     => true,
        'form'         => true,
        'multiple'     => true,
        'required'     => true,
        'size'         => true
    ];
    
    public function __construct(CountryManager $countryManager)
    {
        $this->countryManager = $countryManager;
    }
    
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|FormSelect
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }
    
        return $this->render($element);
    }
    
    /**
     * Render a form <select> element from the provided $element
     *
     * @param  ElementInterface $element
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $countries       = [];
        $countriesSource = $this->countryManager->getAll();
        foreach ($countriesSource as $country) {
            $countries[] = [
                'alpha_2' => $country->alpha_2,
                'alpha_3' => $country->alpha_3,
                'name'    => $this->translator->translate($country->name, 'iso-3166-1'),
            ];
        }
        
        usort($countries, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        
        $name = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }
        
        $attributes = $element->getAttributes();
        $attributes['name'] = $name;
        
        $this->validTagAttributes = $this->validSelectAttributes;
        
        $rendered  = sprintf('<select %s>', $this->createAttributesString($attributes));
        
        foreach ($countries as $country) {
            $rendered .= sprintf('<option value="%s">%s</option>', $country['alpha_3'], $country['name']);
        }

        $rendered .= '</select>';
        
        return $rendered;
    }
}