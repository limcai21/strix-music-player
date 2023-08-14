$(document).ready(function () {
    //  NAV BAR
    const navBar = $("#sideNavBar").outerHeight();
    $("#sideNavBar .content .middle .navigationButton").css("top", navBar + "px");

    $(window).resize(function(){
        const navBar = $("#sideNavBar").outerHeight();
        $("#sideNavBar .content .middle .navigationButton").css("top", navBar + "px");
    });


    // BACK EVENT
    window.onpopstate = () => setTimeout(backEvent, 0);
    function backEvent() {
        const url = window.location.href;
        $.ajax({
            url: url,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
            }
        });
    }






    // NAVIGATION BUTTON
    $(document).on("click", "#homeBtn", function (e) { 
        const redirectedURL = "./"
        const loadURL = "index.php"
        
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
                document.getElementById("navDrop").checked = false;
             }
        });
    });

    $(document).on("click", "#siteLogo", function (e) { 
        const redirectedURL = "./"
        const loadURL = "index.php"
        
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
             }
        });
    });

    $(document).on("click", "#searchBtn", function (e) { 
        const redirectedURL = "./search"
        const loadURL = "search.php"
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
                document.getElementById("navDrop").checked = false;
             }
        });
    });

    $(document).on("click", "#playlistToSearch", function (e) { 
        const redirectedURL = "./search"
        const loadURL = "search.php"
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
             }
        });
    });

    $(document).on("click", "#libraryBtn", function (e) { 
        const redirectedURL = "./library"
        const loadURL = "library.php"
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
                document.getElementById("navDrop").checked = false;
             }
        });
    });

    $(document).on("click", "#accountBtn", function (e) { 
        window.open('../account.php');
    });
    
    $(document).on("click", "#adminPortalBtn", function (e) { 
        window.open('../admin/');
    });

    $(document).on("click", "#viewMorePlaylist", function (e) { 
        const redirectedURL = "./library"
        const loadURL = "library.php"
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
             }
        });
    });



    // NAVIGATION BOTTOM
    $(document).on("click", ".createPlaylist", function (e) { 
        $userID = $(this).attr("userid");

        $.ajax({
            url: "./process/createPlaylist.php",
            type: 'post',
            dataType: 'JSON',
            success: function(result) {
                console.log(result)
                $status = result[0].status

                if ($status) {
                    const playlistID = result[0].playlistID
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
                }

                else {
                    alert("Can't create playlist at the moment. Try again later");
                }
             }
        });
    });

    $(document).on("click", "#likeSongPlaylist", function (e) { 
        const playlistID = $(this).attr("playlistid");
        const redirectedURL = "./playlist.php?id=" + playlistID
        const loadURL = "playlist.php?id=" + playlistID
        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, redirectedURL);
             }
        });
    });







    // FAVOURITE BTN
    $(document).on("click", ".favouriteBtn", function (e) { 
        const songID = $(this).attr("songid");
        const favouriteOrNot = $(this).attr("favourite");
        const element = this;

        $.ajax({
            url: "./process/addToFavourite.php",
            type: 'post',
            data: { songID: songID, favouriteOrNot: favouriteOrNot },
            dataType: 'JSON',
            success: function (result) {
                $status = result[0].status
                $status1 = result[0].status1         // REMOVE FROM FAV
                $svg1 = result[0].svg1
                $status2 = result[0].status2         // ADD TO FAVOURITE
                $svg2 = result[0].svg2

                $playerCurrentSongID = $("#favouriteBtn").attr("songid");

                if ($status) {
                    if ($status1) {
                        $(element).attr("favourite", "0");
                        $(element).html($svg1);

                        if (songID == $playerCurrentSongID) {
                            $("#favouriteBtn").attr("favourite", "0");
                            $("#favouriteBtn").html($svg1);
                        }
                    }

                    else if ($status2) {
                        $(element).attr("favourite", "1");
                        $(element).html($svg2);

                        if (songID == $playerCurrentSongID) {
                            $("#favouriteBtn").attr("favourite", "1");
                            $("#favouriteBtn").html($svg2);
                        }
                    }

                    refreshPage();
                }

                else {
                    alert("Something went wrong, try again later")
                }
            }
        })
    });



    // REFRESH PAGE (AJAX)
    window.refreshPage = function() {
        var path = window.location.pathname;
        var query = window.location.search

        $.ajax({
            url: path + query,
            success: function(data) {
                const ajaxData = $(data).find("div#main").html()
                $("#main").html(ajaxData);
             }
        });
    }



    // MORE BTN
    $(document).on("click", ".moreBtn", function (e) { 
        $(".removeSongFromPlaylist").remove();
        const songID = $(this).parent().parent().find(".left .playIndividualSong").attr("songid");
        const playlistID = new URLSearchParams(window.location.search).get('id')
        const currentURL = window.location.pathname.split('/').pop();
        const playlistSongID =  $(this).parent().parent().attr("playlistsongid");
        const playlistOwnerID = $(this).attr("playlistowner");
        const userID = $(this).attr("userid")
        const playlistTitle = $("#playlistTitle").text()

        if (playlistOwnerID == userID) {
            if (currentURL.includes("playlist") && playlistTitle != "Favourites") {
                $('#threeBarMenu .playlistActions').append(`
                    <div class="item removeSongFromPlaylist" songid='${songID}' playlistid = '${playlistID}' playlistsongid = '${playlistSongID}'>
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 1.75a3.25 3.25 0 0 1 3.245 3.066L15.25 5h5.25a.75.75 0 0 1 .102 1.493L20.5 6.5h-.796l-1.28 13.02a2.75 2.75 0 0 1-2.561 2.474l-.176.006H8.313a2.75 2.75 0 0 1-2.714-2.307l-.023-.174L4.295 6.5H3.5a.75.75 0 0 1-.743-.648L2.75 5.75a.75.75 0 0 1 .648-.743L3.5 5h5.25A3.25 3.25 0 0 1 12 1.75Zm6.197 4.75H5.802l1.267 12.872a1.25 1.25 0 0 0 1.117 1.122l.127.006h7.374c.6 0 1.109-.425 1.225-1.002l.02-.126L18.196 6.5ZM13.75 9.25a.75.75 0 0 1 .743.648L14.5 10v7a.75.75 0 0 1-1.493.102L13 17v-7a.75.75 0 0 1 .75-.75Zm-3.5 0a.75.75 0 0 1 .743.648L11 10v7a.75.75 0 0 1-1.493.102L9.5 17v-7a.75.75 0 0 1 .75-.75Zm1.75-6a1.75 1.75 0 0 0-1.744 1.606L10.25 5h3.5A1.75 1.75 0 0 0 12 3.25Z" fill="#fff"/></svg>
                        <span>Remove from Playlist</span>
                    </div>   
                `);
            }
        }

        $("#threeBarMenu").css("display", "grid");
        $("#selectPlaylistMenu").css("display", "none")
        $(".overlay").css("display", "flex")
        $("#threeBarMenu .playIndividualSong").attr("songid", songID)
        $("#threeBarMenu .addToQueueBtn").attr("songid", songID)
        $("#threeBarMenu .addToPlaylistBtn").attr("songid", songID)
    }); 
    
    $(document).on("click", "#closeOverlay", function (e) { 
        $(".overlay").css("display", "none")
        $("#threeBarMenu .playIndividualSong").removeAttr("songid")
        $("#threeBarMenu .addToQueueBtn").removeAttr("songid")
        $("#threeBarMenu .addToPlaylistBtn").removeAttr("songid")
        $(".addToPlaylistFromMenu").removeAttr("songid")
        $(".addToPlaylistFromMenu").removeAttr("albumid")
    });

    $(document).on("click", "#threeBarMenu .addToPlaylistBtn", function (e) { 
        const songID = $(this).attr("songid");

        $.ajax({
            url: "./process/getAllPlaylist.php",
            type: 'get',
            dataType: 'JSON',
            success: function (result) {
                $status = result[0].status
                if ($status) {
                    $("#threeBarMenu").css("display", "none")
                    $("#selectPlaylistMenu").css("display", "grid");
                    $numOfPlaylist = result.length

                    $('#selectPlaylistMenu .allPlaylist').empty();

                    for (var i = 0; i < $numOfPlaylist; i++) {
                        $playlistID = result[i].playlistID         
                        $playlistTitle = result[i].playlistTitle
                        $playlistCover = result[i].playlistCover

                        $('#selectPlaylistMenu .allPlaylist').append(`
                            <div class="item addToPlaylistFromMenu" songid='${songID}' playlistid = '${$playlistID}'>
                                <img src='${$playlistCover}'>
                                <span>${$playlistTitle}</span>
                            </div>   
                        `);
                    }
                }

                else {
                    $playlistTitle = result[0].playlistTitle;
                    alert($playlistTitle)
                }
            }
        })
    }); 

    $(document).on("click", ".addToPlaylistFromMenu", function (e) { 
        const songID = $(this).attr("songid");
        const playlistID = $(this).attr("playlistid");

        $.ajax({
            url: "./process/addSongToPlaylist.php",
            type: 'post',
            data: { songID: songID, playlistID: playlistID },
            dataType: 'JSON',
            success: function (result) {
                $status = result[0].status
                $title = result[0].title

                if ($status) {
                    $(".overlay").css("display", "none")
                    $("#threeBarMenu .playIndividualSong").removeAttr("songid")
                    $("#threeBarMenu .addToQueueBtn").removeAttr("songid")
                    $("#threeBarMenu .addToPlaylistBtn").removeAttr("songid")
                    alert("Song added to playlist")

                    refreshPage();
                }

                else {
                    alert($title)
                }
            }
        })
    });

    $(document).on("click", ".removeSongFromPlaylist", function (e) { 
        const playlistID = $(this).attr("playlistid")
        const playlistSongID = $(this).attr("playlistsongid")

        $.ajax({
            url: "./process/removeSongFromPlaylist.php",
            type: 'post',
            data: { playlistSongID: playlistSongID, playlistID: playlistID },
            dataType: 'JSON',
            success: function (result) {
                $status = result[0].status
                $title = result[0].title

                if ($status) {
                    $(".overlay").css("display", "none")
                    $("#threeBarMenu .playIndividualSong").removeAttr("songid")
                    $("#threeBarMenu .addToQueueBtn").removeAttr("songid")
                    $("#threeBarMenu .addToPlaylistBtn").removeAttr("songid")

                    refreshPage();
                }

                else {
                    alert($title)
                }
            }
        })
    });






    // USER PLAYLIST
    window.userPlaylist = [];
    window.shufflePlaylist = [];
    




    

    // CHANGE THE CSS
    const player = $(".mediaPlayerMainDiv").outerHeight();

    if ($(window).outerWidth() < 768) {
        $(".pageContent").css("padding-bottom", "calc(" + player + "px)")
        $(".pageContent").css("height", "unset")
    }

    else {
        $(".pageContent").css("height", "calc(100vh - " + player + "px)")
    }


    

    $(window).resize(function () { 
        const player = $(".mediaPlayerMainDiv").outerHeight(); 
        
        if ($(window).outerWidth() < 768) {
            $(".pageContent").css("padding-bottom", "calc(" + player + "px)")
            $(".pageContent").css("height", "unset")
        }
    
        else {
            $(".pageContent").css("height", "calc(100vh - " + player + "px)")
        }
    });
});
