<?php
/**
 * Archivo: Imagen.php
 *
 * Contiene los atributos y métodos básicos de una imágen.
 * Esta clase es instanciada por otras clases para su uso.
 *
 * @link      http://www.micodigobeta.com.ar
 * @author    http://www.micodigobeta.com.ar
 * @access    public
 */
class Imagen
{
    /**
     * Ruta/nombre de la imágen
     * @var <String> $_imagen
     * @access private
     */
	private $_imagen;
    /**
     * Ancho de la imágen (width)
     * @var <int> $_ancho
     * @access private
     */
	private $_ancho;
    /**
     * Alto de la imágen (height)
     * @var <int> $_alto
     * @access private
     */
	private $_alto;
    /**
     * Tipo de la imágen (png, jpg, gif, etc.)
     * @var <String> $_tipo
     * @access private
     */
	private $_tipo;
    /**
     * Constructor de la clase
     * @param <String> $img
     * @access public
     */
	public function __construct($img)
	{
		$this->_imagen = $img;
	}
    /**
     * Método que establece las propiedades de la imágen
     * Ancho, Alto y Tipo
     * @access public
     */
	public function setPropiedades()
	{
		$propImg      = getimagesize($this->_imagen);
		$this->_ancho = $propImg[0];
		$this->_alto  = $propImg[1];
		// Asigno el tipo de im�gen. Obtengo la extensi�n.
		$this->_tipo  = strstr($this->_imagen, '.');
	}
    /**
     * Obtengo el Ancho de la imágen
     * @return <int> $this->_ancho
     * @access public
     */
	public function getAncho()
	{
		return $this->_ancho;
	}
    /**
     * Obtengo el Alto de la imágen
     * @return <int> $this->_alto
     * @access public
     */
	public function getAlto()
	{
		return $this->_alto;
	}
    /**
     * Obtengo el tipo de la imágen
     * @return <int> $this->_tipo
     * @access public
     */
	public function getTipo()
	{
		return $this->_tipo;
	}
    /**
     * Se crea una imágen a partir del tipo del objeto actual
     * @return <resource> $imgCreada
     * @access public
     */
	public function creaImg()
	{
		$tipo = $this->getTipo();

		switch ($tipo) {
		
			case '.jpg':
				$imgCreada = ImageCreateFromJPEG($this);
				break;
				
			case '.png':
				$imgCreada = ImageCreateFromPNG($this);
				break;
				
			case '.gif':
				$imgCreada = ImageCreateFromGIF($this);
				break;
				
			case '.bmp':
				$imgCreada = imageCreateFromWBMP($this);
				break;
		
		}

		return $imgCreada;
		
	}
	
	public function __toString()
	{
		return $this->_imagen;
	}
}