<?php

require_once 'ImgMarcaAgua.php';
require_once 'ImgResize.php';
/**
 * Archivo: ImagenFachada.php
 *
 * Archivo que sirve de "puente" entre el cliente y las clases de imágen
 * Patrón de diseño "Facade" (Fachada)
 *
 * @link      http://www.micodigobeta.com.ar
 * @author    http://www.micodigobeta.com.ar
 * @access    public
 * @abstract
 */
abstract class ImagenFachada
{
    /**
     * Método para crear una imágen con "Marca de Agua"
     * Trabaja con la clase ImgMarcaAgua creando una instancia
     *
     * @param <Array> $arrParametros arreglo con los parámetros de las imágenes
     * 
     * 1 - imágen original (String)
     * 2 - imágen que servirá de marca de agua (String)
     * 3 - nombre de la nueva imágen (String)
     * 4 - posición de la marca de agua en la imágen original (int): parámetro opcional.
     * Por defecto el valor es 1, o sea, la marca de agua queda centrada.
     * 5 - calidad de la imágen resultante (int): parámetro opcional,
     * por defecto el valor es 100
     *
     * @return <ImgMarcaAgua> $imagenMarcaAgua
     * @access public
     * @static
     */
        public static function crearMarcaAgua($arrParametros)
        {
            $imagenMarcaAgua = new ImgMarcaAgua(
                $arrParametros['imgOriginal'],
                $arrParametros['imgMarcaAgua'],
                $arrParametros['imgNueva']
            );
            // En caso de no enviar estos parámetros, les asgno valores por defecto
            if ($arrParametros['posicion'] == null) {
                $arrParametros['posicion'] = 1;
                $arrParametros['calidad']  = 100;
            }

            $imagenMarcaAgua->crearMarcaAgua(
                $arrParametros['posicion'],
                $arrParametros['calidad']
            );

            return $imagenMarcaAgua;
        }
    /**
     * Método para redimensionar una imágen
     * Trabaja con la clase ImgResize creando una instancia
     *
     * @param <Array> $arrParametros arreglo con los parámetros para redimensionar
     *
     * 1 - imágen original (String), la que será redimensionada
     * 2 - nombre de la nueva imágen (String), la resultante
     * 3 - ancho de la imágen (int)
     * 4 - altura de la imágen (int)
     * 5 - El tipo de resize (int). Parámetro opcional. Por defecto el valor es 1
     * Valor 1 = Mantiene la relación de aspecto.
     * Se tiene en cuenta tanto el ancho como el alto enviado.
     * Valor 2 = No tiene en cuenta la relación de aspecto.
     * Se redimensiona respetando los valores enviado. Por ej: ancho = 150, alto = 100
     * Se obtiene una imágen de 150x100
     * 6 - calidad de la imágen resultante (int): parámetro opcional,
     * por defecto el valor es 100
     *
     * @return <ImgResize> $imageResize
     * @access public
     * @static
     */
	public static function redimensionar($arrParametros)
	{
            $imageResize = new ImgResize(
                $arrParametros['imgOriginal']
            );
            // En caso de no enviar estos parámetros, les asgno valores por defecto
            if ($arrParametros['tipoResize'] == null) {
                $arrParametros['tipoResize'] = 1;
                $arrParametros['calidad'] = 100;
            }

            $imageResize->resize(
                $arrParametros['ancho'],
                $arrParametros['alto'],
                $arrParametros['tipoResize'],
                $arrParametros['calidad']
            );

            return $imageResize;
	}
}