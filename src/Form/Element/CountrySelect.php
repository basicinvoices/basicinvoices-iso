<?php
namespace BasicInvoices\Iso\Form\Element;

use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\Regex as RegexValidator;

class CountrySelect extends Element implements InputProviderInterface
{
    /**
     * Provide default input rules for this element
     * 
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInput()}.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        $spec = [
            'name' => $this->getName(),
            'required' => true,
        ];
        
        if ($validator = $this->getValidator()) {
            $spec['validators'] = [
                $validator,
            ];
        }
        
        return $spec;
    }
    
    /**
     * Get validator
     *
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return new RegexValidator('/^[A-Z]{2,3}$/');
    }
    
    /**
     * Set options for an element. Accepted options are:
     * - label: label to associate with the element
     * - label_attributes: attributes to use when the label is rendered
     * - empty_option: should an empty option be prepended to the options ?
     *
     * @param  array|Traversable $options
     * @return CountrySelect|ElementInterface
     * @throws InvalidArgumentException
     */
    public function setOptions($options)
    {
        parent::setOptions($options);
    
        if (isset($this->options['empty_option'])) {
            $this->setEmptyOption($this->options['empty_option']);
        }
    
        if (isset($this->options['disable_inarray_validator'])) {
            $this->setDisableInArrayValidator($this->options['disable_inarray_validator']);
        }
    
        if (isset($options['use_hidden_element'])) {
            $this->setUseHiddenElement($options['use_hidden_element']);
        }
    
        if (isset($options['unselected_value'])) {
            $this->setUnselectedValue($options['unselected_value']);
        }
    
        return $this;
    }
}