$(document).ready(function () {
    $(".albumData").click(function (e) { 
        const albumID = $(this).attr("id")
        window.location = "./index.php?id=" + albumID;
    });

    $("#filter").change(function (e) { 
        const filter = $(this).val();
        window.location = "./index.php?filter=" + filter;
    });
});