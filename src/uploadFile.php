<?php
header("content-type: text/plain");

error_reporting(E_ALL ^ E_NOTICE);

$resize = filter_input(INPUT_POST, "resize", FILTER_SANITIZE_STRING);
$resize = (boolean) $resize;
//flag to indicate whether we would have saved the file...
$file_ok = false;
$preliminary_check = true;

//Preliminary check of basic PHP file handling
if ($_FILES["inageFile"]["error"] != 0) {
    switch ($_FILES["inageFile"]["error"]) {
        case UPLOAD_ERR_INI_SIZE: //1
            error_log("File is too big. uploaded: " . $_FILES["inageFile"]["size"] . ")");
            $preliminary_check = false;
            break;
        case UPLOAD_ERR_FORM_SIZE: //2
            error_log("Form is too big, " . $_FILES["inageFile"]["size"] . ")");
            $preliminary_check = false;
            break;
        case UPLOAD_ERR_PARTIAL: //3
            error_log("Partial Error");
            $preliminary_check = false;
            break;
        case UPLOAD_ERR_NO_FILE: //4
            error_log("No file uploaded");
            $preliminary_check = false;
            break;
        default:
            error_log("Unknown error " . $_FILES["inageFile"]["error"]);
            $preliminary_check = false;
            break;
    }
}

//if no errors, continue
if ($preliminary_check) {
    echo "PASSED preliminary check\n";
    if (substr($_FILES["inageFile"]["type"], 0, 6) == "image/") {
        $im["filename"] = str_replace(" ", "-", $_FILES["inageFile"]["name"]); //replace spaces with hyphens
        $im["size"] = $_FILES["inageFile"]["size"];
        list($im["width"], $im["height"], $im["type"], $tempattr) = getimagesize($_FILES["inageFile"]["tmp_name"]);
        $im["type"] = $_FILES["inageFile"]["type"];
        if (!file_exists($uploadfile)) {
            error_log($_FILES["inageFile"]["name"] . " will not overwrite existing Logo. Would be saved.");
            //if (move_uploaded_file($_FILES["inageFile"]["tmp_name"], $uploadfile)) {
                error_log($_FILES["inageFile"]["name"] . " has been confirmed to be an image and would have been saved on the server.");
                $file_ok = true;
            //} else {
            //    error_log("Error in file upload. " . $_FILES["inageFile"]["tmp_name"] . " cannot be moved to $uploadfile");
            //}
        } else {
            error_log("filename exists already");
        }
    } else {
        error_log("Mime/type is not an image - received: " . $_FILES["inageFile"]["type"]);
    }

    if($file_ok) {
        echo "FILE WOULD HAVE BEEN UPLOADED AND SAVED";
    }else {
        echo "FAILED image check";
    }
} else {
    echo "FAILED preliminary check";
}


//var_dump($_FILES["inageFile"]);