jQuery(document).ready(function(){
    jQuery(document).on('click', '#search', function () {
        jQuery.get('/search', function (data) {
            console.log(data[0]);
        })
    });
});