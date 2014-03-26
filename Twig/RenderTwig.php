<?php

namespace LFX\PaginatorBundle\Twig;

use LFX\PaginatorBundle\Core\PaginatorDataBag;

class RenderTwig extends \Twig_Extension {
    
    public function renderLinks(PaginatorDataBag $bag,$page,$extra=null){
        
        
        if($page!=0){
        $bag->setPage($page+1);
        }else{
        $bag->setPage(1);    
        }
        $final="?";
        
        $final.="page=".$bag->getPage()."&";
       if(!is_null($extra)){  $final.="order_field=".$extra."&";}else{
       $final.="order_field=".str_replace(".","_",$bag->getOrderField())."&";}
        $final.="order=".$bag->getOrder()."&";
        $final.="limit=".$bag->getLimit()."&";
   
        if( count($bag->getFormFilterData())>0){
            
            foreach($bag->getFormFilterData() as $key=>$value){    
            $value=trim($value);
            if(!empty($value)){
            $final.=$bag->getFormFilterName()."[".$key."]=".$value;
            $final.="&";
            }
            }
        }
        $final_var=  substr($final,0,  strlen($final)-1);
        return $final_var;
        
    }
    
    
    
    public function renderTitleLinks(array $order_field,  PaginatorDataBag $bag){
        
        $bag->setPage(1);
        $_order_field=$order_field[0].".".$order_field[1];
        
        if($bag->getOrderField()==$_order_field){
            
           if($bag->getOrder()=="ASC"){
            
               $bag->setOrder("DESC");               
           }else{
               $bag->setOrder("ASC");
           }   
        }else{
            $bag->setOrder("DESC");
        }
       return  $this->renderLinks($bag,0,$order_field[0]."_".$order_field[1]);    
    }
    
    
    
    public function getFunctions() {
        return array(
            "lfx_render_link"=>new \Twig_Function_Method($this,"renderLinks"),
            "lfx_render_title_link"=>new \Twig_Function_Method($this,"renderTitleLinks")
            );
    }
    
    public function getName() {
    
        return "lfx.render.twig";
        
    }    
    
    
}

?>
