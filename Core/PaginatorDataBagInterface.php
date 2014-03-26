<?php

namespace LFX\PaginatorBundle\Core;



interface PaginatorDataBagInterface {

    //paginacion
    
    public function getFullCount();
    public function setFullCount($count);
    public function setLimit($limit);
    public function getLimit();
    public function setPage($page);
    public function getPage();
    public function setCount($count);
    public function getCount();
    public function setOrder($order);
    public function getOrder();
    public function setOrderField($prefix,$field);
    public function getOrderField();
    public function setFormFilterData($key,$value);
    public function getFormFilterData();
    public function setFormFilterName($name);
    public function getFormFilterName();
    //data
    
    public function setEntities(array $array);
    public function getEntities();
    
    
}

?>
