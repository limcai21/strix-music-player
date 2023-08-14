$(document).ready(function () {
    $(document).on("click", "#libraryFavouriteSection", function(e) {
        const playlistID = $(this).attr("playlistid");
        const loadURL = "playlist.php?id=" + playlistID

        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, loadURL);
                window.scrollTo(0, 0);
                window.oldTitleValue = $(data).find("#playlistTitle").text();
             }
        });
    })
});