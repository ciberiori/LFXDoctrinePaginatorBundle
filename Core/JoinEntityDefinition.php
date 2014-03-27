<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\JoinEntityDefinitionInterface;

class JoinEntityDefinition implements JoinEntityDefinitionInterface{
    
    private $prefix=null;
    private $pathBundle=null;
    private $onClausules=array();
    private $joinType=null;
    
    
    public function __construct($targetPrefix,$targetPathBundle,array $onClausule,$joinType= JoinEntityDefinitionInterface::INNER) {
   
        $this->prefix=$targetPrefix;
        $this->pathBundle=$targetPathBundle;
        $this->onClausules=$onClausule;
        $this->joinType=$joinType;
        
    }
    
    public function getOnClausule() {
        return $this->onClausules;
    }

    public function getTargetPathBundle() {
        return $this->pathBundle;
    }

    public function getTargetPrefix() {
        return $this->prefix;
    }

    public function setOnClausule($clausuleA,$clausuleB) {
        array_push($this->onClausules, $clausuleA);
        array_push($this->onClausules, $clausuleB);
    }

    public function setTargetPathBundle($path) {
        $this->pathBundle=$path;
    }

    public function setTargetPrefix($prefix) {
        $this->prefix=$prefix;
    }   
    
      public function getTypeJoin() {
        return $this->joinType;
    }

    public function setTypeJoin($type) {
        
        if($type==JoinEntityDefinitionInterface::INNER||$type==JoinEntityDefinitionInterface::LEFT){
            
                  $this->joinType=$type;  
                  return;
        }
                throw new \LogicException("el tipo del joint solo puede ser LEFT , INNER o RIGHT");
    } 
}

?>
