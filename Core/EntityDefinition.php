<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\EntityDefinitionInterface;

class EntityDefinition implements EntityDefinitionInterface {
    
    private $pathBundle=null;
    private $filters=array();
    private $joinEntityDefinition=null;
    private $prefix=null;
    private $columns=array();
    
    
    
    public function __construct($prefix,$pathBundle,array $databaseColumns) {
        $this->prefix=$prefix;
        $this->pathBundle=$pathBundle;
        $this->columns=$databaseColumns;
    }
  
    public function SetPathBundle($path) {
        
        $this->pathBundle=$path;
    }

    public function getFilters() {
        return $this->filters;
    }

    public function getJointEntityDefinition() {
        return $this->joinEntityDefinition;
    }

    public function getPathBundle() {
        
        return $this->pathBundle;
    }

    public function getPrefix() {
        return $this->prefix;
    }

   
    public function setFilters(array $array) {
        $this->filters=$array;
    }

    public function setJointEntityDefinition(\LFX\PaginatorBundle\Core\JoinEntityDefinitionInterface $definition) {
        $this->joinEntityDefinition=$definition;
    }

    public function setPrefix($prefix) {
        $this->prefix=$prefix;
    }

   

    public function getDatabaseColumns() {
        return $this->columns;
    }

    public function setDatabaseColumns(array $array) {
        $this->columns=$array;
    }

     
}

?>
