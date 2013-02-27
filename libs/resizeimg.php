<?php

$q = 80;
if(isset($_GET['q']))
{
    $q = $_GET['q'];
}

$src = $_GET['src'];

if(isset($_GET['w']) && isset($_GET['h']))
{
    $tamanos = calcularTamanos($src, $_GET['w'], $_GET['h']);
    $w = $tamanos['w'];
    $h = $tamanos['h'];
    $cociente = $tamanos['cociente'];
    $sobrantew = $tamanos['sobrantew'];
    $sobranteh = $tamanos['sobranteh'];
    $mime = $tamanos['mime'];
    $src = $tamanos['src'];
    $mimeint = $tamanos[2];
}
else if(isset($_GET['w']))
{
    $tamanos = calcularTamanos($src, $_GET['w']);
    $w = $tamanos['w'];
    $h = $tamanos['h'];
    $cociente = $tamanos['cociente'];
    $sobrantew = $tamanos['sobrantew'];
    $sobranteh = $tamanos['sobranteh'];
    $mime = $tamanos['mime'];
    $src = $tamanos['src'];
    $mimeint = $tamanos[2];
}
else if(isset($_GET['h']))
{
    $tamanos = calcularTamanos($src, false, $_GET['h']);
    $w = $tamanos['w'];
    $h = $tamanos['h'];
    $cociente = $tamanos['cociente'];
    $sobrantew = $tamanos['sobrantew'];
    $sobranteh = $tamanos['sobranteh'];
    $mime = $tamanos['mime'];
    $src = $tamanos['src'];
    $mimeint = $tamanos[2];
}
else
{
    die('no se dieron unos tamanos de imagen correctos');
}

//dumpx($tamanos);

$ttgt = imagecreatetruecolor(($w-$sobrantew), ($h-$sobranteh));

switch ($mimeint) 
{
        case IMAGETYPE_GIF:
            $tgt = imagecreatefromgif($src);
            break;
        case IMAGETYPE_JPEG:
            $tgt = imagecreatefromjpeg($src);
            break;
        case IMAGETYPE_PNG:
            $tgt = imagecreatefrompng($src);
            
            imagealphablending($ttgt, false);
            
            $canvas_color = 'ffffff';
            $canvas_color_R = hexdec (substr ($canvas_color, 0, 2));
            $canvas_color_G = hexdec (substr ($canvas_color, 2, 2));
            $canvas_color_B = hexdec (substr ($canvas_color, 2, 2));
            
            $transparent = imagecolorallocatealpha($ttgt, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
            //imagefill($ttgt, 0, 0, $transparent);
            
            imagesavealpha($ttgt, true);
            
            break;
}


header('Content-type: '.$mime);

imagecopyresampled($ttgt, $tgt, -round($sobrantew/2), -round($sobranteh/2), 0, 0, $w, $h, $tamanos[0], $tamanos[1]);



switch ($mimeint) 
{
        case IMAGETYPE_GIF:
            imagegif($ttgt);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($ttgt, NULL, $q);
            break;
        case IMAGETYPE_PNG:
            $q = round(($q/10));
            if($q==10)
            {
                $q = 9;
            }
            imagepng($ttgt, NULL, $q);
            break;
}

imagedestroy($tgt);
imagedestroy($ttgt);
    
function calcularTamanos($src, $w, $h = false)
{
    $src = trim($src, '/');
    $srcinfo = getimagesize(realpath(dirname(__FILE__).'/../../../../'.$src));
    $tamanos = $srcinfo;
    
    $tamanos['src'] = realpath(dirname(__FILE__).'/../../../../'.$src);
    
    $cocientew = 0;
    
    if($w>0)
    {
        $cocientew = obtenerCocienteW($tamanos[0], $w);
    }
    
    $cocienteh = 0;
    
    if($h && ($h>0))
    {
        $cocienteh = obtenerCocienteH($tamanos[1], $h);
    }
    
    $cociente = $cocientew;
    if($cocientew<$cocienteh)
    {
        $cociente = $cocienteh;
    }
    
    $we = $tamanos[0]*$cociente;
    
    $he = $tamanos[1]*$cociente;
    
    $tamanos['w'] = $we;
    $tamanos['h'] = $he;
    
    $ws = $we-$w;
    $ws = abs($ws);
    
    $hs = $he-$h;
    $hs = abs($hs);
    
    $tamanos['cociente'] = $cociente;
    $tamanos['sobrantew'] = $ws;
    $tamanos['sobranteh'] = $hs;
    
    return $tamanos;
}

function dumpx()
{
    $args = func_get_args();
    foreach ($args as $arg)
    {
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
        echo '<br />';
        echo '<br />';
    }
    die();
}

function obtenerCocienteW($wsrc, $wtgt)
{
    return $wtgt/$wsrc;
}

function obtenerCocienteH($hsrc, $htgt)
{
    return $htgt/$hsrc;
}