$(document).ready(function () {
    $(document).on('change paste keyup input', "#searchbar", function(){
        const searchValue = $(this).val();
        
        if (searchValue != "") {
            search(searchValue)
        }

        else {
            $(".albumResultList").html("")
            $(".songResultList").html("")
            $(".playlistResultList").html("")
            $(".searchResultSection").css("display", "none");
            window.history.pushState(null, null, "./search");
        }
    });

    $(document).on('mouseout', "#searchbar", function(){
        if ($(this).is( ":focus" )) {
            $(this).blur();
        }
    });


    
    function search(searchValue) {
        var loadURL = "./process/getSongDataBySearch.php?query=" + searchValue

        // SONG
        window.history.pushState(null, null, "./search?query=" + searchValue);
        $.ajax({
            url: loadURL,
            type: 'get',
            dataType: 'JSON',
            success: function(result) {
                const amountOfResult = result.length
                $(".songResultList").html("")

                const status = result[0].status

                if (status) {
                    $(".searchResultSection").css("display", "grid");

                    for (var i = 0; i < amountOfResult; i++){
                        const songTitle = result[i].songTitle;
                        const songArtist = result[i].songArtist;
                        const songExplicit = result[i].songExplicit;
                        const albumCover = result[i].albumCover;
                        const songURL = result[i].songURL;
                        const songID = result[i].songID
                        const albumID = result[i].albumID

                        $(".songResultList").append(`

                        <div class='individualSongSearch individualSearch' albumid=${albumID}>
                            <div class='left'>
                                <img src=${albumCover} alt='${songTitle} Album Cover' onerror="this.src='../img/albumCover.png'">
                            </div>
                            <div class='right'>
                                <div class='titleAndArtist'>
                                    <label class='title'>${songTitle}</label>
                                    <span class='artist'>${songArtist}</span>
                                </div>
                                <div class="actionBtn" bis_skin_checked="1">
                                    <button class="songPlayBtn" songid="${songID}">
                                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        `);
                    }
                }

                else {
                    const songTitle = result[0].songTitle;
                    $(".searchResultSection").css("display", "grid");
                    $(".songResultList").html("<span>" + songTitle + "</span>")
                }
            }
        })


        // ALBUM
        var loadURL = "./process/getAlbumDataBySearch.php?query=" + searchValue
        $.ajax({
            url: loadURL,
            type: 'get',
            dataType: 'JSON',
            success: function(result) {
                const amountOfResult = result.length
                $(".albumResultList").html("")

                const status = result[0].status

                if (status) {
                    for (var i = 0; i < amountOfResult; i++){
                        const albumTitle = result[i].albumTitle;
                        const albumArtist = result[i].albumArtist;
                        const albumCover = result[i].albumCover;
                        const albumID = result[i].albumID;
                        const actionBtn = result[i].actionBtn;

                        if (actionBtn) {
                            $(".albumResultList").append(`
                                <div class='individualAlbumSearch individualSearch' albumid=${albumID}>
                                    <div class='left'>
                                        <img src=${albumCover} alt='${albumTitle} Album Cover' onerror="this.src='../img/albumCover.png'">
                                    </div>
                                    <div class='right'>
                                        <div class='titleAndArtist'>
                                            <label class='title'>${albumTitle}</label>
                                            <span class='artist'>${albumArtist}</span>
                                        </div>
                                        <div class="actionBtn" bis_skin_checked="1">
                                            <button class="albumPlayBtn" albumid=${albumID}>
                                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `);
                        }

                        else {
                            $(".albumResultList").append(`
                                <div class='individualAlbumSearch individualSearch' albumid=${albumID}>
                                    <div class='left'>
                                        <img src=${albumCover} alt='' srcset=''>
                                    </div>
                                    <div class='right'>
                                        <div class='titleAndArtist'>
                                            <label class='title'>${albumTitle}</label>
                                            <span class='artist'>${albumArtist}</span>
                                        </div>
                                    </div>
                                </div>
                            `);
                        }
                    }
                }

                else {
                    const albumTitle = result[0].albumTitle;
                    $(".searchResultSection").css("display", "grid");
                    $(".albumResultList").html("<span class='noResultSearch'>" + albumTitle + "</span>")
                }
            }
        })

        // PLAYLIST
        var loadURL = "./process/getPlaylistDataBySearch.php?query=" + searchValue
        $.ajax({
            url: loadURL,
            type: 'get',
            dataType: 'JSON',
            success: function(result) {
                const amountOfResult = result.length
                $(".playlistResultList").html("")

                const status = result[0].status

                if (status) {
                    for (var i = 0; i < amountOfResult; i++){
                        const playlistID = result[i].playlistID;
                        const playlistTitle = result[i].playlistTitle;
                        var playlistCover = result[i].playlistCover;
                        const playlistUser = result[i].playlistUser;
                        const playButton = result[i].playButton;

                        if (playButton) {
                            $(".playlistResultList").append(`

                            <div class='individualPlaylistSearch individualSearch' playlistid=${playlistID}>
                                <div class='left'>
                                    <img src=${playlistCover} alt='${playlistTitle} Playlist Cover' onerror="this.src='../img/newPlaylistCover.png'">
                                </div>
                                <div class='right'>
                                    <div class='titleAndArtist'>
                                        <label class='title'>${playlistTitle}</label>
                                        <span class='artist'>${playlistUser}</span>
                                    </div>
                                    <div class="actionBtn" bis_skin_checked="1">
                                        <button class="playlistPlayBtn" playlistid=${playlistID}>
                                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.274c0-1.707 1.826-2.792 3.325-1.977l12.362 6.726c1.566.853 1.566 3.101 0 3.953L8.325 20.702C6.826 21.518 5 20.432 5 18.726V5.274Z" fill="#fff"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            `);
                        }

                        else {
                            $(".playlistResultList").append(`

                            <div class='individualPlaylistSearch individualSearch' playlistid=${playlistID}>
                                <div class='left'>
                                    <img src=${playlistCover} alt='${playlistTitle} Playlist Cover' onerror="this.src='../img/newPlaylistCover.png'">
                                </div>
                                <div class='right'>
                                    <div class='titleAndArtist'>
                                        <label class='title'>${playlistTitle}</label>
                                        <span class='artist'>${playlistUser}</span>
                                    </div>
                                </div>
                            </div>
                            `);
                        }
                    }
                }

                else {
                    const playlistTitle = result[0].playlistTitle;
                    $(".searchResultSection").css("display", "grid");
                    $(".playlistResultList").html("<span class='noResultSearch'>" + playlistTitle + "</span>")
                }
            }
        })
    }


    // ON LOAD
    window.searchOnLoad = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchValue = urlParams.get('query');

        
        if (searchValue != "" && searchValue != null) {
            search(searchValue)
        }

        else {
            $(".albumResultList").html("")
            $(".songResultList").html("")
            $(".playlistResultList").html("")
            $(".searchResultSection").css("display", "none");
            window.history.pushState(null, null, "./search");
        }
    }

    if ((window.location.href.split("/").pop()).includes("search")) {
        searchOnLoad();
    }
});
