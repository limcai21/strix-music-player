$(document).ready(function () {

    // ALBUM
    $(document).on("click", ".albumPlayBtn", function (e) {
        const albumID = $(this).attr("albumid");
        e.stopPropagation();

        $.ajax({
            url: "./process/getSongID.php?albumID=" + albumID,
            type: 'get',
            dataType: 'JSON',
            success: function (result) {

                // JSON TRY
                var array = [];
                var len = result.length;

                for (var i = 0; i < len; i++){
                    var songID = result[i].songID;
                    array.push(songID);
                }

                userPlaylist = array

                if (userPlaylist[0] == undefined) {
                    audio.pause();
                    userPlaylist = [];
                    audio.src = '';
                    
                    $(".songInfo .songData .songNameAndArtist .title").text("Something went wrong");
                    $(".songInfo .songData .songNameAndArtist .artist").css("display", "block");
                    $(".songInfo .songData .songNameAndArtist .artist").text("Please try again");
                    $("#playerAlbumArt").css("width", "auto");
                    $("#playerAlbumArt").attr("src", 'https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png');
                    $(".mediaPlayerMainDiv").css("background-image", 'url(https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png)');
                    $("#progressBar").attr("disabled", "");
                    $(".mediaPlayer ").addClass("backgroundBlur")
                    $(".progressSection").css("display", "none")
                    $(".mediaSection").css("display", "none")
                    $(".volumeSection").css("display", "none")
                    $(".otherIcons").css("display", "none")
                }

                else {
                    if (shuffleState) {
                        localStorage.setItem('oldPlaylist', JSON.stringify(userPlaylist));
                        shuffleState = true
                        $("#shuffleBtn").addClass("hoverBtn");
                        $("#shuffleBtn").attr("title", "Shuffle On")
                        shufflePlaylist = userPlaylist.sort(() => Math.random() - 0.5)
                        userPlaylist = shufflePlaylist
                    }

                    changeSong(userPlaylist[0]);
                }
            }
        })
    });

    $(document).on("click", ".songCard", function(e) {
        const albumID = $(this).attr("albumID");
        const loadURL = "album.php?id=" + albumID

        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, loadURL);
             }
        });
    })

    $(document).on("click", ".individualAlbumSearch ", function(e) {
        const albumID = $(this).attr("albumID");
        const loadURL = "album.php?id=" + albumID

        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, loadURL);
                window.scrollTo(0, 0);
             }
        });
    })



    // PLAYLIST
    $(document).on("click", ".playlistCard", function(e) {
        const playlistID = $(this).attr("playlistid");
        const loadURL = "playlist.php?id=" + playlistID

        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, loadURL);
                window.oldTitleValue = $(data).find("#playlistTitle").text();
             }
        });
    })

    $(document).on("click", ".playlistPlayBtn", function (e) {
        const playlistID = $(this).attr("playlistid");
        e.stopPropagation();

        $.ajax({
            url: "./process/getPlaylistSongID.php?playlistID=" + playlistID,
            type: 'get',
            dataType: 'JSON',
            success: function (result) {

                // JSON TRY
                var array = [];
                var len = result.length;

                for (var i = 0; i < len; i++){
                    var songID = result[i].songID;
                    array.push(songID);
                }

                userPlaylist = array

                if (userPlaylist[0] == undefined) {
                    audio.pause();
                    userPlaylist = [];
                    audio.src = '';
                    
                    $(".songInfo .songData .songNameAndArtist .title").text("Something went wrong");
                    $(".songInfo .songData .songNameAndArtist .artist").css("display", "block");
                    $(".songInfo .songData .songNameAndArtist .artist").text("Please try again");
                    $("#playerAlbumArt").css("width", "auto");
                    $("#playerAlbumArt").attr("src", 'https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png');
                    $(".mediaPlayerMainDiv").css("background-image", 'url(https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png)');
                    $("#progressBar").attr("disabled", "");
                    $(".mediaPlayer ").addClass("backgroundBlur")
                    $(".progressSection").css("display", "none")
                    $(".mediaSection").css("display", "none")
                    $(".volumeSection").css("display", "none")
                    $(".otherIcons").css("display", "none")
                }

                else {
                    if (shuffleState) {
                        localStorage.setItem('oldPlaylist', JSON.stringify(userPlaylist));
                        shuffleState = true
                        $("#shuffleBtn").addClass("hoverBtn");
                        $("#shuffleBtn").attr("title", "Shuffle On")
                        shufflePlaylist = userPlaylist.sort(() => Math.random() - 0.5)
                        userPlaylist = shufflePlaylist
                    }

                    changeSong(userPlaylist[0]);
                }
            }
        })
    });

    $(document).on("click", ".individualPlaylistSearch", function(e) {
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






    // INDIVIDUAL SONG
    $(document).on("click", ".playIndividualSong", function(e) {
        e.stopPropagation();

        const songID = $(this).attr("songid");
        const loadURL = "./process/getSongInfo.php?songID=" + songID

        $.ajax({
            url: loadURL,
            type: 'get',
            dataType: 'JSON',
            success: function(result) {

                // JSON TRY
                var array = [];
                var len = result.length;

                for (var i = 0; i < len; i++){
                    var songID = result[i].songID;
                    array.push(songID);
                }

                userPlaylist = array

                if (userPlaylist[0] == undefined) {
                    audio.pause();
                    userPlaylist = [];
                    audio.src = '';
                    
                    $(".songInfo .songData .songNameAndArtist .title").text("Something went wrong");
                    $(".songInfo .songData .songNameAndArtist .artist").css("display", "block");
                    $(".songInfo .songData .songNameAndArtist .artist").text("Please try again");
                    $("#playerAlbumArt").css("width", "auto");
                    $("#playerAlbumArt").attr("src", 'https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png');
                    $(".mediaPlayerMainDiv").css("background-image", 'url(https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png)');
                    $("#progressBar").attr("disabled", "");
                    $(".mediaPlayer ").addClass("backgroundBlur")
                    $(".progressSection").css("display", "none")
                    $(".mediaSection").css("display", "none")
                    $(".volumeSection").css("display", "none")
                    $(".otherIcons").css("display", "none")
                }

                else {
                    if (shuffleState) {
                        localStorage.setItem('oldPlaylist', JSON.stringify(userPlaylist));
                        shuffleState = true
                        $("#shuffleBtn").addClass("hoverBtn");
                        $("#shuffleBtn").attr("title", "Shuffle On")
                        shufflePlaylist = userPlaylist.sort(() => Math.random() - 0.5)
                        userPlaylist = shufflePlaylist
                    }

                    changeSong(userPlaylist[0]);
                }
             }
        });
    })

    $(document).on("click", ".songPlayBtn", function(e) {
        e.stopPropagation();

        const songID = $(this).attr("songid");
        const loadURL = "./process/getSongInfo.php?songID=" + songID

        $.ajax({
            url: loadURL,
            type: 'get',
            dataType: 'JSON',
            success: function(result) {

                // JSON TRY
                var array = [];
                var len = result.length;

                for (var i = 0; i < len; i++){
                    var songID = result[i].songID;
                    array.push(songID);
                }

                userPlaylist = array

                if (userPlaylist[0] == undefined) {
                    audio.pause();
                    userPlaylist = [];
                    audio.src = '';
                    
                    $(".songInfo .songData .songNameAndArtist .title").text("Something went wrong");
                    $(".songInfo .songData .songNameAndArtist .artist").css("display", "block");
                    $(".songInfo .songData .songNameAndArtist .artist").text("Please try again");
                    $("#playerAlbumArt").css("width", "auto");
                    $("#playerAlbumArt").attr("src", 'https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png');
                    $(".mediaPlayerMainDiv").css("background-image", 'url(https://raw.githubusercontent.com/limcai21/project-music/main/img/lost.png)');
                    $("#progressBar").attr("disabled", "");
                    $(".mediaPlayer ").addClass("backgroundBlur")
                    $(".progressSection").css("display", "none")
                    $(".mediaSection").css("display", "none")
                    $(".volumeSection").css("display", "none")
                    $(".otherIcons").css("display", "none")
                }

                else {
                    if (shuffleState) {
                        localStorage.setItem('oldPlaylist', JSON.stringify(userPlaylist));
                        shuffleState = true
                        $("#shuffleBtn").addClass("hoverBtn");
                        $("#shuffleBtn").attr("title", "Shuffle On")
                        shufflePlaylist = userPlaylist.sort(() => Math.random() - 0.5)
                        userPlaylist = shufflePlaylist
                    }

                    changeSong(userPlaylist[0]);
                }
             }
        });
    })

    $(document).on("click", ".individualSongSearch ", function(e) {
        const albumID = $(this).attr("albumID");
        const loadURL = "album.php?id=" + albumID

        $.ajax({
            url: loadURL,
            success: function(data) {
                const ajaxData = $(data).find("#main").html()
                $("#main").html(ajaxData);
                window.history.pushState(null, null, loadURL);
                window.scrollTo(0, 0);
             }
        });
    })








    // SHOW PLAY BUTTON ON INDIVUAL TRACK AND HIDE TRACK NO VIA VERSU
    $(document).on('mouseover', '.indivualSongList', function(e) {
        if ($(window).outerWidth() > 768) {
            $(this).find(".left .trackNo").css("display", "none");
            $(this).find(".left .playIndividualSong").css("display", "block");
        }

        else {
            $(this).find(".left .trackNo").css("display", "block");
            $(this).find(".left .playIndividualSong").css("display", "none");
        }

    }).on('mouseout', '.indivualSongList', function(e) {
        if ($(window).outerWidth() > 768) {
            $(this).find(".left .trackNo").css("display", "block");
            $(this).find(".left .playIndividualSong").css("display", "none");
        }
    });
});

