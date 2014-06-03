<?php 
$fid=$model->FilasId;
$sid=$model->SubzonaId;
$zid=$model->ZonasId;
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::numberField('LugaresIni',$model->LugaresIni,array(
					'class'=>'input-mini text-center pull-right LugaresIni limite vivo',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'data-zid'=>$zid,
					'id'=>"LugaresIni-$sid-$fid",
			))); ?>
<?php echo TbHtml::tag('td',array(), 
		TbHtml::numberField('LugaresFin',$model->LugaresFin,array(
					'class'=>'input-mini text-center pull-left LugaresFin limite vivo',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'data-zid'=>$zid,
					'id'=>"LugaresFin-$sid-$fid",
			))); 
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::textField('FilasCanLug',$model->FilasCanLug,array(
					'class'=>'input-mini text-center pull-left FilasCanLug vivo',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'data-zid'=>$zid,
					'id'=>"FilasCanLug-$sid-$fid",
					'readonly'=>true,
					'disabled'=>true,
			)));
?>
