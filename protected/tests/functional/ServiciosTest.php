<?php

class ServiciosTest extends WebTestCase
{

	private $servicio;

	public function setUp()
	{
		$this->servicio=new Servicios();
		parent::setUp();
	}

	// public function testIndex()
	// {
	// 	$this->assertEquals('word',$this->servicio->validarEntrada());

	// 	// $this->assertClassHasAttribute('validarEntrada');
	// 	// $this->assertTrue($s->validar());
	// }
	public function tearDown() {
		$this->servicio = null;
	}

	public function testValidarRerenciaSinLetras()
	{
		$ref='1234567890123456';
		$this->assertEquals($ref,$this->servicio->validarEntrada($ref));
		//$this->assertTrue($this->servicio->validarEnBd);
	}

}
