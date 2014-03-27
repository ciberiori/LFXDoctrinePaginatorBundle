LFXDoctrinePaginatorBundle BETA
==========================

Hola mi nombre es Victor Lopez de LFX Studios y este es LFXDoctrinePaginatorBundle , un paginador para symfony2 pensado en filtros , un tema que no es facil de resolver . este bundle lo tiene casi todo.

La paginacion siempre ha sido un tema dificil sobretodo cuando tratamos con filtros, ya que ir pasando lo valores por los enlaces cuando mostramos datos es complicado y requiere una logica compleja


LFXDoctrinePaginatorBundle funciona con los siguientes objetos:

Core
=======

LFX\PaginatorBundle\Core

-PaginatorService : lfx_paginator  ( El servicio que ahi que llamar desde el controlador )
-EntityDefinition :                ( Una clase que guarda la definicion de la entidad que queremos filtrar )
-JoinEntityDefinition:             ( Una clase que guarda todo lo referente a los joins con otros objetos)
-PaginatorDataBag :                ( Clase que guarda todos los parametros que se van a pasar a la vista )


-PaginatorServiceInterface :          ( interface para la clase PaginatorService )
-EntityDefinitionInterface :          ( interface para la clase EntityDefinition )
-JoinEntityDefinitionInterface :      ( interface para la clase JoinEntityDefinition )
-PaginatorDataBagInterface :          ( interface para la clase PaginatorDataBag )

Twig
====

