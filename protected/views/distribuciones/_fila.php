<?php 
$fid=$model->FilasId;
$sid=$model->SubzonaId;
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::numberField('LugaresIni',$model->LugaresIni,array(
					'class'=>'input-mini text-center pull-right LugaresIni',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'id'=>"LugaresIni-$sid-$fid",
			))); ?>
<?php echo TbHtml::tag('td',array(), 
		TbHtml::numberField('LugaresFin',$model->LugaresFin,array(
					'class'=>'input-mini text-center pull-left LugaresFin',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'id'=>"LugaresFin-$sid-$fid",
			))); 
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::numberField('FilasCanLug',$model->FilasCanLug,array(
					'class'=>'input-mini text-center pull-left FilasCanLug',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
					'id'=>"FilasCanLug-$sid-$fid",
					'readonly'=>true,
			)));
?>
