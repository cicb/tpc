<?php 
//Unit Test de los Servicios WEB
	class ServiciosTest extends CDbTestCase{
		public $fixtures=array(
			// 'posts'=>'Post',
			// 'comments'=>'Comment',
			);

		function testPuedoValidar() {
			$servicios = new ServiciosController();
			$this->assertEquals('word',$servicios->validar());
		}


	}
 ?>