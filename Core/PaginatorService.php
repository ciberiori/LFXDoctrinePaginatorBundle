<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\PaginatorServiceInterface;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Doctrine\ORM\Query\Expr\Join;

class PaginatorService implements PaginatorServiceInterface{
    
    private $entitiesDefinition=array();
    private $joinTypeDefinitions=array();
    private $request=null;
    private $formFactory=null;
    private $entityManager=null;
    private $dataBag=null;
    
    
    
    private $query=null;
    private $count_query=null;
    private $expr_doctrine=null;
    private $formFilter=null;
    private $_countJoinDefinitions=0;
    
    public function getFormFilter(){
        
        return $this->formFilter->getForm();
    }
    
    public function addEntityDefinition(EntityDefinitionInterface $entity) {
        
        if(count($entity->getDatabaseColumns())==0){
            
            throw new \LogicException("Lo Sentimos : las entidades tienen que tener definidas las columnas de la base de datos que se van a recuperar");
            
        }
        
        array_push($this->entitiesDefinition, $entity);
        if ($entity->getJointEntityDefinition()!=null){
            $this->_countJoinDefinitions++;
            
        }
    }

    public function addJoinTypeDefinition(JoinEntityDefinitionInterface $join) {
        array_push($this->joinTypeDefinitions,$join);
    }

   

    public function setEntityManager(\Doctrine\ORM\EntityManagerInterface $manager) {
        $this->entityManager=$manager;
    }

    public function setFormFactory(\Symfony\Component\Form\FormFactoryInterface $factory) {
        $this->formFactory=$factory;
    }

    public function setRequest(\Symfony\Component\HttpFoundation\RequestStack $request) {
        $this->request=$request;
    }    
    
     public function haveToPaginate() {
        
         if (count($this->entitiesDefinition) == 0) {
            throw new LogicException(sprintf('Lo sentimos: Tiene que existir por lo menos un entityDefinition %s ', "EntitiesDefinitions"));
        } 
        
        if($this->dataBag->getlimit()==null){
            
            
            throw  new \LogicException("Lo sentimos: El limite y el campo de orden no se han establecido");
        }
        
        if($this->dataBag->getOrderField()==null){
            
            throw  new \LogicException("Lo sentimos: El campo de orden no se ha establecido");
            
        }
        
        
        $this->_initialize();
        $this->_buildForm();
        $this->_catchRequest();
        $this->_preparedDatabaseColumns(); 
        $this->_checkFormAndAddWhereAndOrder();
        
        $dql1=$this->query->getDql();
        $dql2=$this->count_query->getDql();
        
        $this->_addLimitsAndExecute();

        
        
       
      
        echo "";
    }
    
    private function _initialize(){
        
        $this->query         = $this->entityManager->createQueryBuilder();
        $this->count_query   = $this->entityManager->createQueryBuilder();
        $this->expr_doctrine = $this->query->expr();
        $this->request
        
    }
    
    
    private function _buildForm()
    {
        $default_values    = array(
            "required" => false
        );
        $this->formFilter = $this->formFactory->createBuilder();
        $this->formFilter->setMethod("GET");
        $this->dataBag->setFormFilterName($this->formFilter->getName());
        foreach($this->entitiesDefinition as $ent){
            
            foreach($ent->getFilters() as $value){
                
           if (is_array($value)) {
               $default_values["data"] = $this->request->getCurrentRequest()->get($this->formFilter->getName() . "[" . $ent->getPrefix()."_".$value[0] . "]", "", true);
                   if($this->request->getCurrentRequest()->query->has($value[0])){
                         $default_values["data"]=$this->request->getCurrentRequest()->get($ent->getPrefix()."_".$value[0]);
                         $default_values["label"]=$value[0];
                    }
               $this->formFilter->add($ent->getPrefix()."_".$value[0], $value[1], array_merge($default_values, $value[2]));
                    }else if (is_string($value)) {
                    $default_values["data"] =$this->request->getCurrentRequest()->get($this->formFilter->getName() . "[" . $ent->getPrefix()."_".$value . "]", "", true);
                    $default_values["label"]=$value;
                    $this->formFilter->add($ent->getPrefix()."_".$value, "text", $default_values);
                }
        }
        }
    }
    
    
    private function _preparedDatabaseColumns()
    {
        
        if((count($this->entitiesDefinition)-1)!=$this->_countJoinDefinitions){
            
            
            throw new \LogicException("exiten ".count($this->entitiesDefinition)." entidad(es) por lo tanto se tienen que definir ".(count($this->entitiesDefinition)-1)." definicio(es) Joint (JoinEntityDefinition) , y no se encuentra");
        }
        
        
        $this->count_query->select("COUNT(" . $this->entitiesDefinition[0]->getPrefix() . ")");
         $_pass=false;      
        foreach ($this->entitiesDefinition as $ent) {
            if (count($ent->getDatabaseColumns()) == 0) {
                $this->query->addSelect($ent->getPrefix());
            } else {
                foreach ($ent->getDatabaseColumns() as $column) {
                    
                    $this->query->addSelect($ent->getPrefix() . "." . $column." AS ".$ent->getPrefix()."_".$column);
                }
            }
           
            if(!$_pass){
            $this->query->from($ent->getPathBundle(), $ent->getPrefix());
            $this->count_query->from($ent->getPathBundle(), $ent->getPrefix());
            }
            $_pass=true;
            $this->_addJoin($ent);
            }       
        }
        
        
        
