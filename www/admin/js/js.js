
/*----------------------------------------------------------------------------*/
/* SetColors colorpicker: */
var setColors = function (colors,pickers) {
    pickers.forEach(function (name) {
        var picker = $.farbtastic('#colpick_' + name[0]);  //picker variable
        colors != null ? picker.setColor(colors[name[0] + '_color']) : null //set initial color
        picker.linkTo(function (color) {
            $(name[1]).val(color)
            $(name[1]).next('.openColpick').css('background-color', color)
        }); //link to callback
    })

    if(colors != null){
        setTimeout(function () {
            pickers.forEach(function (name) {
                $(name[1]).val(colors[name[0] + '_color'])
                $(name[1]).next('.openColpick').css('background-color', colors[name[0] + '_color'])
            })
        }, 100)
    }
}

/*----------------------------------------------------------------------------*/
/* FileInput beautify: */
var fileUpload = function (id, images, urlDel){
    var match = null;
    var options = {
        language: "en",
        initialPreviewAsData: true,
        allowedFileExtensions: ['png', 'gif', 'jpg', 'jpeg', 'JPG'],
        validateInitialCount: true,
        resizeImage: true,
        maxFileSize: 2000,
        maxImageWidth: 1000,
        browseClass: "btn btn-primary btn-block",
        showCaption: false,
        showRemove: false,
        showUpload: false,
        uploadAsync: false,
        autoReplace: true
    };
    if(images){
        match = images[0].match(/\.(jpg|png|gif|jpeg|JPG)\b/);
    }
    if (match != null) {
        options.initialPreview = images;
        options.initialPreviewConfig = [{
            url: urlDel
        }];
    }
    var uploader = $("#" + id);
    uploader.fileinput(options);
};

$(document).ready(function() {

/*----------------------------------------------------------------------------*/
/* Toggle colorpicker: */
    $(".openColpick").click(function () {
        $(".divColpick").hide();
        $(this).next(".divColpick").show();
    });
    $(".closeColpick").click(function () {
        $(this).closest('.divColpick').hide();
    });




});