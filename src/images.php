<!DOCTYPE html>
<html>

<head>
    <title>
        Image Generator
    </title>
    <style>
        .container {
            display: flex;
            /* or inline-flex */
            flex-direction: row;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <h1>Image Generator</h1>
    <div class="container">
        <?php
        $file_types = ["png", "jpg", "gif", "bmp", "webp"];
    foreach($file_types as $ftype){
        ?>
        <figure>
            <img src="imageGen.php?fileType=<?=$ftype?>" alt="<?=$ftype?>">
            <figcaption><?=$ftype?></figcaption>
        </figure>
        <?php
    }

?>

    </div>
</body>

</html>