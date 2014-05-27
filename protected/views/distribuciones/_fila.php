<?php echo TbHtml::openTag('td'); ?>
	    	<?php echo TbHtml::numberField('LugaresIni',0,array(
					'class'=>'input-mini text-center pull-right LugaresIni',		
					//'prepend'=>'Inicio:',
					'data-fid'=>$fid,
					'data-sid'=>$sid,
			)); ?>
<?php echo TbHtml::closeTag('td'); ?>
<?php echo TbHtml::openTag('td'); ?>
	    	<?php echo TbHtml::numberField('LugaresFin',0,array(
					'class'=>'input-mini text-center pull-left LugaresFin',		
					//'prepend'=>'Último lugar:',
					'data-fid'=>$fid,
					'data-sid'=>$sid,
			)); ?>
<?php echo TbHtml::closeTag('td'); ?>
