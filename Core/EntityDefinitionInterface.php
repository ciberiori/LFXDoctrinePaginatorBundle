<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\JoinEntityDefinitionInterface;


interface EntityDefinitionInterface {
    
    
   
    
    public function SetPathBundle($path);
    public function getPathBundle();
    public function setPrefix($prefix);
    public function getPrefix();
    public function setJointEntityDefinition(JoinEntityDefinitionInterface $definition);
    public function getJointEntityDefinition();
    public function setTitleOrders(array $array);
    public function getTitleOrders();
    public function setFilters(array $array);
    public function getFilters();
    public function setDatabaseColumns(array $array);
    public function getDatabaseColumns();
 
}

?>
