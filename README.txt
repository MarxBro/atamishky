# Atamishky
 
Proyecto de sistema web de **referencias bibliográficas**. 
(El nombre sale de ATAM, y de una chacarera de Leo Dan).
 
La idea es permitir la búsqueda en un catálogo bibliográfico, 
que sea simple de entender y mantener.
 
El catálogo completo es un único archivo xml. No necesita DB.



## Objetivo Final

Conseguir un sistema que permita filtrar bibliografía acorde a criterios de
búsqueda dinámicos, donde cualquier parte de un título puede ser uno.


## XML

Para convertir el catalogo a xml, incluyo un script que parsea y
elabora el catalog a partir de un csv.

Opcionalmente, la salida va a un txt también.

Ver en /lib.


## Bugs y giladas actuales

* Búsqueda por qutor no funciona en Firefox (js).
* Rss feed channel titulo, no aparece en Opera rss reader.
* css no centrado
* css... todo.
* index: Mostar solo las 5 entradas mas nuevas.
* asegurar todos los users inputs y xml requests (XSS).

## Nótese

Está hecho en base a Bebop, aunque fue reelaborado y muchas de sus partes 
reemplazadas/editadas/mejoradas/empeoradas.

Los iconos son del kit Faenza (una version vieja que tenía por ahi) .

Por el momento el estamos usando csv para pasar todo a xml: de un formato estúpido a uno más estúpido! :P


## Licencia

Hasta que esté completo, el código va a estar alojado acá (después vemos).

Por el momento, BSD License.

(Ver LICENSE.txt)

 
-----
Acerca de Bebop: http://people.alari.ch/derino/Software/Bebop/

Licencia de Bebop: http://people.alari.ch/derino/Software/Bebop/LICENSE.txt
