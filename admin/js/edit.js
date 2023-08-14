$(document).ready(function () {

    $("#selectAlbum").change(function (e) { 
        $albumID = $('option:selected', this).attr("id");
        window.location = "./edit_album.php?id=" + $albumID
    });

    $("#selectSong").change(function (e) { 
        $songID = $('option:selected', this).attr("id");
        window.location = "./edit_song.php?id=" + $songID
    });


    $(".songURL").change("change", function (e) { 
        const songURL = $(this).val();
        getAudioDuration(songURL);
    });


    







    function getAudioDuration(src) {
        var audio = document.createElement('audio');
        audio.src = src;

        $(".songDuration").val("")
        $(".songDuration").attr("readonly", "")
        $("#updateSongBtn").attr("disabled", "");
        $(".songDuration").attr("placeholder", "Retrieving duration...")

        audio.addEventListener('loadedmetadata', function(){
            var duration = audio.duration;
            var minutes = "0" + Math.floor(duration / 60);
            var seconds = "0" +  Math.floor(duration - minutes * 60);
            var final = parseInt(minutes.substr(-2)) + ":" + seconds.substr(-2);

            $(".songDuration").val(final)
            $("#updateSongBtn").removeAttr("disabled");
            $(".songDuration").removeAttr("readonly")
        },false);
    }


    function isImage(url) {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
    }
});