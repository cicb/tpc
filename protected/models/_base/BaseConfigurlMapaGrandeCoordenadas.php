<?php

/**
 * This is the model base class for the table "configurl_mapa_grande_coordenadas".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ConfigurlMapaGrandeCoordenadas".
 *
 * Columns in table "configurl_mapa_grande_coordenadas" available as properties of the model,
 * followed by relations of table "configurl_mapa_grande_coordenadas" available as properties of the model.
 *
 * @property integer $id
 * @property string $ZonasId
 * @property string $SubzonaId
 * @property integer $x1
 * @property integer $y1
 * @property integer $x2
 * @property integer $y2
 * @property integer $x3
 * @property integer $y3
 * @property integer $x4
 * @property integer $y4
 * @property integer $x5
 * @property integer $y5
 *
 * @property Subzona $Zonas
 * @property Subzona $Subzona
 */
abstract class BaseConfigurlMapaGrandeCoordenadas extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'configurl_mapa_grande_coordenadas';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ConfigurlMapaGrandeCoordenadas|ConfigurlMapaGrandeCoordenadases', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('ZonasId, SubzonaId', 'required'),
			array('x1, y1, x2, y2, x3, y3, x4, y4, x5, y5', 'numerical', 'integerOnly'=>true),
			array('ZonasId, SubzonaId', 'length', 'max'=>20),
			array('x1, y1, x2, y2, x3, y3, x4, y4, x5, y5', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, ZonasId, SubzonaId, x1, y1, x2, y2, x3, y3, x4, y4, x5, y5', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
            'mapagrande'=>  array(self::BELONGS_TO, 'MapaGrande', 'configurl_funcion_mapa_grande_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'ZonasId' => null,
			'SubzonaId' => null,
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

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('ZonasId', $this->subzona_ZonasId);
		$criteria->compare('SubzonaId', $this->subzona_SubzonaId);
		$criteria->compare('x1', $this->x1);
		$criteria->compare('y1', $this->y1);
		$criteria->compare('x2', $this->x2);
		$criteria->compare('y2', $this->y2);
		$criteria->compare('x3', $this->x3);
		$criteria->compare('y3', $this->y3);
		$criteria->compare('x4', $this->x4);
		$criteria->compare('y4', $this->y4);
		$criteria->compare('x5', $this->x5);
		$criteria->compare('y5', $this->y5);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}