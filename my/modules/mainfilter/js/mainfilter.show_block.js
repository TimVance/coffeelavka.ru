$(function() {

    let form = $(".js_mainfilter_form");
    let inputs = $('.mainfilter-element input[type="checkbox"]');
    let reset = $('.mainfilter-wrapper input[type="reset"]');

    inputs.change(function() {form.submit();});
    reset.click(function() {
        inputs.prop("checked", false);
        form.submit();
        return false;
    });

    $(".mainfilter-param-title").click(function () {
        $(this).parent().toggleClass("open").find(".mainfilter-elements").slideToggle();
    });
});

diafan_ajax.before['mainfilter_get'] = function(form) {
    $(".mainfilter-catalog").addClass("load");
}

diafan_ajax.success['mainfilter_get'] = function(form, response){
    var k = 0;
    $(".mainfilter-catalog").html(prepare(response.data)).removeClass("load");
    return false;
}