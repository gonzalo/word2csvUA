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

## Procedimiento

1. Convertir documentos word en html: $unoconv -o rawhtml/ -f html rawdoc/*doc
2. Limpiar código html inútil
 - Conservar sólo las etiquetas p, b, i...
 - Eliminar atributos como class, style... y código html inútil
 - http://htmlpurifier.org/ + str_preg_replace
3. Captar bloques (nombre y caso: convertir a formato CSV)
 1. dividir por párrafos p
 1. Buscar en contenido el primer "." para extrer el título, el resto
 es la causa
 1. Teniéndolo en un array añadir al principio la población (nombre archivo)
 1. Guardarlo todo en un CSV
4. Fusionar todos los CSV para hacer la subida más fácil.

## Prerrequisitos

- Libreoffice
- Unoconv (disponible en apt y homebrew)
- php

## Uso

Dejar todos los doc en el directorio "rawdoc" y ejecutar desde la consola ```word2csv```
