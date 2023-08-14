<?php 
    include_once("../dbInfo.php");

    session_start();

    if (!isset($_SESSION['userID'])) {
        header("location: ../index.php");
    }

    if (!isset($_GET['query']) || $_GET['query'] == "") {
        header("location: ../search.php");
    }

    $query = $_GET['query'];
    $sqlStatement = "SELECT song.songTitle, song.songArtist, song.songExplicit, album.albumCover, song.songURL, song.songID, album.albumID FROM `song` RIGHT JOIN album ON album.albumID = song.albumIDFK WHERE songTitle LIKE '%$query%' ORDER BY CASE WHEN songTitle LIKE '$query' THEN 1 WHEN songTitle LIKE '$query%' THEN 2 WHEN songTitle LIKE '%$query' THEN 4 ELSE 3 END LIMIT 6";

    $returnJSON = array();

    if ($result = $mysqli -> query($sqlStatement)) {
        $numOfRow = $result -> num_rows;

        if ($numOfRow > 0) {
            for ($i = 0; $i < $numOfRow; $i++) {
                $record = $result -> fetch_row();
                $songTitle = $record[0];
                $songArtist = $record[1];
                $songExplicit = $record[2];
                $albumCover = $record[3];
                $songURL = $record[4];
                $songID = $record[5];
                $albumID = $record[6];

                $returnJSON[] = array(
                    "songTitle" => $songTitle,
                    "songArtist" => $songArtist,
                    "songExplicit" => $songExplicit,
                    "albumCover" => $albumCover,
                    "songURL" => $songURL,
                    "songID" => $songID,
                    "albumID" => $albumID,
                    "status" => true,
                );
            }
        }

        else {
            $returnJSON[] = array(
                "status" => false,
                "songTitle" => "No result",
                "songArtist" => "Please try again later",
                "songExplicit" => 0,
                "albumCover" => "<svg width='24' height='24' fill='none' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M12 4C9.238 4 7 6.238 7 9a1 1 0 0 0 2 0c0-1.658 1.342-3 3-3s3 1.342 3 3c0 .816-.199 1.294-.438 1.629-.262.365-.625.638-1.128.985l-.116.078c-.447.306-1.023.699-1.469 1.247-.527.648-.849 1.467-.849 2.561v.5a1 1 0 1 0 2 0v-.5c0-.656.178-1.024.4-1.299.257-.314.603-.552 1.114-.903l.053-.037c.496-.34 1.133-.786 1.62-1.468C16.7 11.081 17 10.183 17 9c0-2.762-2.238-5-5-5ZM12 21.25a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5Z' fill='#E84B3C'/></svg>",
            );
        }

        $result -> free_result();
        $mysqli -> close();
        
        echo json_encode($returnJSON, JSON_PRETTY_PRINT);
    }
?>