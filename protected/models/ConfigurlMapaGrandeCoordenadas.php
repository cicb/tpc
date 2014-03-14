<?php

Yii::import('application.models._base.BaseConfigurlMapaGrandeCoordenadas');

class ConfigurlMapaGrandeCoordenadas extends BaseConfigurlMapaGrandeCoordenadas
{
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
    
    public function rules() {
        return array(
            array('ZonasId, SubzonaId', 'required'),
            array('x1, y1, x2, y2, x3, y3, x4, y4, x5, y5, x6, y6, x7, y7, x8, y8, x9, y9, x10, y10, x11, y11, x12, y12, x13, y13, x14, y14', 'numerical', 'integerOnly'=>true),
            array('ZonasId, SubzonaId', 'length', 'max'=>20),
            array('x1, y1, x2, y2, x3, y3, x4, y4, x5, y5, x6, y6, x7, y7, x8, y8, x9, y9, x10, y10, x11, y11, x12, y12, x13, y13, x14, y14', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, ZonasId, SubzonaId, x1, y1, x2, y2, x3, y3, x4, y4, x5, y5, x6, y6, x7, y7, x8, y8, x9, y9, x10, y10, x11, y11, x12, y12, x13, y13, x14, y14, returnUrl', 'safe', 'on'=>'search'),
        );
    }
    
    public function getCoordenadasComoCadena() {
        
        $coordenadas = '';
        for ($i=1; $i < 15; $i++) {
            $x = 'x'.$i;
            $y = 'y'.$i;
            
            if (isset($this->$x)) {
                if ($i > 1)
                    $coordenadas .= ',' . $this->$x;
                else
                    $coordenadas = $this->$x;
            }
            
            if (isset($this->$y)) {
                $coordenadas .= ',' . $this->$y;
            }
        }
        
        return $coordenadas;
        
    }
    
    public function getZona() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionesId = :FuncionId');
        $criteria->addCondition('t.ZonasId = :ZonaId');
        $criteria->params = array(
            ':EventoId'=>$this->mapa->EventoId,
            ':FuncionId'=>$this->mapa->FuncionId,
            ':ZonaId'=>$this->ZonasId,
        );
        
        return Zonas::model()->find($criteria);
    }
    
    public function getSubzona() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionesId = :FuncionId');
        $criteria->addCondition('t.ZonasId = :ZonaId');
        $criteria->addCondition('t.SubzonaId = :SubzonaId');
        $criteria->params = array(
            ':EventoId'=>$this->mapa->EventoId,
            ':FuncionId'=>$this->mapa->FuncionId,
            ':ZonaId'=>$this->ZonasId,
            ':SubzonaId'=>$this->SubzonaId,
        );
        
        return Subzonas::model()->find($criteria);
    }
    
    public function relations() {
        return array(
            'mapa' => array(self::BELONGS_TO, 'MapaGrande', 'configurl_funcion_mapa_grande_id'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'ZonasId' => 'Zona',
            'SubzonaId' => 'Subzona',
            'x1' => Yii::t('app', 'X1'),
            'y1' => Yii::t('app', 'Y1'),
            'x2' => Yii::t('app', 'X2'),
            'y2' => Yii::t('app', 'Y2'),
            'x3' => Yii::t('app', 'X3'),
            'y3' => Yii::t('app', 'Y3'),
            'x4' => Yii::t('app', 'X4'),
            'y4' => Yii::t('app', 'Y4'),
            'x5' => Yii::t('app', 'X5'),
            'y5' => Yii::t('app', 'Y5'),
            'Zonas' => null,
            'Subzona' => null,
        );
    }
}
