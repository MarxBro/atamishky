# dev branch

Acá toco lo que se me antoja como quiero y no explico a nadie de que carajo va.

Mentira, la explicación está abajo.

# Objetivos o algo asi

En esta rama hay objetivos que son:

1* Paginar la salida
2* Solucionar efectivamente la cagada de las comillas y ampersands
~~3* Buscar en autor + titulo + lo-que-carajo-sea~~
4* Sistema de prestamos.
~~5* Mover a /lib y /include las plantillas o datas importantes.~~
6* Sistema de subida csv.
~~7* bibtex output of entry (showentrydetails).~~
~~8* Social links... ponele.~~
~~9* salida norma APA.~~


## 1

A veces la salida es larga y rompe los huevos, además de significar mayor ancho de banda.

Hay que scrollear como un forro para encontrar algo (o usar CTRL + F y listo...).

### Guarda eh

Desestimo el verdadero valor de esta idea: salvar ancho de banda, no salvaría un carajo y 
la salida paginada es medio rompe-huevos.

Por el momento no es prioridad ni mucho menos, tiene cierta mística e impresiona a la gilada que la salida sea larga.

## 2 

Esto si que es una gran cagada:

el archivo csv puede tener ampersands y comillas simples.

El script en Perl las convierte en sus cifrados XMListicos: &amp; y &quot;.

Hasta acá va joya, pero el problema recién empieza...

php hace la conversion XSLT + XML, y cuando la hace, reemplaza $quot; por ', como es de esperarse.

El problema es cuando hay editorial como O'Reilly o T&B, ya que pueden ser una categoria y terminar dentro
de una etiqueta: 

```html`
<a href="something" onclick="somFunction('O'Reilly')"> 
```
`
y cagar el js de la pag redereada.

Por el momento, la solución fue volar las comillas (antes de morir en el intento de sacarlas con XSLT), pero
**hay que hacer algo sustancialmente mejor y rápido!**.

## 3 -- LISTO!

Esto se le ocurrió a Juan, ya que hay resultados que pueden no aparecer correctamente o como uno esperaría.

La idea sería buscar en cualquier cosa dentro de la entrada xml, así si el autor es Borges (p.ej.) o si el titulo
incluye Borges, aparece en la lista de resultados y a Juancito no se le cansa la mano de tanto escribir/cliquear...

## 4 

Algo que sirva para setear el status de un libro, puede estar prestado o no.

Se me habia ocurrido lo siguiente:

Asi como hay un link "mas info", agregar uno que pida un password y cambie el estado del libro a "prestado"

El problema es donde mierda va el password, ya que eso seria via js y js se renderea en el browser...

## 5 -- LISTO!!

Mover todos los templates a lib/template o algo asi.

En definitiva, ordenar los archivos importantes en una estructura arborescente (como un arbolito, se).

## 6

Algo que lamentablemente va a tener que hacerse, es permitir la subida csv del catalogo y regenerar 
"catalogo.xml" al vuelo.

Es medio jodido y necesariamente va a tener que hacerse via php + cgi + perl...

Por el momento, no es prioridad.

## 7 -- LISTO!

Esto seria para referenciar las referencias referenciables acorde a los estandares mas estandarizados de referencias referenciables proveidos por las mayores autoridades en la rama de la referenciacion bibliotologica y nomenclatura hlistica-morfo-semantica de los indices bibliologicos... valga la redundancia.

O sea, hacer un xslt que transforme en bibtex la entrada desde el link mas info (showentrydetails) asi se pueden bajar un bibtex que sirve para indexar la cosa en cuestion.

## 8 -- LISTO!

Ponele que agregamos linkitos a facebook y twitter... ponele.

Es una huevada de hacer, pero dudo que sea algo util o que alguien lo vaya a usar...

No es prioridad... no es nada en realidad, pero se me dio por escribirlo.

## 9 -- ESQUELETEADO

APAlala... ja.

APA es una norma bibliografica de la gente que bibliografea bibliograficamente.

La cosa seria hacer que el div bibbody muestre una entrada APA valida desde la data del xml.

** ME FALTARIA RETOCAR EL XSL **

le agregue ISO tambien, para que sean felices los niños.


-------

## changui

Le agregue un ekeko verificador de los xsl, que usa checksums y cosas asi.
La idea es prevenir xss usando checksums on-the-fly. No se hasta donde es verdaderamente util...
