$.fn.chosenDestroy = function () {
	$(this).show().removeClass('chzn-done').removeAttr('id');
	$(this).next().remove()
	return $(this);
}
function updateChosen(obj){
	$(obj).chosenDestroy();
	$(obj).chosen();
}


$('.FecHor').live('change',
	function()
	{
		var id=$(this).data('id');
		var meses = new Array ("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC");
		var diasSemana = new Array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		var fechatemp = new Date($(this).val());
		$('#FuncText-'+id).val(diasSemana[fechatemp.getDay()] + " " + fechatemp.getDate() + " - " + 
			meses[fechatemp.getMonth()] + " - " + fechatemp.getFullYear() + " " + (fechatemp.getHours()<"10" ? "0"+fechatemp.getHours() : fechatemp.getHours())+ ":"+ (fechatemp.getMinutes()<"10" ? "0"+fechatemp.getMinutes() : fechatemp.getMinutes()) + " HRS");
	});

$('.FecIni').live('focusout', 
	function()
	{	
		var id=$(this).data('id');
		var datos={Funciones:{FuncionesFecIni:$(this).val()} };
		actualizarf(datos,$(this).data('id'));
	});	
$('.FecHor').live('focusout', 
	function()
	{	
		var id=$(this).data('id');
		var datos={Funciones:{FuncionesFecHor:$(this).val(), funcionesTexto:$('#FuncText-'+id).val()} };
		actualizarf(datos,$(this).data('id'));
	});

$('.FuncText').live('focusout', 
	function()
	{	
		var id=$(this).data('id');
		var datos={Funciones:{funcionesTexto:$(this).val()} };
		actualizarf(datos,$(this).data('id'));
	});

$('.FuncText').live('keyup',
	function()
	{
		$(this).attr('id','-1');
	});



$(function() {
  	  // Apparently click is better chan change? Cuz IE?
  	  $('input[type="checkbox"]').live('change',function(e) {
  	  	var checked = $(this).prop("checked"),
  	  	container = $(this).parent(),
  	  	siblings = container.siblings();
  	  	
  	  	container.find('input[type="checkbox"]').prop({
  	  		indeterminate: false,
  	  		checked: checked
  	  	});
  	  	
  	  	function checkSiblings(el) {
  	  		var parent = el.parent().parent(),
  	  		all = true;
  	  		
  	  		el.siblings().each(function() {
  	  			return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
  	  		});
  	  		
  	  		if (all && checked) {
  	  			parent.children('input[type="checkbox"]').prop({
  	  				indeterminate: false,
  	  				checked: checked
  	  			});
  	  			checkSiblings(parent);
  	  		} else if (all && !checked) {
  	  			parent.children('input[type="checkbox"]').prop("checked", checked);
  	  			parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
  	  			checkSiblings(parent);
  	  		} else {
  	  			el.parents("li").children('input[type="checkbox"]').prop({
  	  				indeterminate: true,
  	  				checked: false
  	  			});
  	  		}
  	  	}
  	  	
  	  	checkSiblings(container);
  	  });
});

$( '.nodo-toggle').live('click',function(){
	var id= $(this).data('id');
	var li= $(this).parent().attr('id');
	var link= $(this);
	if (link.data('estado')=='inicial') {
		var href= link.attr('href');
		$.ajax({
			url:href,
			success:function(data){ 
				$('#'+li).append(data);
				link.data('estado','toggle')
				link.toggleClass('fa-minus-square');
				$('.picker').datetimepicker({allowTimes:1,format:'Y-m-d H:i'});
			}
		});
	}
	else if (link.data('estado')=='toggle'){
		link.toggleClass('fa-minus-square');
		$('#rama-'+li).toggle();
		// link.toggleClass('fa-plus-square');
	}
	return false;
})

$( '.nodo-cal').live('click',function(){
	$('#dlg').load($(this).attr('href'));
});


