/*DIAFAN.CMS*/
var cat_search = '';

$('.cat_id_edit').click(function () {
	$(this).next('div').toggle();
});
$('input[name=cat_search]').keyup(function(){
	var self = $(this);
	if(cat_search == self.val())
	{
		return;
	}
	cat_search = self.val();
	if(! cat_search)
	{
		$('.cat_search_select').remove();
		return;
	}
	diafan_ajax.init({
		data:{
			action: 'cat_list',
			search: cat_search
		},
		success: function(response){
			
			self.next('.cat_search_select').remove();
			self.after(prepare(response.data));
		}
	});
});
$(document).on('click', '.cat_search_select li', function(){
	$('input[name=cat_search]').val($(this).text());
	$('input[name=cat_id]').val($(this).attr('cat_id'));
	$('.cat_search_select').remove();
});
	
	
$('#input_user_additional_cat_id').change(function() {
	$('.cat_ids').stop().slideToggle('fast');
});

if(!$('#input_user_additional_cat_id').is(':checked')) $('.cat_ids').hide();