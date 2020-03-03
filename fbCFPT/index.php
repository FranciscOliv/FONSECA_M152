<?php
require_once dirname(__FILE__) . "/inc/function.php";

$postData =  getAllPost();

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
    <link rel="stylesheet" href="./css/blurredBackground.css">

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
        <div class="row">
            <!--LEFT SECTION-->
            <section class="col-sm-4 mb-2">
                <div class="card rounded-bottom w-100">
                    <img src="/img/header.jpg" class="card-img-top" alt="headerImg">
                    <div class="card-body rounded">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </section>

            <!-- RIGHT SECTION -->
            <section class="col-sm-8 mb-2">

                <!-- POST SECTION -->
                <?php
                if (count($postData) > 0) {
                    foreach ($postData as $post) {
                        $mediaData = getMediaByPostId($post['idPost']);
                ?>
                        <div class="card mb-2 bg-post">
                            <!-- MULTIPLE MEDIA POST -->
                            <?php
                            if (count($mediaData) > 1) {
                            ?>

                                <div id="carouselExampleIndicators" class="carousel slide card-img-top" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <!-- POST IMAGE LIST -->
                                        <?php
                                        for ($i = 0; $i < count($mediaData); $i++) {
                                            if ($i == 0) {
                                                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="active"></li>';
                                            } else {
                                                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '"></li>';
                                            }
                                        }
                                        ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <!-- MULTIPLE IMAGE POST -->
                                        <?php
                                        for ($i = 0; $i < count($mediaData); $i++) {
                                            if ($i == 0) {
                                                echo '<div class="carousel-item active image_blurred_wrapper">';
                                            } else {
                                                echo '<div class="carousel-item image_blurred_wrapper">';
                                            }
                                            echo ' <div class="image_blurred" style="background-image: url(\'/upload/' . $mediaData[$i]['nomMedia'] . '\');"></div>';
                                            echo '<img alt="image" class="imgPost" src="/upload/' . $mediaData[$i]['nomMedia'] . '" /></div>';
                                        }
                                        ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <!-- SINGLE MEDIA POST -->
                                <div class="image_blurred_wrapper">
                                    <div class="image_blurred" style="background-image: url('/upload/<?= $mediaData[0]['nomMedia'] ?>');">
                                    </div>
                                    <img class="card-img-top imgPost" src="/upload/<?= $mediaData[0]['nomMedia'] ?>" alt="Card image cap">
                                </div>
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= $post['commentaire'] ?></h5>
                            </div>
                        </div>

                <?php
                    }
                }
                ?>
                <!-- POST EXAMPLE -->
                <div class="card bg-post">
                    <div class="card-body">
                        <h1>Welcome</h1>
                    </div>

                </div>
            </section>
        </div>



    </main>
    <!-- END MAIn -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $('.carousel').carousel({
            interval: false
        });
    </script>
</body>

</html>