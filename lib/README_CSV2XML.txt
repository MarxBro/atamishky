SYNOPSIS
    Script para generar XML valido desde archivos csv, para utilizarlo como
    catalogo o indice de la bibliografia de Atamishky.

  Forma de uso:
    c Salida compacta : sin saltos de linea, ni espacios.
    f Archivo input : Ver debajo sobre el formato (csv),
    o Archivo Output : Opcional, por defecto STDOUT.
    h (Esta) Ayuda.
    d Debug.

Archivo en la entrada
    El archivo csv tiene que respetar en su encabezado, el siguiente orden:

    * tipo * titulo * autores * editorial * año * ciudad * bibliografia *
    link * soporte * descripcion

    Los valores en todo el csv se separan con la pipa |.

   tipos
    Los tipos posibles son :

    * musica * video * book * misc

   Autores
    Si la entrada tiene mas de un autor, separar con comas.

   valores vacios
    Si no hay bibliografia o link que poner, no poner nada.

   Soporte
    El campo soporte solo tiene sentido si el tipo de entrada es igual a
    video.

Autor y Licencia.
    Programado por Marxbro aka Gstv, ditribuir solo bajo la licencia WTFPL:
    *Do What the Fuck You Want To Public License*.

    Zaijian.

