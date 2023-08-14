$(document).ready(function () {
    window.oldTitleValue = $("#playlistTitle").text();

    // WHEN CLICK ON PUBLIC / PRIVATE BTN
    $(document).on("click", "#playlistLock", function (e) {
        $currentPlaylistStatus = $(this).attr('playliststatus');
        $playlistID = $(this).attr('playlistid');

        if ($currentPlaylistStatus == '1') {
            $newStatus = 0;
        }

        else {
            $newStatus = 1;
        }


        // set to public
        $.ajax({
            url: "./process/changePlaylistPrivateStatus.php",
            type: 'post',
            data: { playlistID: $playlistID, playlistPrivate: $newStatus },
            dataType: 'JSON',
            success: function (result) {
                $newPlaylistStatus = result[0].playlistStatus
                $newPlaylistStatusNo = result[0].playlistStatusNo
                $newPlaylistStatusSVG = result[0].playlistStatusSVG
                $status = result[0].status

                if ($status) {
                    $("#playlistLock").attr('playliststatus', $newPlaylistStatusNo);
                    $("#playlistLock").html($newPlaylistStatusSVG + "<span>" + $newPlaylistStatus + "</span>");
                }

                else {
                    alert("Something went wrong, try again later");
                }
            }
        })
    });


    // WHEN CLICK ON DELETE BTN
    $(document).on("click", "#playlistDelete", function (e) {
        $playlistTitle = $(".playlistContent .header .headerContent .right .top h1").text();
        if (confirm("Are your sure you want to delete '" + $playlistTitle + "' ? \nThis action can't be undo")) {
            $playlistID = $(this).attr('playlistid');

            $.ajax({
                url: "./process/deletePlaylist.php",
                type: 'post',
                data: { playlistID: $playlistID },
                dataType: 'JSON',
                success: function (result) {
                    $status = result[0].status

                    if ($status) {
                        alert("Playlist deleted successfully");

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
                    }

                    else {
                        alert("Something went wrong, try again later");
                    }
                }
            })
        }
    });



    // UPDATE COVER PIC
    $(document).on("mouseenter", "#playlistCoverArt", function (e) {
        if ($("#playlistTitle").text() != "Favourites") {
            if ($(".playlistOwner").text() == $(".playlistOwner").attr("currentuser")) {
                var span = document.createElement("label");
                var text = document.createTextNode("Choose Cover");
                span.setAttribute("id", "clickToChangeCoverText");
                span.setAttribute("for", "playlistCoverInput");
                span.appendChild(text);
                document.getElementById("playlistCoverArt").appendChild(span);
                $("#clickToChangeCoverText").append("<span class='smallText'>Max Size: 0.4 MB</span>")

                var input = document.createElement("input");
                input.setAttribute("type", "file");
                input.setAttribute("accept", "image/png, image/jpeg, image/jpg");
                input.setAttribute("id", "playlistCoverInput");
                input.setAttribute("name", "playlistCoverInput");
                document.getElementById("playlistCoverArt").appendChild(input);
            }
        }
    });

    $(document).on("mouseleave", "#playlistCoverArt", function (e) {
        if ($("#playlistTitle").text() != "Favourites") {
            if ($(".playlistOwner").text() == $(".playlistOwner").attr("currentuser")) {
                var input = document.getElementById("playlistCoverInput");
                var text = document.getElementById("clickToChangeCoverText");
                input.parentNode.removeChild(input);
                text.parentNode.removeChild(text);
            }
        }
    });

    $(document).on("change", "#playlistCoverInput", function (e) {
        const playlistID = new URLSearchParams(window.location.search).get('id');
        const newCover = document.getElementById('playlistCoverInput').files[0];
        const reader = new FileReader();


        reader.addEventListener("load", function () {
            const fileSize = (newCover.size); 
            const maxFileSize = 0.4 * 1024 * 1024

            if (fileSize >= maxFileSize) {
                $("#newPlaylistTitleError").css("display", "block");
                $("#newPlaylistTitleError").text("File size too big. Make sure its less than 0.4 MB");
            }

            else {
                const base64Result = (reader.result).split(',')[1];
                $.ajax({
                    url: "./process/updatePlaylistCover.php",
                    type: "POST",
                    dataType: 'JSON',
                    data:  { playlistCover: base64Result, playlistID: playlistID },
                    success: function(result) {
                        $status = result[0].status
                        $error = result[0].error
                        console.log($status)

                        if ($status) {
                            $("#newPlaylistTitleError").css("display", "none");
                            refreshPage();
                        }

                        else {
                            console.log($error)
                        }
                    }
                });
            }

        }, false);
        
        

        if (newCover) {
            reader.readAsDataURL(newCover, playlistID);
        }
    });





    // EDIT TITLE 
    $(document).on("click", "#playlistEditName", function (e) {
        $("#newPlaylistTitleError").css("display", "none");
        const input = "<input type='text' name='playlistNewTitle' maxlength=128 id='playlistNewTitle' value='" + oldTitleValue + "' required=''>";
        const saveBtn = "<button title='Save' id='savePlaylistNewTitleBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M6.75 3h-1A2.75 2.75 0 0 0 3 5.75v12.5A2.75 2.75 0 0 0 5.75 21H6v-6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 15v6h.25A2.75 2.75 0 0 0 21 18.25V8.286a3.25 3.25 0 0 0-.952-2.299l-2.035-2.035A3.25 3.25 0 0 0 15.75 3v4.5a2.25 2.25 0 0 1-2.25 2.25H9A2.25 2.25 0 0 1 6.75 7.5V3Z' fill='#fff'/><path d='M14.25 3v4.5a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75V3h6ZM16.5 21v-6a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0-.75.75v6h9Z' fill='#fff'/></svg></button>";
        const cancelBtn = "<button title='Cancel' id='cancelPlaylistNewTitleBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='m4.21 4.387.083-.094a1 1 0 0 1 1.32-.083l.094.083L12 10.585l6.293-6.292a1 1 0 1 1 1.414 1.414L13.415 12l6.292 6.293a1 1 0 0 1 .083 1.32l-.083.094a1 1 0 0 1-1.32.083l-.094-.083L12 13.415l-6.293 6.292a1 1 0 0 1-1.414-1.414L10.585 12 4.293 5.707a1 1 0 0 1-.083-1.32l.083-.094-.083.094Z' fill='#fff'/></svg></button>";
        $("#playlistTitle").html(input + saveBtn + cancelBtn);
    });

    $(document).on("click", "#editPlaylistNewTitleBtn", function (e) { 
        const input = "<input type='text' name='playlistNewTitle' id='playlistNewTitle' value='" + oldTitleValue + "' required=''>";
        const saveBtn = "<button title='Save' id='savePlaylistNewTitleBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M6.75 3h-1A2.75 2.75 0 0 0 3 5.75v12.5A2.75 2.75 0 0 0 5.75 21H6v-6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 15v6h.25A2.75 2.75 0 0 0 21 18.25V8.286a3.25 3.25 0 0 0-.952-2.299l-2.035-2.035A3.25 3.25 0 0 0 15.75 3v4.5a2.25 2.25 0 0 1-2.25 2.25H9A2.25 2.25 0 0 1 6.75 7.5V3Z' fill='#fff'/><path d='M14.25 3v4.5a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75V3h6ZM16.5 21v-6a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0-.75.75v6h9Z' fill='#fff'/></svg></button>";
        const cancelBtn = "<button title='Cancel' id='cancelPlaylistNewTitleBtn'><svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='m4.21 4.387.083-.094a1 1 0 0 1 1.32-.083l.094.083L12 10.585l6.293-6.292a1 1 0 1 1 1.414 1.414L13.415 12l6.292 6.293a1 1 0 0 1 .083 1.32l-.083.094a1 1 0 0 1-1.32.083l-.094-.083L12 13.415l-6.293 6.292a1 1 0 0 1-1.414-1.414L10.585 12 4.293 5.707a1 1 0 0 1-.083-1.32l.083-.094-.083.094Z' fill='#fff'/></svg></button>";
        $("#playlistTitle").html(input + saveBtn + cancelBtn);
    });

    $(document).on("click", "#cancelPlaylistNewTitleBtn", function (e) { 
        $("#playlistTitle").html(oldTitleValue);
        $("#newPlaylistTitleError").css("display", "none");    
    });

    $(document).on("click", "#savePlaylistNewTitleBtn", function (e) { 
        const newPlaylistTitle = $('#playlistNewTitle').val();
        const playlistID = new URLSearchParams(window.location.search).get('id');

        if (oldTitleValue != newPlaylistTitle) {
            if (newPlaylistTitle.length != 0) {
                $.ajax({
                    url: "./process/updatePlaylistTitle.php",
                    type: 'post',
                    data: { playlistTitle: newPlaylistTitle, playlistID: playlistID },
                    dataType: 'JSON',
                    success: function (result) {
                        $status = result[0].status
                        $error = result[0].error

                        if ($status == "1") {
                            // UPDATED
                            oldTitleValue = newPlaylistTitle
                            $("#playlistNewTitle").css("border-color", "darkgray");
                            $("#newPlaylistTitleError").css("display", "none");    
                            $("#emailEditSection").html(newPlaylistTitle);
                            $("#playlistTitle").html(oldTitleValue);
                        }

                        else {
                            if ($status == "2") {
                                // STH WENT WRONG
                                $("#playlistNewTitle").css("border-color", "red");
                                $("#newPlaylistTitleError").css("display", "block");
                                $("#newPlaylistTitleError").text($error);
                            }

                            if ($status == "3") {
                                // PLAYLISTNAME EXIST ALR
                                $("#playlistNewTitle").css("border-color", "red");
                                $("#newPlaylistTitleError").css("display", "block");
                                $("#newPlaylistTitleError").text($error);
                            }
                        }
                    }
                })
            }

            else {
                $("#playlistNewTitle").css("border-color", "red");
                $("#newPlaylistTitleError").css("display", "block");
                $("#newPlaylistTitleError").text("Please your playlist name");
            }
        }

        else {
            $("#playlistNewTitle").css("border-color", "red");
            $("#newPlaylistTitleError").text("Playlist title same as before. Cancel if you don't wish to update")
            $("#newPlaylistTitleError").css("display", "block");
        }
    });
});