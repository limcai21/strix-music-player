$(document).ready(function () {
    if ($(window).outerWidth() > 1200) {
        const headerHeight = $("#topNav").outerHeight();
        const footerHeight = $("#bottomFooter").outerHeight();
        const paddingTop = $("#main").css("padding-top");
        const paddingBottom = $("#main").css("padding-bottom");
        const removeHeight = headerHeight + footerHeight;
        $("#main").css("min-height", "calc(100vh - " + removeHeight + "px - " + paddingTop + " - " + paddingBottom + ")")
    }



    $(".albumCover").click(function (e) { 
        const albumID = $(this).attr("id");
        window.location = "./app/album.php?id=" + albumID; 
    });
});