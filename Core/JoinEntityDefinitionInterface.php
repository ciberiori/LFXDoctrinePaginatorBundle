<?php


namespace LFX\PaginatorBundle\Core;



interface JoinEntityDefinitionInterface {
    
    const INNER="INNER";
    const LEFT="LEFT";
  
    
    public function setTargetPathBundle($path);
    public function getTargetPathBundle();
    public function setTargetPrefix($prefix);
    public function getTargetPrefix();
    public function setOnClausule($clausuleA,$clausuleB);
    public function getOnClausule();
    public function setTypeJoin($type);
    public function getTypeJoin();
}

?>
