<?php 
$fid=$model->FilasId;
$sid=$model->SubzonaId;
$zid=$model->ZonasId;
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::textField('LugaresIni',$model->LugaresIni,array(
					'class'=>'input-mini text-center pull-right LugaresIni limite ',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'data-zid'=>$zid,
					'id'=>"LugaresIni-$sid-$fid",
			))); ?>
<?php echo TbHtml::tag('td',array(), 
		TbHtml::textField('LugaresFin',$model->LugaresFin,array(
					'class'=>'input-mini text-center pull-left LugaresFin limite ',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'data-zid'=>$zid,
					'id'=>"LugaresFin-$sid-$fid",
			))); 
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::textField('FilasCanLug',$model->FilasCanLug,array(
					'class'=>'input-mini text-center pull-left FilasCanLug ',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'data-zid'=>$zid,
					'id'=>"FilasCanLug-$sid-$fid",
					'readonly'=>true,
					'disabled'=>true,
			)));
?>
