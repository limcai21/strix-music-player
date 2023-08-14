$(document).ready(function () {

    $("#selectAlbum").change(function (e) { 
        $albumID = $('option:selected', this).attr("id");
        window.location = "./delete_album.php?id=" + $albumID
    });

    $("#selectSong").change(function (e) { 
        $songID = $('option:selected', this).attr("id");
        const search = new URLSearchParams(window.location.search);
        let checkAlbumID = search.has('album');

        if (checkAlbumID) {
            const albumID = search.get("album");
            window.location = "./delete_song.php?album=" + albumID + "&id=" + $songID
        }

        else {
            window.location = "./delete_song.php?id=" + $songID
        }
    });

    $("#deleteAlbumBtn").click(function (e) { 
        if (confirm("Are you sure you want to delete this album?")) {
            const albumID = new URLSearchParams(window.location.search).get("id")

            $.ajax({
                type: "POST",
                url: "./process/delete_album.php",
                data: {albumID: albumID},
                dataType: "json",
                success: function(result){
                    $status = result[0].status

                    if ($status) {
                        window.location = './delete_album?success=493262';
                    }

                    else {
                        window.location = './delete_album?error=921341';
                    }
                },
            });
        }
    });

    $("#deleteSongBtn").click(function (e) { 
        if (confirm("Are you sure you want to delete this song?")) {
            const songID = new URLSearchParams(window.location.search).get("id")

            $.ajax({
                type: "POST",
                url: "./process/delete_song.php",
                data: {songID: songID},
                dataType: "json",
                success: function(result){
                    $status = result[0].status

                    if ($status) {
                        window.location = './delete_song?success=761171';
                    }

                    else {
                        window.location = './delete_song?error=921341';
                    }
                },
            });
        }
    });
    
});


