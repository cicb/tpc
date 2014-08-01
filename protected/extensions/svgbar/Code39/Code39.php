<?php

class Code39
{
	var $CODE39 = array(
        '0'=>'111221211',
        '1'=>'211211112',
        '2'=>'112211112',
        '3'=>'212211111',
        '4'=>'111221112',
        '5'=>'211221111',
        '6'=>'112221111',
        '7'=>'111211212',
        '8'=>'211211211',
        '9'=>'112211211',
        'A'=>'211112112',
        'B'=>'112112112',
        'C'=>'212112111',
        'D'=>'111122112',
        'E'=>'211122111',
        'F'=>'112122111',
        'G'=>'111112212',
        'H'=>'211112211',
        'I'=>'112112211',
        'J'=>'111122211',
        'K'=>'211111122',
        'L'=>'112111122',
        'M'=>'212111121',
        'N'=>'111121122',
        'O'=>'211121121',
        'P'=>'112121121',
        'Q'=>'111111222',
        'R'=>'211111221',
        'S'=>'112111221',
        'T'=>'111121221',
        'U'=>'221111112',
        'V'=>'122111112',
        'W'=>'222111111',
        'X'=>'121121112',
        'Y'=>'221121111',
        'Z'=>'122121111',
        '-'=>'121111212',
        '.'=>'221111211',
        ' '=>'122111211',
        '$'=>'121212111',
        '/'=>'121211121',
        '+'=>'121112121',
        '%'=>'111212121',
        '*'=>'121121211');
    var $unit;//Unit
    var $bw;//bar width
    var $height;// px
    var $fs;//Font size
    var $yt;
    var $dx;
    var $x;
    var $y;
    var $bl;

    public function Code39($codigo='0',$width=3, $height=50,$x=4,$y=2.5,$fontsize=8)
    {
        # code...
        $this->codigo=$codigo;
        $this->unit='px';//Unit
        $this->bw=$width;//bar width
        $this->height=$height*$width;// px
        $this->fs=$fontsize*$width;//Font size
        $this->yt=45*$width;
        $this->dx=3*$width;
        $this->x=$x*$width;
        $this->y=$y*$width;
        $this->bl=35*$width;
    }


    

    public function checksum( $string )
    {
        $checksum = 0;
        $length   = strlen( $string );
        $charset  = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%';
 
        for( $i=0; $i < $length; ++$i )
        {
            $checksum += strpos( $charset, $string[$i] );
        }
 
        return substr( $charset, ($checksum % 43), 1 );
    }

    public function draw($checksum=false){
        $unit=$this->unit;
        $x=$this->x;
        $height=$this->height;
        $bw=$this->bw;
        $str=$this->codigo;
        $str=strtoupper($str);
        if ($checksum) {
            $str=$str.checksum($str);
        }
        $str='*'.$str.'*';
        echo $str;
        $long=(strlen($str)+3)*12;
        $width=$bw*$long;
        $text=str_split($str);
        $img='';
        $img.= "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">\n";
        $img.= "<svg width='$width$unit' height='$height$unit' version='1.1' xmlns='http://www.w3.org/2000/svg'>\n";
        
        foreach($text as $char){
            $img.=$this->drawsymbol($char);
        }
        $img.='</svg>';
        return $img;
    }
    public function drawsymbol($char){
        $this->x+=$this->bw;
        $img='';
        $img.= '<desc>'.htmlspecialchars($char)."</desc>\n";
        $this->xt=$this->x+$this->dx;
        $img.= sprintf("<text x='%d%s' y='%d%s' font-family='Arial' font-size='%s'>%s</text>\n",
            $this->xt,$this->unit,$this->yt,$this->unit,$this->fs,$char );
        $val =str_split($this->CODE39[$char]);
        $len=9;
        for ($i=0; $i<$len; $i++){
            $num=(int)$val[$i];
            $this->w=$this->bw*$num;
            if(!($i % 2)){
                $img.=sprintf("<rect x='%d%s' y='%d%s' width='%d%s' height='%d%s' fill='black' stroke-width='0' />\n"
                    ,$this->x,$this->unit,$this->y,$this->unit,$this->w,$this->unit,$this->bl,$this->unit); 
            }
            $this->x += $this->w;
        }
        return $img;
    }
   }

?>
