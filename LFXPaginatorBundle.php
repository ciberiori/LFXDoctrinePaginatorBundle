<?php

namespace LFX\PaginatorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use LFX\PaginatorBundle\DependencyInjection\Compiler\ExtCompilerPass;

class LFXPaginatorBundle extends Bundle
{
    
   public function build(ContainerBuilder $container) {
       parent::build($container);
       
       $container->addCompilerPass(new ExtCompilerPass());
   }
    
    
}
