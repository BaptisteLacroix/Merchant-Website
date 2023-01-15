const magnifier = $('.magnifier');
const magnified = $('.magnified');

// Set magnifier background image same as img
magnifier.css("background-image", "url(" + $("#myimage").attr("src") + ")");
// Set disable true on loading page
magnifier.hide();

magnified.hover(function (e) {
    //Store position & dimension information of image
    let imgPosition = $(".magnify").position(),
        imgHeight = magnified.height(),
        imgWidth = magnified.width();

    //Show mangifier on hover
    magnifier.show();

    //While the mouse is moving and over the image move the magnifier and magnified image
    $(this).mousemove(function (e) {
        //Store position of mouse as it moves and calculate its position in percent
        let posX = e.pageX - imgPosition.left,
            posY = e.pageY - imgPosition.top,
            percX = (posX / imgWidth) * 100,
            percY = (posY / imgHeight) * 100,
            perc = percX + "% " + percY + "%";

        //Change CSS of magnifier, move it to mouse location and change background position based on the percentages stored.
        magnifier.css({
            top: posY,
            left: posX,
            backgroundPosition: perc
        });
    });
}, function () {
    //Hide the magnifier when mouse is no longer hovering over image.
    magnifier.hide();
});
