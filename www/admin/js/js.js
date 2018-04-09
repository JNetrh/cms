
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

    $(".onKey").keyup(function (event) {
        var typed = $(this).val();
        if(typed.match(/^#([0-9a-f]{3}|[0-9a-f]{6})$/i))
            $(this).next('.openColpick').css('background-color', typed)
    })
});

/*----------------------------------------------------------------------------*/
/* Handle tooltip: */
$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        animation: true,
        delay: { "show": 100, "hide": 100 },
        placement: 'auto',
        html: true,
        title: function () {
            return getTooltip($(this).attr('tpId'))
        }
    });
    $('[data-toggle="tooltip"]').addClass('itemTooltip')
})

function getTooltip(nr) {
    var i = {
        "1": "Items that might appear in menu. Set visibility to appear them. You can also create your own menu item with external link",
        "2": "Heading of the block you have created before",
        "3": "Name of the menu item displayed in menu",
        "4": 'External url must contain <em>http://</em> or <em>https://</em> protocol. Eg.&nbsp;<em>https://</em>www.facebook.com',
        "5": 'In case you have no image, enter the text. This text is overwritten once you upload an image',
        "6": 'Color displayed after mouse over this button and active item',
        "7": 'The very first text you can see after you reach the website',
        "8": 'Supplementary text displayed right after main heading tetx',
        "9": 'Whether this block is suppose to be shown',
        "10": 'Color of the name displayed after sub block image',
        "11": 'You can use the DatePicker to set the event time. The date and time format you use will be displayed in the front page also',
        "12": 'In case of events they are not sorted by time but they are ranked by the position',
        "13": 'You can write here literrary anythig you want to display bold eg. "do you have any questions? Write us."',
        "14": 'It is demanded to fill the correct email since it becomes a link that is clickable for user to processed right to the preferred email client. ',
        "15": 'You can fill any text you want. It will display in one row until it is not too long to break into a new line. SO there is no need to fill just and only your phone number.',
        "16": 'Background color of individual blocks  ',
        "17": 'This image will display 300px height and it will fit the others by increasing or decreasing its size. Too small images will be increased and on the other hand too large images will be cropped.',
        "18": 'LogoText',
        "19": 'LogoText',
        "20": 'LogoText',
        "21": 'LogoText',
        "22": 'LogoText',
        "22": 'LogoText',
        "22": 'LogoText',
        "22": 'LogoText',
        "22": 'LogoText',
        "22": 'LogoText',
    };

    return i[nr];
}


var confirmBox = '<div class="modal fade confirm-modal">' +
    '<div class="modal-dialog modal-sm" role="document">' +
    '<div class="modal-content">' +
    '<button type="button" class="close m-4 c-pointer" data-dismiss="modal" aria-label="Close">' +
    '<span aria-hidden="true">&times;</span>' +
    '</button>' +
    '<div class="modal-body pb-5"></div>' +
    '<div class="modal-footer pt-3 pb-3">' +
    '<a href="#" class="btn btn-primary yesBtn btn-sm">OK</a>' +
    '<button type="button" class="btn btn-secondary abortBtn btn-sm" data-dismiss="modal">Do nothing</button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>';

var dialog = function(el, text, trueCallback, abortCallback) {

    el.click(function(e) {

        var thisConfirm = $(confirmBox).clone();

        thisConfirm.find('.modal-body').text(text);

        e.preventDefault();
        $('body').append(thisConfirm);
        $(thisConfirm).modal('show');

        if (abortCallback) {
            $(thisConfirm).find('.abortBtn').click(function(e) {
                e.preventDefault();
                abortCallback();
                $(thisConfirm).modal('hide');
            });
        }

        if (trueCallback) {
            $(thisConfirm).find('.yesBtn').click(function(e) {
                e.preventDefault();
                trueCallback();
                $(thisConfirm).modal('hide');
            });
        } else {

            if (el.prop('nodeName') == 'A') {
                $(thisConfirm).find('.yesBtn').attr('href', el.attr('href'));
            }

            if (el.attr('type') == 'submit') {
                $(thisConfirm).find('.yesBtn').click(function(e) {
                    e.preventDefault();
                    el.off().click();
                });
            }
        }

        $(thisConfirm).on('hidden.bs.modal', function(e) {
            $(this).remove();
        });

    });
}