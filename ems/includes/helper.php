<?php 
function response($data) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}


function uploadImage($file, $upload_file_name, $target_dir = "./") {
    // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check == false) {
        return json_encode(["result"=>false, "msg"=>"File is not an image"]);
    }  

    // Check if file already exists
    // if (file_exists($target_file)) {
    //   echo "Sorry, file already exists.";
    //   $uploadOk = 0;
    // }

    // Check file size
    // if ($_FILES["fileToUpload"]["size"] > 500000) {
    //   echo "Sorry, your file is too large.";
    //   $uploadOk = 0;
    // }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
     return json_encode(["result"=>false, "msg"=>"Sorry, only JPG, JPEG, PNG & GIF files are allowed"]);
    }


    $date = date('m/d/Yh:i:sa', time());
    $rand=rand(10000,99999);
    $encname=$date.$rand;
    $bannername=md5($encname).'.'.$imageFileType;
    $target_file = $target_dir . $bannername;
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        return json_encode(["result"=>true, "msg"=>"The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded"]);
    } else {
        return json_encode(["result"=>false, "msg"=>"Sorry, there was an error uploading your file"]);
    }
}



function timeAgo($timestamp) {
    $currentTimestamp = time();
    $timestamp = strtotime($timestamp);

    $timeDiff = $currentTimestamp - $timestamp;

    if ($timeDiff < 60) {
        $result = $timeDiff . " second" . ($timeDiff === 1 ? "" : "s") . " ago";
    } elseif ($timeDiff < 3600) {
        $result = floor($timeDiff / 60) . " minute" . (floor($timeDiff / 60) === 1 ? "" : "s") . " ago";
    } elseif ($timeDiff < 86400) {
        $result = floor($timeDiff / 3600) . " hour" . (floor($timeDiff / 3600) === 1 ? "" : "s") . " ago";
    } elseif ($timeDiff < 604800) {
        $result = floor($timeDiff / 86400) . " day" . (floor($timeDiff / 86400) === 1 ? "" : "s") . " ago";
    } else {
        $result = floor($timeDiff / 31536000) . " year" . (floor($timeDiff / 31536000) === 1 ? "" : "s") . " ago";
    }

    return $result;
}

