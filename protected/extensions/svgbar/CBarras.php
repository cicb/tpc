<?php
//Widget para la renderizacion de codigos de barras


class CBarras extends CWidget{

	public 	$text = "0";
	public	$size = "20";
	public	$orientation = "horizontal";
	public	$tipo = "Code39";
	public	$codigo = "";
	public	$htmlOptions = array();

public function init()
{
		if (!isset($this->codigo)) $this->codigo= "0";
		if (!isset($this->size))	$this->size = "20";
		if (!isset($this->orientation))	$this->orientation = "horizontal";
		if (!isset($this->tipo))	$this->tipo = "Code39";
		if (!isset($this->htmlOptions))	$this->htmlOptions= array();
		else{
				$html="";
					foreach ($this->htmlOptions as $key=>$val) {
						$html.=	" $key='$val' ";
					}
				$this->htmlOptions=$html;
		}

}

public function run()
{
    ini_set('display_errors',1);
    error_reporting(E_ALL|E_STRICT);
    include sprintf("%s/%s.php",$this->tipo,$this->tipo);
    $cb=new Code39($this->codigo);
    //header("Content-type: image/svg+xml");
    echo $cb->draw();
}

}

?>
