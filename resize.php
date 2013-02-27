<?php

	$dirpath = realpath(dirname(__FILE__));
	
	$w = $_GET['w'];
	$h = $_GET['h'];
	$src = $dirpath.'/../../../'.$_GET['src'];
        
        $src = explode('?', $src);
        
        $src = $src[0];
        
	$tgt = date('Ymd').'_'.$src;
	if(file_exists($dirpath.'/libs/cache/'.$tgt))
	{
		return '/cache/'.$tgt;
	}
	else if(is_writable($dirpath.'/libs/cache/'))
	{
		
			$datos = getimagesize($src);
			

			

			if($datos[1]<$datos[0])
			{
				$ratio= $w/$datos[0];
			}
			else
			{
				$ratio = $h/$datos[1];
			}
			
			if($datos[2]==1)
			{
				$img = imagecreatefromgif($src);
			}			 
			if($datos[2]==2)
			{
				$img = @imagecreatefromjpeg($src);
			} 
			if($datos[2]==3)
			{
				$img = @imagecreatefrompng($src);
			}
                        
			$altura = $datos[1] * $ratio; 
                        $anchura = $datos[0] * $ratio;
                        
			/*if($altura>$hmax)
			{
				$anchura2=$hmax*$anchura/$altura;
                                $altura=$hmax;
                                $anchura=$anchura2;
			}
                         */
                        
			$thumb = imagecreatetruecolor($w, $h); 
			imagecopyresampled($thumb, $img, 0, 0, ($anchura-$w)/2, ($altura-$h)/2, $anchura, $altura, $datos[0], $datos[1]); 
			if($datos[2]==1)
			{
				header("Content-type: image/gif"); 
				imagegif($thumb);
			} 
			if($datos[2]==2)
			{
				header("Content-type: image/jpeg");
				imagejpeg($thumb);
			} 
			if($datos[2]==3)
			{
				header("Content-type: image/png");
				imagepng($thumb); 
			} 
			imagedestroy($thumb); 
			return 'a';
	}
	else
	{
		return 'Cache dir is not writable';
	}