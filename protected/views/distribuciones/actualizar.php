<div class="actualizar">
    <div class="coordenadas-mapas" style="padding: 3px;">
    <?php $this->widget('bootstrap.widgets.TbTabs', array(
    'tabs' => array(
			array(
					'label' => 'Mapa Chico', 
					'content' => $this->renderPartial('_mapaChico',array(
						'model'=>$model,
						'eventoId'=>$model->EventoId,
						'funcionId'=>$model->FuncionesId),true),
					'active' => true),
			array(
					'label' => 'Mapa Grande', 
					'content' => $this->renderPartial('_mapaGrande',array(
							'model'=>$model,
							'eventoId'=>$model->EventoId,
							'funcionId'=>$model->FuncionesId),true
					)
			),
    ),
)); ?>
    </div>
</div>
