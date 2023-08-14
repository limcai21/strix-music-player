$(document).ready(function () {
    const paddingTop = $(".main").css("padding-top");
    const paddingBottom = $(".main").css("padding-bottom");
    const header = $(".main .header").outerHeight();
    const headerMarginBottom = $(".main .header").css("margin-bottom");
    const navBar = $("#topNav").outerHeight();
    const footer = $("footer").outerHeight();

    $(".main .choiceBtn button").css("height", "calc(100vh - " + paddingTop + " - " + paddingBottom + " - " + (header + footer + navBar) + "px - " + headerMarginBottom + ")")
    $("#topNav .right .links").css("top", navBar + "px");

    $(window).resize(function(){
        const navBar = $("#topNav").outerHeight();
        $("#topNav .right .links").css("top", navBar + "px");
    });
});