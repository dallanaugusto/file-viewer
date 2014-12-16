$(document).keydown(function(evt) {
    switch (evt.keyCode) {
        case 37:
            $('#previousMediaLink')[0].click();
            break;
        case 39:
            $('#nextMediaLink')[0].click();
            break;
    }
});