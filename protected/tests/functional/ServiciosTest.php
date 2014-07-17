<?php

class ServiciosTest extends WebTestCase
{
	public function testIndex()
	{
		$s=new Servicios();
		// $this->assertEquals('word',$servicios->validar());

		$this->assertClassHasAttribute('validar');
		// $this->assertTrue($s->validar());
	}

}
