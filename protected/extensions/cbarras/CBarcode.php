<?php 
include(dirname(__FILE__).'/ean.php');
class CBarcode extends CWidget
{
   public $number;
   public $encoding;
   public $scale;
   public $htmlOptions;

   protected $_encoder;

   function init()
   {
      //$this->number = $number;
      $this->scale = isset($this->scale) ? $this->scale:4;

      // Reflection Class : Method

      $this->_encoder = new EAN13($this->number, $this->scale);
   }

   function run()
   {
		   $image_data=$this->_encoder->display();
		   echo '<img src="data:image/png;base64,'.base64_encode ($image_data).'" '.$this->htmlOptions.'/>'; 
   }

}

?>
