<?php

Yii::import('application.models._base.BaseMapaGrande');

class MapaGrande extends BaseMapaGrande
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
        public function rules() {
            return array(
                array('configurl_Id, EventoId, FuncionId', 'required'),
                array('configurl_Id, EventoId, FuncionId', 'length', 'max'=>20),
                array('nombre_imagen', 'file', 'types'=>'jpg, gif, png',  'allowEmpty' => true),
                array('nombre_imagen', 'default', 'setOnEmpty' => true, 'value' => null),
                array('id, configurl_Id, EventoId, FuncionId, nombre_imagen', 'safe', 'on'=>'search'),
                array('nombre_imagen', 'unsafe'),
            );
	}
        
        public function relations() {
            return array(
                'configurl' => array(self::BELONGS_TO, 'Configurl', 'configurl_Id'),
                'evento' => array(self::BELONGS_TO, 'Eventos', 'EventoId'),
                'funcion' => array(self::BELONGS_TO, 'Funciones', 'EventoId, FuncionId'),
                'coordenadas' => array(self::HAS_MANY, 'ConfigurlMapaGrandeCoordenadas', 'configurl_funcion_mapa_grande_id'),
            );
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
            return array(
                    'id' => Yii::t('app', 'ID'),
                    'configurl_Id' => 'Evento',
                    'EventoId' => 'Evento *',
                    'FuncionId' => 'Función *',
                    'nombre_imagen' => Yii::t('app', 'Imágen del Foro (grande)'),
                    'configurl' => null,
                    'evento' => null,
                    'funcion' => null,
            );
	}
   /* public function beforeSave(){
         if (parent::beforeSave()){
            
         }
    }*/
    
}