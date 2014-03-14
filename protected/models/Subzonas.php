<?php

Yii::import('application.models._base.BaseSubzonas');

class Subzonas extends BaseSubzonas
{
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
    
    public function getFilas() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionesId = :FuncionId');
        $criteria->addCondition('t.ZonasId = :ZonaId');
        $criteria->addCondition('t.SubzonaId = :SubzonaId');
        $criteria->order = 't.FilasNum';
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId,
            ':ZonaId'=>$this->ZonasId,
            ':SubzonaId'=>$this->SubzonaId
        );
        
        return Filas::model()->findAll($criteria);
    }

    public function getCoordenadasComoCadena() {
        $coordenadas = '';
        
        if (isset($this->SubzonaX1) && isset($this->SubzonaY1) &&
            $this->SubzonaX1 != 0 && $this->SubzonaY1 != 0) {
            $coordenadas .= $this->SubzonaX1 . ',' . $this->SubzonaY1;
        }
        
        if (isset($this->SubzonaX2) && isset($this->SubzonaY2) &&
            $this->SubzonaX2 != 0 && $this->SubzonaY2 != 0) {
            $coordenadas .= ','. $this->SubzonaX2 . ',' . $this->SubzonaY2;
        }
        
        if (isset($this->SubzonaX3) && isset($this->SubzonaY3) &&
            $this->SubzonaX3 != 0 && $this->SubzonaY3 != 0) {
            $coordenadas .= ',' . $this->SubzonaX3 . ',' . $this->SubzonaY3;
        }
        
        if (isset($this->SubzonaX4) && isset($this->SubzonaY4) &&
            $this->SubzonaX4 != 0 && $this->SubzonaY4 != 0) {
            $coordenadas .= ','. $this->SubzonaX4 . ',' . $this->SubzonaY4;
        }
        
        if (isset($this->SubzonaX5) && isset($this->SubzonaY5) &&
            $this->SubzonaX5 != 0 && $this->SubzonaY5 != 0) {
            $coordenadas .= ',' .$this->SubzonaX5 . ',' . $this->SubzonaY5;
        }
        
        return $coordenadas;
    }
    
    public function getZona() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.FuncionesId = :FuncionId');
        $criteria->addCondition('t.ZonasId = :ZonaId');
        $criteria->params = array(
            ':EventoId'=>$this->EventoId,
            ':FuncionId'=>$this->FuncionesId,
            ':ZonaId'=>$this->ZonasId,
        );
        
        return Zonas::model()->find($criteria);
    }
    
    
    public function getNumeroLugaresDisponibles() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.SubzonaId = :SubzonaId');
        $criteria->addCondition('t.ZonasId = :ZonaId');
        $criteria->addCondition('t.FuncionesId = :FuncionId');
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.LugaresStatus = "TRUE"');
        $criteria->params = array(
            ':SubzonaId' => $this->SubzonaId,
            ':ZonaId' => $this->ZonasId,
            ':FuncionId' => $this->FuncionesId,
            ':EventoId' => $this->EventoId
        );
        
        return Lugares::model()->count($criteria);;
    }
    
    public function getLugaresDisponibles($limite) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.SubzonaId = :SubzonaId');
        $criteria->addCondition('t.ZonasId = :ZonaId');
        $criteria->addCondition('t.FuncionesId = :FuncionId');
        $criteria->addCondition('t.EventoId = :EventoId');
        $criteria->addCondition('t.LugaresStatus = "TRUE"');
        $criteria->limit = $limite;
        $criteria->params = array(
            ':SubzonaId' => $this->SubzonaId,
            ':ZonaId' => $this->ZonasId,
            ':FuncionId' => $this->FuncionesId,
            ':EventoId' => $this->EventoId
        );
        
        return Lugares::model()->findAll($criteria);
    }
}
