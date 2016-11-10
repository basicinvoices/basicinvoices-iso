<?php
namespace BasicInvoices\Iso\Country;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

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
        
        $resultSet = new ResultSet();
        $resultSet->initialize($result);
        
        return $resultSet;
    }
    
    
}