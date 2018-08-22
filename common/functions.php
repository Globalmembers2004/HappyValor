<?php
function loadOpcionSel($tabla, $condicion, $valor, $texto, $default = "", $adicional = "", $orden = ""){
	$db = new Db();
	$strR = "";
	if ($adicional != "")
		$campo = array($valor, $texto, $adicional);
	else
		$campo = array($valor, $texto);
	$fila_rs = $db->set_select($campo, $tabla, $condicion, $orden);
	$countrows = count($fila_rs);
	$i = 0;
	$relx = "";
	$selectedx = "";
	while($i < $countrows){
		if ($adicional != "")
			$relx = " rel=\"" . $fila_rs[$i][$adicional] . "\"";
		else
			$relx = "";
		if ($default != ""){
			if ($fila_rs[$i][$valor] == $default)
				$selectedx = " selected=\"selected\"";
			else
				$selectedx = "";
		}
		$strR .= "<option value=\"".$fila_rs[$i][$valor]."\"".$relx."".$selectedx.">".$fila_rs[$i][$texto]."</option>";
		++$i;
	}
	return $strR;
}

function in_array_column($value, $columnId, $columnText, $array)
{
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if ($array[$i][$columnText]==$value || strcmp($array[$i][$columnText],$value)==0) return $array[$i][$columnId];
        }
    }
    return false;
}

function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

function output_file($file, $name, $mime_type='')
{
 if(!is_readable($file)) die('File not found or inaccessible!');
 $size = filesize($file);
 $name = rawurldecode($name);
 $known_mime_types=array(
    "htm" => "text/html",
    "exe" => "application/octet-stream",
    "zip" => "application/zip",
    "doc" => "application/msword",
    "jpg" => "image/jpg",
    "php" => "text/plain",
    "xls" => "application/vnd.ms-excel",
    "ppt" => "application/vnd.ms-powerpoint",
    'xlsx' => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "gif" => "image/gif",
    "pdf" => "application/pdf",
    "txt" => "text/plain",
    "html"=> "text/html",
    "png" => "image/png",
    "jpeg"=> "image/jpg"
 );
 
 if($mime_type==''){
     $file_extension = strtolower(substr(strrchr($file,"."),1));
     if(array_key_exists($file_extension, $known_mime_types)){
        $mime_type=$known_mime_types[$file_extension];
     } else {
        $mime_type="application/force-download";
     };
 };
 
 //turn off output buffering to decrease cpu usage
 @ob_end_clean(); 
 
 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
 ini_set('zlib.output_compression', 'Off');
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 
 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
    list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
    list($range) = explode(",",$range,2);
    list($range, $range_end) = explode("-", $range);
    $range=intval($range);
    if(!$range_end) {
        $range_end=$size-1;
    } else {
        $range_end=intval($range_end);
    }

    $new_length = $range_end-$range+1;
    header("HTTP/1.1 206 Partial Content");
    header("Content-Length: $new_length");
    header("Content-Range: bytes $range-$range_end/$size");
 } else {
    $new_length=$size;
    header("Content-Length: ".$size);
 }
 
 /* Will output the file itself */
 $chunksize = 1*(1024*1024); //you may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
    if(isset($_SERVER['HTTP_RANGE']))
    fseek($file, $range);
 
    while(!feof($file) && 
        (!connection_aborted()) && 
        ($bytes_send<$new_length)
          )
    {
        $buffer = fread($file, $chunksize);
        echo($buffer); 
        flush();
        $bytes_send += strlen($buffer);
    }
 fclose($file);
 } else
 //If no permissiion
 die('Error - can not open file.');
 //die
die();
}

function fecha_mysql($fecha){
    $mifecha = explode('/', $fecha);
    $fecha_lista=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
    return $fecha_lista;
}

function fecha_normal($fecha){
    $fecha_lista = date('d/m/Y', strtotime($fecha));
    return $fecha_lista;
}

function treeMenu($data, $mom = 0, $level = 0){
     foreach ($data as $row){
        if ($row['tm_idmenuref'] == $mom) {
            echo '<tr><td style="width:60px;"><input name="chkEstado[]" type="checkbox" checked="" value="1" /></td><td>'.str_repeat("&nbsp;&nbsp;", $level).$row['tm_titulo'].'</td><td><input name="chkSoloLectura[]" type="checkbox" checked="" value="1" /></td><td><input name="chkSoloLectura[]" type="checkbox" checked="" value="1" /></td><td><input name="chkControlTotal[]" type="checkbox" checked="" value="1" /></td></tr>';
            treeMenu($data, $row['tm_idmenu'], $level+1);
        }
     }
}

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
        
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    
    return $_SERVER['REMOTE_ADDR'];
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    // $randomString = substr(base64_encode(sha1(mt_rand())), 0, $length);
    return $randomString;
}

function make_thumb($src, $dest, $desired_width) {
    /* read the source image */
    //$source_image = imagecreatefromjpeg($src);
    if((preg_match('/[.](jpg)$/', $src)) || (preg_match('/[.](jpeg)$/', $src))) {
        $source_image = imagecreatefromjpeg($src);
    } else if (preg_match('/[.](gif)$/', $src)) {
        $source_image = imagecreatefromgif($src);
    } else if (preg_match('/[.](png)$/', $src)) {
        $source_image = imagecreatefrompng($src);
    }

    $width = imagesx($source_image);
    $height = imagesy($source_image);

    $desired_height = floor($height * ($desired_width / $width));

    if((preg_match('/[.](jpg)$/', $src)) || (preg_match('/[.](jpeg)$/', $src))) {
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        imagejpeg($virtual_image, $dest);
    }
    else if ((preg_match('/[.](png)$/', $src)) || (preg_match('/[.](gif)$/', $src))) {
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagealphablending($virtual_image, false);
        imagesavealpha($virtual_image, true);  
        if (preg_match('/[.](png)$/', $src)) {
            $source = imagecreatefrompng($src);
        }
        else {
            $source = imagecreatefromgif($src);
        }
        imagealphablending($source, true);
        imagecopyresampled($virtual_image, $source, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        if (preg_match('/[.](png)$/', $src)) {
            imagepng($virtual_image, $dest);
        }
        else {
            imagegif($virtual_image, $dest);
        }
    }
}

function getMes($mes)
{
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    return $meses[$mes-1];
}

function ListarMeses($default='')
{
    $strhtml = '';
    $selected = '';
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

    $countmeses = count($meses);

    $i = 0;

    while ($i < $countmeses) {
        if ($default != ''){
            if (($i + 1) == $default)
                $selected = ' selected=""';
            else
                $selected = '';
        }
        $strhtml .= '<option'.$selected.' value="'.($i + 1).'">'.$meses[$i].'</option>';
        ++$i;
    }

    echo $strhtml;
}

function zerofill($mStretch, $iLength = 2)
{
    $sPrintfString = '%0' . (int)$iLength . 's';
    return sprintf($sPrintfString, $mStretch);
}
?>