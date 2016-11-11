<?php
namespace BasicInvoices\Iso\Country\Model;

class Country
{
    protected $alpha2;
    
    protected $alpha3;
    
    protected $numeric;
    
    protected $name;
    
    protected $officialName;
    
    public function __get($name)
    {
        switch ($name) {
            case 'alpha2':
            case 'alpha_2':
                return $this->alpha2;
            case 'alpha3':
            case 'alpha_3':
                return $this->alpha3;
            case 'numeric':
                return $this->numeric;
            case 'name':
                return $this->name;
            case 'officialName':
            case 'official_name':
                return $this->officialName;
        }
    }
    
    public function exchangeArray($input)
    {
        $this->alpha2       = isset($input['alpha_2'])       ? $input['alpha_2']       : null;
        $this->alpha3       = isset($input['alpha_3'])       ? $input['alpha_3']       : null;
        $this->numeric      = isset($input['numeric'])       ? $input['numeric']       : null;
        $this->name         = isset($input['name'])          ? $input['name']          : null;
        $this->officialName = isset($input['official_name']) ? $input['official_name'] : null;
    }
    
    public function getAlpha2()
    {
        return $this->alpha2;
    }
    
    public function getAlpha3()
    {
        return $this->alpha3;
    }
    
    public function getNumeric()
    {
        return $this->numeric;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getOfficialName()
    {
        return $this->officialName;
    }
}
