<?php

require_once 'Imagen.php';
/**
 * Archivo: ImgMarcaAgua.php
 *
 * Clase para generar una imágen con marca de agua.
 * Puedo posicionar la marca de agua en 7 lugares diferentes dentro de la
 * imágen original. Incluso puedo determinar la calidad de la imágen resultante.
 *
 * @link      http://www.micodigobeta.com.ar
 * @author    http://www.micodigobeta.com.ar
 * @access    public
 */
class ImgMarcaAgua
{
    /**
     * Ruta/nombre de la imágen original
     * @var <String> $_imagenOriginal
     * @access private
     */
	private $_imagenOriginal;
    /**
     * Ruta/nombre de la imágen que hará de  "marca de agua"
     * @var <String> $_imgMarcaDeAgua
     * @access private
     */
	private $_imgMarcaDeAgua;
    /**
     * Ruta/nombre de la imágen resultante
     * @var <String> $_nuevaImg
     * @access private
     */
	private $_nuevaImg;
    /**
     * Posición en el eje Y que ocupará la imágen de marca
     * @var <int> $_posicionY
     * @access private
     */
	private $_posicionY;
    /**
     * Posición en el eje X que ocupará la imágen de marca
     * @var <int> $_posicionX
     * @access private
     */
	private $_posicionX;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Totalmente centrada sobre la imágen original.
     * @var <const> CENTER
     */
    const CENTER     = 1;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Esquina Superior Izquierda sobre la imágen original.
     * @var <const> SUP_IZQ
     */
    const SUP_IZQ    = 2;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Esquina Superior Derecha sobre la imágen original.
     * @var <const> SUP_DER
     */
    const SUP_DER    = 3;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Centrado Superior sobre la imágen original.
     * @var <const> SUP_CENTER
     */
    const SUP_CENTER = 4;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Esquina Inferior Izquierda sobre la imágen original.
     * @var <const> INF_IZQ
     */
    const INF_IZQ    = 5;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Esquina Inferior Derecha sobre la imágen original.
     * @var <const> INF_DER
     */
    const INF_DER    = 6;
    /**
     * Constante que define la ubicación de la marca de agua.
     * Centrado Inferior sobre la imágen original.
     * @var <const> INF_CENTER
     */
    const INF_CENTER = 7;
    /**
     * Constructor de la clase
     * @param <String> $imgPrincipal Imágen original que será marcada
     * @param <String> $imgMarcaAgua Imágen que hará de marca de agua
     * @param <String> $imgNueva Imágen resultante
     * @access public
     */
	public function __construct($imgPrincipal, $imgMarcaAgua, $imgNueva)
	{
		// Creo 2 instancias de la clase Imagen.
		$this->_imagenOriginal = new Imagen($imgPrincipal);
		$this->_imgMarcaDeAgua = new Imagen($imgMarcaAgua);
		$this->_nuevaImg       = $imgNueva;
	}
    /**
     * Método creador de la imágen con marca de agua
     * @param <int> $posicion Posición de la marca sobre la imágen original ( valores: 1 - 7)
     * @param <int> $calidad calidad de la imágen resultante (valores: 1 - 100)
     * @access public
     */
	public function crearMarcaAgua($posicion, $calidad)
	{
		// Establezco las propiedades a la imágen 1 y a la marca de agua.
                // Llamo a los métodos de la clase Imágen.
                // Ancho, Alto y Tipo.
		$this->_imagenOriginal->setPropiedades();
		$this->_imgMarcaDeAgua->setPropiedades();
		// Establezco la posición que tendró la marca de agua.
		self::_setPosicionMarcaAgua($posicion);
		// Creo 2 imagenes.
		// La primera desde la original, la segunda desde la marca de agua.
		// Enviocomo parámetros la imágen y el tipo (jpg, png, etc.).
                // Llamo a los métodos de la clase imágen.
		$imgCreadaOriginal = $this->_imagenOriginal->creaImg();
		$imgCreadaMarca    = $this->_imgMarcaDeAgua->creaImg();
		// Pego la marca de agua en la imágen original.
		ImageCopy($imgCreadaOriginal,
				  $imgCreadaMarca,
				  $this->_posicionY,
				  $this->_posicionX,
				  0, 0,
				  $this->_imgMarcaDeAgua->getAncho(),
				  $this->_imgMarcaDeAgua->getAlto()
		); 
		// Guardo la imágen en formato jpg
		ImageJPEG($imgCreadaOriginal, $this->_nuevaImg, $calidad); 
		// Destruir las imágenes
		ImageDestroy($imgCreadaOriginal); 
		ImageDestroy($imgCreadaMarca); 
	}
    /**
     * Método que calcula la posición de la marca de agua sobre la imágen original.
     * @param <int> $posicion Posición de la marca sobre la imágen original ( valores: 1 - 7)
     * @access private
     */
	private function _setPosicionMarcaAgua($posicion)
	{
        // Obtengo el Alto y Ancho de las imágenes para calcular la posición
        // de acuerdo al parámetro recibido.
        $anchoOriginal  = $this->_imagenOriginal->getAncho();
		$altoOriginal   = $this->_imagenOriginal->getAlto();
		$anchoMarcaAgua = $this->_imgMarcaDeAgua->getAncho();
		$altoMarcaAgua  = $this->_imgMarcaDeAgua->getAlto();
		
		switch ($posicion) {
		
			case self::CENTER:
				$this->_posicionY = round(($anchoOriginal - $anchoMarcaAgua) / 2);
				$this->_posicionX = round(($altoOriginal - $altoMarcaAgua) / 2);
				break;
				
			case self::SUP_IZQ:
				$this->_posicionY = 0;
				$this->_posicionX = 0;
				break;
				
			case self::SUP_DER:
				$this->_posicionY = $anchoOriginal - $anchoMarcaAgua;
				$this->_posicionX = 0;
				break;
				
			case self::SUP_CENTER:
				$this->_posicionY = round(($anchoOriginal - $anchoMarcaAgua) / 2);
				$this->_posicionX = 0;
				break;
				
			case self::INF_IZQ:
				$this->_posicionY = 0;
				$this->_posicionX = $altoOriginal - $altoMarcaAgua;
				break;
				
			case self::INF_DER:
				$this->_posicionY = $anchoOriginal - $anchoMarcaAgua;
				$this->_posicionX = $altoOriginal - $altoMarcaAgua;
				break;
				
			case self::INF_CENTER:
				$this->_posicionY = round(($anchoOriginal - $anchoMarcaAgua) / 2);
				$this->_posicionX = $altoOriginal - $altoMarcaAgua;
				break;
			
		}
	}
	
	public function __toString()
	{
		return $this->_nuevaImg;
	}
	
}