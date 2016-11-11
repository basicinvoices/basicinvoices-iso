<?php
namespace BasicInvoices\Iso\Country;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use BasicInvoices\Iso\Country\Model\Country;

class CountryManager
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
    
    /**
     * @var string|array|TableIdentifier
     */
    protected $table = null;
    
    public function __construct(AdapterInterface $adapter, $table = 'iso_3166_1')
    {
        // table
        if (!(is_string($table) || $table instanceof TableIdentifier || is_array($table))) {
            throw new Exception\InvalidArgumentException('Table name must be a string or an instance of Zend\Db\Sql\TableIdentifier');
        }
        $this->table = $table;
        
        // adapter
        $this->adapter = $adapter;
    }
    
    public function getAll()
    {
        $sql       = new Sql($this->adapter);
        $select    = $sql->select($this->table);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
        
        $resultSet = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new Country());
        $resultSet->initialize($result);
        
        return $resultSet;
    }
    
    public function get($code)
    {
        $key       = 'alpha_3';
        if (preg_match('/^[A-Z]{3}$/', $code)) {
            $key = 'alpha_3';
        } elseif (preg_match('/^[A-Z]{2}$/', $code)) {
            $key = 'alpha_2';
        } elseif (is_numeric($code) && (strlen($code) <= 3)) {
            $code = (int) $code;
            $code = str_pad($code, 3, '0', STR_PAD_LEFT);
            $key  = 'numeric';
        } else {
            throw new \RuntimeException('Invalid code');
        }
        
        $sql       = new Sql($this->adapter);
        $select    = $sql->select($this->table);
        
        $select->where([
            $key => $code,
        ]);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
        
        if (($result instanceof ResultInterface) && ($result->isQueryResult()) && ($result->getAffectedRows() === 1)) {
            return $result->current();    
        }
        
        return [];
    }
    
}