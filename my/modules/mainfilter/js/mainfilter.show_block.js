$(function() {
    let form = $(".js_mainfilter_form");
    $('.mainfilter-element input').change(function() {
        form.submit();
    });
});

diafan_ajax.before['mainfilter_get'] = function(form) {
    //$(".mainfilter-catalog").text('Загрузка...');
}

diafan_ajax.success['mainfilter_get'] = function(form, response){
    //var k = 0;
    console.log(response);
    $(".mainfilter-catalog").html(prepare(response.data));
    if (response.js) {
        $('body').append(prepare(response.js));
    }
    return false;
}