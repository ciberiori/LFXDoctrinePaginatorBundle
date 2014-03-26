<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\EntityDefinitionInterface;

class EntityDefinition implements EntityDefinitionInterface {
    
    private $pathBundle=null;
    private $filters=array();
    private $joinEntityDefinition=null;
    private $prefix=null;
    private $titleOrders=array();
    private $columns=array();
    
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

    public function getTitleOrders() {
        return $this->titleOrders;
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

    public function setTitleOrders(array $array) {
        $this->titleOrders=$array;
    }

    public function getDatabaseColumns() {
        return $this->columns;
    }

    public function setDatabaseColumns(array $array) {
        $this->columns=$array;
    }

     
}

?>