<?php 
    include_once("../dbInfo.php");

    if (isset($_POST['playlistID'])) {
        if ($_POST['playlistID'] == '') {
            header("location: ../index.php");
        }

        else {
            $playlistID = $_POST['playlistID'];
            $playlistPrivate = $_POST['playlistPrivate'];
        }
    }

    else {
        header("location: ../index.php");
    }

    $lockSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2a4 4 0 0 1 4 4v2h2.5A1.5 1.5 0 0 1 20 9.5v11a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 20.5v-11A1.5 1.5 0 0 1 5.5 8H8V6a4 4 0 0 1 4-4Zm0 11.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3ZM12 4a2 2 0 0 0-2 2v2h4V6a2 2 0 0 0-2-2Z" fill="#fff"/></svg>';
    $unlockSVG = '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.001a4 4 0 0 1 3.771 2.666 1 1 0 0 1-1.84.774l-.045-.107a2 2 0 0 0-3.88.517L10.002 6v1.999h7.749a2.25 2.25 0 0 1 2.245 2.097l.005.154v9.496a2.25 2.25 0 0 1-2.096 2.245l-.154.005H6.25A2.25 2.25 0 0 1 4.005 19.9L4 19.746V10.25a2.25 2.25 0 0 1 2.096-2.245L6.25 8l1.751-.001v-2A3.999 3.999 0 0 1 12 2.002Zm0 11.498a1.499 1.499 0 1 0 0 2.998 1.499 1.499 0 0 0 0-2.998Z" fill="#fff"/></svg>';

    $sqlStatement = "UPDATE `playlist` SET `playlistPrivate`='$playlistPrivate' WHERE playlistID = '$playlistID'";
    $returnJSON = array();

    if ($mysqli -> query($sqlStatement)) {

        // GET NEW VALUE 
        $sqlStatement = "SELECT playlistPrivate FROM `playlist` WHERE playlistID = '$playlistID'";
        
        if ($result = $mysqli -> query($sqlStatement)) {
            $record = $result -> fetch_row();

            if ($record[0] == '1') {
                $returnText = 'Private';
                $returnSVG = $lockSVG;
            }

            else {
                $returnText = 'Public';
                $returnSVG = $unlockSVG;
            }
            
            $returnJSON[] = array(
                "playlistStatus" => $returnText,
                "playlistStatusNo" => $record[0],
                "playlistStatusSVG" => $returnSVG,
                "status" => true
            );
        }

        else {
            $returnJSON[] = array(
                "status" => false
            );
        }

        $result -> free_result();
        $mysqli -> close();

        echo json_encode($returnJSON, JSON_PRETTY_PRINT);
    }
?>