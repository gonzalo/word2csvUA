# word2csv converter
## Proyecto "Archivo de represariados" del Archivo de la Democracia

- Se pretende convertir una colección de documentos word en una serie de
documentos CSV que puedan ser cargados en una BD con un formato dado

- Documentos originalmente en word (.doc o .docx). Inicia el título de la
población y por cada párrafo hay un nombre de represariado en formato siempre
igual seguido de su población y su resumen de archivo.
>ANTOLÍ CERDÁ, Fructuoso. Natural y vecino de Agres, escribiente, de 31
años. Ingresó en el Reformatorio de Alicante el 1-XII-1939 desde el
campo Oliver y el 24-I-1940 fue enviado a la cárcel de Alcoi. Estuvo
en &quot;La Abastecedora&quot;. Fue procesado por la Justicia
Militar. Quedó en libertad el 25-V-1941 (Fuente: Legajos 9304 y
12598 - AMA).

- Escribir una colección de rutinas que realicen la conversión

## Changelog

### v0.2
 - Los documentos ahora pueden ser doc, docx y odt
 - Los documentos incluyen ahora la descripción de la población al principio seguidos de "Listado de represariados"
 - Se generan dos excel uno con la lista de poblaciones y sus descripciones y otro con la lista de represariados

### v0.1
 - Transformación de los documentos sólo con los registros
 - se genera un único excel con la lista de represariados.


## Procedimiento

1. Convertir documentos word en html: $unoconv -o rawhtml/ -f html rawdoc/*doc
1. Limpiar código html inútil
 - Conservar sólo las etiquetas p, b, i...
 - Eliminar atributos como class, style... y código html inútil
 - http://htmlpurifier.org/ + str_preg_replace
1. Extraer la población y su descripción (guardar en csv "población-[nom_pueblo].csv")
1. Captar registros (nombre y caso: convertir a formato CSV)
 1. dividir por párrafos p
 1. Buscar en contenido el primer "." para extraer el título, el resto
 es la causa
 1. Teniéndolo en un array añadir al principio la población (nombre archivo)
 1. Guardarlo todo en un CSV -> "represaliados-[nom_pueblo].csv"
1. Fusionar todos los CSV para hacer la subida más fácil.
 1. "Pueblos.csv"
 1. "Represariados.csv"

## Prerrequisitos

- Libreoffice
- Unoconv (disponible en apt y homebrew)
- php

## Uso

Dejar todos los doc en el directorio "rawdoc" y ejecutar desde la consola ```word2csv```
