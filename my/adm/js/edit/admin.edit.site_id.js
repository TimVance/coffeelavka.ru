/*DIAFAN.CMS*/
$('select[name=site_id').each(admin_edit_site_id);
$('select[name=site_id').change(admin_edit_site_id);
function admin_edit_site_id()
{
	if (! $('select[name=cat_id]').length)
	{
		return;
	}
	var site_id = $(this).val();
	$('select[name=cat_id] option').each(function(){
		if ($(this).attr('rel') !== "0" && $(this).attr('rel') !== site_id) {
			$(this).hide();
			if ($(this).is(':selected')) {
				$(this).prop('selected', false);
			}
		}
		else
		{
			$(this).show();
		}
	});
	if (! $('select[name=cat_id] option[rel='+site_id+']').length) {
		$('select[name=cat_id]').prepend('<option value="" rel="'+site_id+'">-</option>');
	}
	if(! $('select[name=cat_id] option[rel='+site_id+']:selected').length && ! $('select[name=cat_id] option[rel=0]:selected').length)
	{
		$('select[name=cat_id]').val($('select[name=cat_id] option[rel='+site_id+']').first().attr("value"));
	}
}