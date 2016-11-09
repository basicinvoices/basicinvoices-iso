<?php
namespace BasicInvoices\Iso\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use BasicInvoices\Iso\Form\Element\CountrySelect;
use Zend\Form\ElementInterface;
use Zend\Stdlib\ArrayUtils;

class FormCountrySelect extends AbstractHelper
{
    /**
     * Attributes valid for options
     *
     * @var array
     */
    protected $validOptionAttributes = [
        'disabled' => true,
        'selected' => true,
        'label'    => true,
        'value'    => true,
    ];
    
    
    /**
     * Locale to use
     *
     * @var string
     */
    protected $locale;
    
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
        if (!$element instanceof CountrySelect) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type BasicInvoices\Iso\Form\Element\CountrySelect',
                __METHOD__
            ));
        }
    
        $name   = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
                ));
        }
    
        //$options = $element->getValueOptions();
        $options = [
            [
                'value' => 'ESP',
                'label' => 'Spain',
            ],
            [
                'value' => 'ENG',
                'label' => 'United Kingdom',
            ]
        ];
    
        //if (($emptyOption = $element->getEmptyOption()) !== null) {
        //    $options = ['' => $emptyOption] + $options;
        //}
    
        $attributes = $element->getAttributes();
        //$value      = $this->validateMultiValue($element->getValue(), $attributes);
        // TODO this is the selected option
        //$value = $options;
        //$value = ['ESP'];
        $value = [];
    
        $attributes['name'] = $name;
        //if (array_key_exists('multiple', $attributes) && $attributes['multiple']) {
        //    $attributes['name'] .= '[]';
        //}
        //$this->validTagAttributes = $this->validSelectAttributes;
    
        $rendered = sprintf(
            '<select %s>%s</select>',
            $this->createAttributesString($attributes),
            $this->renderOptions($options, $value)
        );
    
        // Render hidden element
        //$useHiddenElement = method_exists($element, 'useHiddenElement')
        //&& method_exists($element, 'getUnselectedValue')
        //&& $element->useHiddenElement();
    
        //if ($useHiddenElement) {
        //    $rendered = $this->renderHiddenElement($element) . $rendered;
        //}
    
        return $rendered;
    }
    
    /**
     * Render an array of options
     *
     * Individual options should be of the form:
     *
     * <code>
     * array(
     *     'value'    => 'value',
     *     'label'    => 'label',
     *     'disabled' => $booleanFlag,
     *     'selected' => $booleanFlag,
     * )
     * </code>
     *
     * @param  array $options
     * @param  array $selectedOptions Option values that should be marked as selected
     * @return string
     */
    public function renderOptions(array $options, array $selectedOptions = [])
    {
        $template      = '<option %s>%s</option>';
        $optionStrings = [];
        $escapeHtml    = $this->getEscapeHtmlHelper();
    
        foreach ($options as $key => $optionSpec) {
            $value    = '';
            $label    = '';
            $selected = false;
            $disabled = false;
    
            //$optionSpec = [
            //    'label' => $optionSpec['name'],
            //    'value' => $optionSpec['alpha_3'],
            //];
            
    
            if (isset($optionSpec['options']) && is_array($optionSpec['options'])) {
                $optionStrings[] = $this->renderOptgroup($optionSpec, $selectedOptions);
                continue;
            }
    
            if (isset($optionSpec['value'])) {
                $value = $optionSpec['value'];
            }
            if (isset($optionSpec['label'])) {
                $label = $optionSpec['label'];
            }
            if (isset($optionSpec['selected'])) {
                $selected = $optionSpec['selected'];
            }
            if (isset($optionSpec['disabled'])) {
                $disabled = $optionSpec['disabled'];
            }
    
            if (ArrayUtils::inArray($value, $selectedOptions)) {
                $selected = true;
            }
    
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label,
                    $this->getTranslatorTextDomain()
                );
            }
    
            $attributes = compact('value', 'selected', 'disabled');
    
            if (isset($optionSpec['attributes']) && is_array($optionSpec['attributes'])) {
                $attributes = array_merge($attributes, $optionSpec['attributes']);
            }
    
            $this->validTagAttributes = $this->validOptionAttributes;
            $optionStrings[] = sprintf(
                $template,
                $this->createAttributesString($attributes),
                $escapeHtml($label)
                );
        }
    
        return implode("\n", $optionStrings);
    }
}