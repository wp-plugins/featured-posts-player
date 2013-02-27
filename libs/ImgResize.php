<?php

require_once 'Imagen.php';
/**
 * Archivo: ImgResize.php
 *
 * Clase para generar una imágen redimensionada.
 * Puedo redimensionar respetando la relación de aspecto, para eso se tiene en cuenta
 * tanto el alto como el ancho de la imágen a redimensionar.
 * También puedo redimensionar de manera estricta, es decir respetando al 100% los
 * parámetros enviados de altura y anchura.
 *
 * @link      http://www.micodigobeta.com.ar
 * @author    http://www.micodigobeta.com.ar
 * @access    public
 */
class ImgResize
{
    /**
     * Ruta/nombre de la imágen
     * @var <String> $_imagen
     * @access private
     */
	private $_imagen;
    /**
     * Ruta/nombre de la imágen
     * @var <String> $_nuevaImg
     * @access private
     */
	private $_nuevaImg;
    /**
     * Constante que define la forma en que se redimensionará.
     * Se tiene en cuenta los parámetros de altura y anchura enviados y el alto
     * y el ancho original de la imágen a redimensionar.
     * Se mantiene la relación de aspecto.
     * @var <const> WITH_ASPECT_RATIO
     */
        const WITH_ASPECT_RATIO    = 1;
    /**
     * Constante que define la forma en que se redimensionará.
     * Se tiene en cuenta los parámetros de altura y anchura enviados.
     * Si envio 150x100 se respeta al 100%
     * @var <const> WITHOUT_APSECT_RATIO
     */
        const WITHOUT_APSECT_RATIO = 2;
    /**
     * Constructor de la clase
     * @param <String> $imagen Ruta/nombre de la imágen a redimensionar
     * @param <String> $imgNueva Ruta/nombre de la imágen resultante
     * @access public
     */
	public function __construct($imagen)
	{
                // Creo una instancia de la clase Imagen.
		$this->_imagen   = new Imagen($imagen);
		
//		$this->_nuevaImg = $imgNueva;
		$this->_nuevaImg = realpath(dirname(__FILE__)).'/cache/'.date('Ymd').'_'.basename($imagen);
	}
    /**
     * Método que redimensiona la imágen.
     * @param <int> $ancho Anchura deseada
     * @param <int> $alto Altura deseada
     * @param <int> $tipoResize determina el tipo de redimensión.
     * (1 = WITH_ASPECT_RATIO = mantiene la relación de aspecto)
     * (2 = WITHOUT_ASPECT_RATIO = no mantiene la relación de aspecto)
     * @param <int> calidad determina la calidad de la imágen resultante (1-100)
     * @access public
     */
	public function resize($ancho, $alto, $tipoResize, $calidad)
	{
                // Establezco las propiedades de la imágen.
                // Alto, Ancho y tipo.
                // Llamada al método de la clase Imagen
		$this->_imagen->setPropiedades();
                // Creo una imágen a partir de la imágen original.
                // Obtengo Ancho y Alto.
                // Llamadas a métodos de la clase Imágen.
		$imagen    = $this->_imagen->creaImg();
		$anchoOrig = $this->_imagen->getAncho();
		$altoOrig  = $this->_imagen->getAlto();
                // Inicio la redimensión de acuerdo al tipo.
				
                switch ($tipoResize) {
                    // Con relación de aspecto. $tipoResize = 1
                    case self::WITH_ASPECT_RATIO:
                        // calculo el ancho y el alto, de acuerdo a los parámetros enviados.
                        $arrMedida = self::_calcularAnchoyAlto($ancho, $alto);
                        $imgResize = imagecreatetruecolor(
                            $arrMedida['ancho'],
                            $arrMedida['alto']
                        );
				
                        imagecopyresized($imgResize,
                                         $imagen,
					 0, 0, 0, 0,
					 $arrMedida['ancho'],
					 $arrMedida['alto'],
					 $anchoOrig,
					 $altoOrig
                        );

                        break;

                    case self::WITHOUT_APSECT_RATIO:
                        // Sin relación de aspecto. $tipoResize = 2
                        $imgResize = imagecreatetruecolor($ancho, $alto);
                        imagecopyresized($imgResize,
                                         $imagen,
                                         0, 0, 0, 0,
                                         $ancho,
                                         $alto,
                                         $anchoOrig,
                                         $altoOrig
                        );

                        break;

                 }
                // Genero la nueva imágen, ya redimensionada.
		imagejpeg($imgResize, $this->_nuevaImg, $calidad);
		ImageDestroy($imgResize);
	}
    /**
     * Método que calcula el ancho y el alto, manteniendo la relación de aspecto.
     * @param <int> $ancho Anchura deseada
     * @param <int> $alto Altura deseada
     * @return <array> $arrMedida Arreglo con las medidas obtenidas.
     * @access private
     */
	private function _calcularAnchoyAlto($ancho, $alto)
	{
                // Si el anchoes mayor o igual al alto, entonces me guío por el ancho
                // original de la imágen para redimensionar.
                // Obtengo un porcentaje que me servirá para calcular la altura final.
                // Si el alto es mayor, entonces me guio por la altura original de la imágen
                // para redimensionar. Obtengo un porcentaje que me servirá para calcular
                // el ancho final.
		if ($ancho >= $alto) {
			$porcentaje = round(($ancho * 100) / $this->_imagen->getAncho());
			$altura     = round(($this->_imagen->getAlto() * $porcentaje) / 100);
			$arrMedida  = array('ancho' => $ancho, 'alto' => $altura);
		} else {
			$porcentaje = round(($alto * 100) / $this->_imagen->getAlto());
			$anchura    = round(($this->_imagen->getAncho() * $porcentaje) / 100);
			$arrMedida  = array('ancho' => $anchura, 'alto' => $alto);
		}
		// Retorno las medidas obtenidas.
		return $arrMedida;
	}
	
	public function __toString()
	{
		return $this->_nuevaImg;
	}
}