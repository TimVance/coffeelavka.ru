$(function() {
    let form = $(".js_mainfilter_form");
    $('.mainfilter-element input[type="checkbox"]').change(function() {form.submit();});
    $('.mainfilter-element input[type="reset"]').change(function() {form.submit();});
});

diafan_ajax.before['mainfilter_get'] = function(form) {
    //$(".mainfilter-catalog").text('Загрузка...');
}

diafan_ajax.success['mainfilter_get'] = function(form, response){
    var k = 0;
    $(".mainfilter-catalog").html(prepare(response.data));
    if (response.js) {
        //$(".mainfilter-catalog").append(prepare(response.js));
    }
    return false;
}