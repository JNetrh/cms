
/*----------------------------------------------------------------------------*/
/* SetColors colorpicker: */
var setColors = function (colors,pickers) {
    console.log(colors)
    console.log(pickers)
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
        maxFileSize: 10240,
        validateInitialCount: true,
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
        $(".divColpick").hide()
        $(this).next(".divColpick").show()
    })
    $(".closeColpick").click(function () {
        $(this).closest('.divColpick').hide()
    })



// /*----------------------------------------------------------------------------*/
// /* FileInput beautify: */
//     // We can attach the `fileselect` event to all file inputs on the page
//     $(document).on('change', ':file', function() {
//         var input = $(this),
//             numFiles = input.get(0).files ? input.get(0).files.length : 1,
//             label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
//         input.trigger('fileselect', [numFiles, label]);
//     });
//
//     // We can watch for our custom `fileselect` event like this
//     $(document).ready( function() {
//         $(':file').on('fileselect', function(event, numFiles, label) {
//
//             var input = $(this).parents('.input-group').find(':text'),
//                 log = numFiles > 1 ? numFiles + ' files selected' : label;
//
//             if( input.length ) {
//                 input.val(log);
//             } else {
//                 if( log ) alert(log);
//             }
//
//         });
//     });




});