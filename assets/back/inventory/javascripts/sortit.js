$(function(){
$('#sortit').sortable({
    revert:true,
    axis: 'y',
    handle: '.handle',
    update: function(){$.post($(this).data('update-url'),$(this).sortable('serialize'));}
	});
$('.sortmultiple').sortable({
    revert:true,
    axis: 'y',
    handle:'.multihandle',
    update: function(){$.post($(this).data('update-url'),$(this).sortable('serialize'));}
	});
});