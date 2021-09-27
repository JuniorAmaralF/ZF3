<?php

namespace Core\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

abstract class AbstractCoreMOdelTable
{
    protected $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getBy(array $params)
    {
        $rowset = $this->tableGateway->select($params);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException('Could not find row');
        }
        
        return $row;
    }
    
    public function save(array $data)
    {   //quando e um update
        if(isset($data['id'])) {
            $id = (int) $data['id'];
            
            if (! $this->getBy(['id' =>$id])){
                throw new RuntimeException(sprintf(
                    'Cannot update identifier %d; does not exists',
                    $id
                    ));
            }
            
            $this->tableGateway->update($data,['id' => $id]);
            
            return $this->getBy(['id' => $id]);
        }
        
        $this->tableGateway->insert($data);
        
        return $this->getBy(['id' => $this->tableGateway->getLastInsertValue()]);
    }
    
    public function delete($id){
        $this->tableGateway->delete(['id' => (int)$id]);
    }
    
}