        private function _addJoin(EntityDefinitionInterface $ent){
        
       
      if($ent->getJointEntityDefinition()!=null){
         $_clausules=$ent->getJointEntityDefinition()->getOnClausule();
        
         $_target_bundle=$ent->getJointEntityDefinition()->getTargetPathBundle();
         $_target_prefix=$ent->getJointEntityDefinition()->getTargetPrefix();
         $_clausule=$ent->getPrefix().".".$_clausules[0]."=".$ent->getJointEntityDefinition()->getTargetPrefix().".".$_clausules[1];
         $_typeJoinClausule=Join::WITH;
          
          
       switch($ent->getJointEntityDefinition()->getTypeJoin()){
         
           case JoinEntityDefinitionInterface::INNER:
           $this->query->innerjoin($_target_bundle,$_target_prefix,$_typeJoinClausule,$_clausule); 
           $this->count_query->innerjoin($_target_bundle,$_target_prefix,$_typeJoinClausule,$_clausule);     
           break;
           case JoinEntityDefinitionInterface::LEFT:
           $this->query->leftjoin($_target_bundle,$_target_prefix,$_typeJoinClausule,$_clausule);   
           $this->count_query->leftjoin($_target_bundle,$_target_prefix,$_typeJoinClausule,$_clausule);     
           break;
       }   
      } 
          
    }
    
     
    
    
     private function _catchRequest()
    {
        $this->dataBag->setPage($this->request->getCurrentRequest()->get("page", 1, true));
        $this->dataBag->setOrder($this->request->getCurrentRequest()->get("order", "DESC", true));
        $this->dataBag->setOrderField2($this->request->getCurrentRequest()->get("order_field",$this->dataBag->getOrderField(), true));
        $this->dataBag->setLimit($this->request->getCurrentRequest()->get("limit",$this->dataBag->getLimit(), true));
   
        $_parts_order_field=split("_",$this->dataBag->getOrderField(),2);
        $this->dataBag->setOrderField2($_parts_order_field[0].".".$_parts_order_field[1]);
        
    }
    
    
    private function _checkFormAndAddWhereAndOrder()
    {
        
        if ($this->request->getCurrentRequest()->get($this->formFilter->getName())) {
            $request_form = $this->request->getCurrentRequest()->get($this->formFilter->getName());
            if (isset($request_form["limit"])) {
                    if($request_form["limit"]!=0 && !is_null($request_form["limit"])){
                     $this->dataBag->setLimit(intval($request_form["limit"]));        
                    }
                unset($request_form["limit"]);
            }
            
            if (isset($request_form["order"])) {
                $this->dataBag->setOrder($request_form["order"]);
                unset($request_form["order"]);
            }
            
            if (isset($request_form["_token"])) {   
                unset($request_form["_token"]);
            }
            
            if (isset($request_form["order_field"])) {
                if(strlen($request_form["order_field"])!=0 && !is_null($request_form["order_field"])){
                $this->dataBag->setOrderField($request_form["order_field"]);
                unset($request_form["order_field"]);
                }
            }
            
            
            foreach ($request_form as $key => $value) {
                
                $value = trim($value);
                $parts=split("_", $key,2);
                
                if (!empty($value)) {
                    
                    $this->query->andWhere($this->expr_doctrine->like($parts[0] . "." . $parts[1], "'%" . $value . "%'"));
                    $this->count_query->andWhere($this->expr_doctrine->like($parts[0] . "." . $parts[1], "'%" . $value . "%'"));
                     $this->dataBag->setFormFilterData($key,$value);
                   
                }
                
                 
                 $this->query->orderby($this->dataBag->getOrderField(), $this->dataBag->getOrder());
                
            }
           
        } else {
            
            $this->query->orderby($this->dataBag->getOrderField(),$this->dataBag->getOrder());
        }
    }
    
    
    private function _addLimitsAndExecute()
    {
        
        
        $_ac= $this->count_query->getQuery()->getArrayResult();
        $this->dataBag->setFullCount(intval($_ac[0][1]));
        $this->dataBag->setEntities($this->query->getQuery()->setFirstResult(($this->dataBag->getPage() - 1) * $this->dataBag->getLimit())->setMaxResults($this->dataBag->getLimit())->getArrayResult());
        $_count= intval($this->dataBag->getFullCount() / $this->dataBag->getLimit());
        
        if(($this->dataBag->getFullCount()%$this->dataBag->getLimit())==0){
            
         $this->dataBag->setCount(--$_count);
        }else{
         $this->dataBag->setCount($_count);   
        }
        if($this->dataBag->getCount()==-1){
            
            $this->dataBag->setCount(0);   
        }
    }
    
    

    public function setPaginatorDataBag(PaginatorDataBagInterface $dataBag) {
        $this->dataBag=$dataBag;
    }
    
    
    public function setLimit($limit){
        
        $this->dataBag->setLimit($limit);
        
    }
    
    
    public function setOrderField($prefix,$field){
        
        $this->dataBag->setOrderField($prefix,$field);
    }
    
    public function setOrder($order){
        
        $this->dataBag->setOrder($order);
        
    }
    
    
    public function getDataBag(){
        
        return $this->dataBag;
    }
    
    
    
    public function addFormFilterLimitField($label,array $choices){
        
        
      $this->formFilter->add("limit","choice",array("label"=>$label,"choices"=>$choices,"required"=>true,"data"=>$this->dataBag->getLimit()));  
    }
    
    
    public function addFormFilterOrderField($label,$label_asc,$label_desc){
        
      $this->formFilter->add("order","choice",array("required"=>true,"label"=>$label,"choices"=>array("ASC"=>$label_asc,"DESC"=>$label_desc),"data"=>$this->dataBag->getOrder()));
        
    }
}

?>