<?php

namespace LFX\PaginatorBundle\Core;

use LFX\PaginatorBundle\Core\EntityDefinitionInterface;
use LFX\PaginatorBundle\Core\JoinEntityDefinitionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

interface PaginatorServiceInterface {
    
    
    public function addEntityDefinition(EntityDefinitionInterface $entity);
    public function addJoinTypeDefinition(JoinEntityDefinitionInterface $join);
    public function setRequest(RequestStack $request);
    public function setFormFactory(FormFactoryInterface $factory);
    public function setEntityManager(EntityManagerInterface $manager);
    public function setPaginatorDataBag(PaginatorDataBagInterface $dataBag);
    public function haveToPaginate();
    
}

?>
