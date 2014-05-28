<?php echo TbHtml::tag('td',array(),
		TbHtml::numberField('LugaresIni',0,array(
					'class'=>'input-mini text-center pull-right LugaresIni',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
			))); ?>
<?php echo TbHtml::tag('td',array(), 
		TbHtml::numberField('LugaresFin',0,array(
					'class'=>'input-mini text-center pull-left LugaresFin',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
			))); 
?>
<?php echo TbHtml::tag('td',array(),
		TbHtml::numberField('FilasLugCan',0,array(
					'class'=>'input-mini text-center pull-right FilasLugCan',		
					'data-fid'=>$fid,
					'data-sid'=>$sid,
			)));
?>
