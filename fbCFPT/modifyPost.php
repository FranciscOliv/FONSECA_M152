<?php
require_once dirname(__FILE__) . "/inc/function.php";

if (!isset($_GET['POSTID']) or $_GET['POSTID'] == "") {
    echo "dab";
} else {
    $postId = $_GET['POSTID'];
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/dropdownAnimation.css">

    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <title>Main Page</title>
</head>

<body>
    <!-- NAVBAR test -->
    <?php
    include_once "inc/nav.inc.php";
    ?>
    <!-- END NAVBAR -->

    <!-- MAIN -->
    <main class="container mt-4">
        <div class="card">
            <div class="card-header">
                Modifier un post
            </div>
            <div class="card-body">
                <div class="row w-100">
                    <?php
                    if (PostExist($postId)) {
                        $mediaData = GetMediaByPostId($postId);
                        foreach ($mediaData as $media) {
                            if (strpos($media['typeMedia'], 'image/') !== false) {
                                echo <<<EOT
                                <div class="col-sm-auto">
                                    <img src="/upload/{$media['nomMedia']}" class="rounded float-left ml-2 mt-2" alt="Missing Image" style="max-width:25vh;">                           
                                    </div>
                                EOT;
                            }
                        }
                    } else {
                        echo '<h5 class="card-title">This post doens\'t exist</h5>';
                    }
                    ?>
                </div>




                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </main>
    <!-- END MAIn -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>