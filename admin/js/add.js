$(document).ready(function () {

    $("#albumCover").keyup(function (e) { 
        const albumArt = $(this).val();
        if (isImage(albumArt)) {
            $('#addAlbumMainDiv .right .albumCoverDisplay').css('background-image', "url('" + albumArt + "')");
            $('#addAlbumMainDiv .right .albumCoverDisplay').html("");
        }

        else {
            $('#addAlbumMainDiv .right .albumCoverDisplay').html("Invalid Album Art");
            $('#addAlbumMainDiv .right .albumCoverDisplay').css('background-image', "none");
        }
    });

    $("#selectSong").change(function (e) { 
        $albumID = $('option:selected', this).attr("id");
        window.location = "./add_song.php?id=" + $albumID
    });
    
    $(".songURL").on("change", function (e) { 
        const songURL = $(this).val();
        getAudioDuration(songURL);
    });






    function isImage(url) {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
    }


    function getAudioDuration(src) {
        var audio = document.createElement('audio');
        audio.src = src;

        $(".songDuration").val("")
        $("#addSongBtn").attr("disabled", "");
        $(".songDuration").attr("placeholder", "Retrieving duration...")

        audio.addEventListener('loadedmetadata', function(){
            var duration = audio.duration;
            var minutes = "0" + Math.floor(duration / 60);
            var seconds = "0" +  Math.floor(duration - minutes * 60);
            var final = parseInt(minutes.substr(-2)) + ":" + seconds.substr(-2);

            $(".songDuration").val(final)
            $("#addSongBtn").removeAttr("disabled");
        },false);
    }
});


