function leftArrowPressed() {
    document.getElementById('previousMediaLink').click();
}

function rightArrowPressed() {
    document.getElementById('nextMediaLink').click();
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    switch (evt.keyCode) {
        case 37:
            leftArrowPressed();
            break;
        case 39:
            rightArrowPressed();
            break;
    }
};