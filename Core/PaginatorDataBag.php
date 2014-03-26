<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\PaginatorDataBagInterface;

class PaginatorDataBag implements PaginatorDataBagInterface {
    
    private $entities=null;
    private $count=null;
    private $fullCount=null;
    private $limit=null;
    private $page=null;
    private $order=null;
    private $orderField=null;
    private $formFilterData=array();
    private $formFilterName=null;
    
    public function getCount() {
        return $this->count;
    }

    public function getEntities() {
        return $this->entities;
    }

    public function getFullCount() {
        return $this->fullCount;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getPage() {
        return $this->page;
    }

    public function setCount($count) {
        $this->count=$count;
    }

    public function setEntities(array $array) {
        $this->entities=$array;
    }

    public function setFullCount($count) {
        $this->fullCount=$count;
    }

    public function setLimit($limit) {
        $this->limit=$limit;
    }

    public function setPage($page) {
        $this->page=$page;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getOrderField() {
        return $this->orderField;
    }

    public function setOrder($order) {
       $this->order=$order;
    }

    public function setOrderField($prefix,$field) {
        $this->orderField=$prefix."_".$field;
    }
    
    public function setOrderField2($path){
        
        $this->orderField=$path;
    }

    
    
    public function getFormFilterData(){
        return $this->formFilterData;
    }

    public function setFormFilterData($key,$value) {
        $this->formFilterData[$key]=$value;
    }

    public function getFormFilterName() {
        return $this->formFilterName;
    }

    public function setFormFilterName($name) {
        $this->formFilterName=$name;
    }    
}

?>
