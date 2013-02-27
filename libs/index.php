<?php

require_once 'ImagenFachada.php';
/**
 * Llamada al método estático de la clase ImagenFachada (crearMarcaAgua()).
 * Retornará una imágen con marca de agua (un objeto del tipo ImgMarcaAgua),
 * de acuerdo a los parámetros enviados.
 *
 * Parámetros enviados (arreglo de parámetros):
 * 
 * imgOriginal  => Ruta/Nombre de la imágen que será marcada.
 * imgMarcaAgua => Ruta/Nombre de la imágen que hará de marca de agua.
 * imgNueva     => Ruta/Nombre de la imágen resultante.
 *
 * posicion     => Posición de la marca de agua sobre la imágen original (1-7). Parámetro opcional.
 *  Valor por defecto = 1
 *  1 = Marca de agua centrada sobre la imágen original.
 *  2 = Marca de agua sobre la esquina superior izquierda en la imágen original.
 *  3 = Marca de agua sobre la esquina superior derecha en la imágen original.
 *  4 = Marca de agua en el centro superior sobre la imágen original.
 *  5 = Marca de agua sobre la esquina inferior izquierda en la imágen original.
 *  6 = Marca de agua sobre la esquina inferior derecha en la imágen original.
 *  7 = Marca de agua en el centro inferior sobre la imágen original.
 *
 * calidad => Calidad de la imágen resultante (1 -100). Parámetro opcional.
 * 
 */
$img = ImagenFachada::crearMarcaAgua(array(
    'imgOriginal'  => 'imagenes/marcaAgua/star-trek-xi.jpg',
    'imgMarcaAgua' => 'imagenes/marcaAgua/marca.png',
    'imgNueva'     => 'imagenes/marcaAgua/nuevo.jpg',
    'posicion'     => 7,
    'calidad'      => 100
));
// Imprimo la imágen resultante, gracias al método __toString() de la clase ImgMarcaAgua.
echo "<img src='{$img}'>";

echo '<br><br>';
/**
 * Llamada al método estático de la clase ImagenFachada (redimensionar()).
 * Retornará una imágen con marca de agua (un objeto del tipo ImgResize),
 * de acuerdo a los parámetros enviados.
 *
 * Parámetros enviados (arreglo de parámetros):
 *
 * imgOriginal => Ruta/Nombre de la imágen que será redimensionada.
 * imgNueva    => Ruta/Nombre de la imágen resultante.
 * ancho       => Ancho deseado para la imágen redimensionada.
 * alto        => Altura deseado para la imágen redimensionada.
 *
 * tipoResize  => Tipo de redimensión (1-2). Parámetro Opcional.
 *  Valor por defecto = 1
 *  1 = Redimensiona la imágen manteniendo la relación de aspecto, es decir teniendo en cuenta
 *      el ancho y el alto originales.
 *  2 = Redimensiona la imágen sin mantener la relación de aspecto, es decir se respeta
 *      el ancho y el alto enviados como parámetros.
 *      Por ej: envío 150 x 100, es eso lo que obtendré.
 *
 * calidad => Calidad de la imágen redimensionada resultante (1 -100). Parámetro opcional.
 *
 */
$img = ImagenFachada::redimensionar(array(
    'imgOriginal' => 'imagenes/resize/battlestar_galactica.jpg',
    'imgNueva'    => 'imagenes/resize/resize.jpg',
    'ancho'       => 150,
    'alto'        => 150,
    'tipoResize'  => 1,
    'calidad'     => 100
));
// Imprimo la imágen resultante, gracias al método __toString() de la clase ImgResize.
echo "<img src='{$img}'>";