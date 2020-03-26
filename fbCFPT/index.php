<?php
require_once dirname(__FILE__) . "/inc/function.php";

$postData =  GetAllPost();

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
        <div class="row">

            <!--LEFT SECTION-->
            <section id="leftSection" class="col-sm-4 mb-2">
                <div class="card rounded-bottom w-100">
                    <img src="/img/header.jpg" class="card-img-top" alt="headerImg">
                    <div class="card-body rounded">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </section>

            <!-- RIGHT SECTION -->
            <section id="rightSection" class="col-sm-8 mb-2">
                <!-- POST SECTION -->
                <?php
                if (count($postData) > 0) {
                    foreach ($postData as $post) { ?>

                        <!-- CARD START -->
                        <div class="card mb-2 bg-post">

                            <?php
                            //CARD MEDIA
                            $mediaData = GetMediaByPostId($post['idPost']);


                            //MULTIPLE MEDIA POST
                            if (count($mediaData) > 1) {
                                ShowMultiMedia($mediaData);
                            } else {  // SINGLE MEDIA POST                               
                                ShowSingleMedia($mediaData[0]);
                            } ?>

                            <!-- CARD BODY  -->
                            <hr />
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?= $post['commentaire'] ?>
                                    <div class="dropdown float-right">
                                        <button type="button" class="btn p-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="./modifyPost.php?POSTID=<?= $post['idPost'] ?>">Modifier</a>
                                            <a name="<?= $post['idPost'] ?>" class="dropdown-item btnDeletePost" href="#">Supprimer</a>
                                        </div>
                                    </div>
                                </h4>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <?php
                                        if (!empty($post['modificationDate'])) {
                                            echo "Modifié le " . $post['modificationDate'];
                                        } else {
                                            $creationDate = date("d.m.Y", strtotime($post['creationDate']));
                                            $creationHour = date("H:i", strtotime($post['creationDate']));
                                            echo "Posté le " . $creationDate . " à " . $creationHour;
                                        }
                                        ?>

                                    </small>
                                </p>

                            </div>
                        </div>

                <?php
                    }
                }
                ?>

                <div class="card bg-post mb-2">
                    <div class="p-1 bg-audio">
                        <audio class="audioPost w-100" controls>
                            <source src="/upload/marioSound.mp3" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>

                    <hr />
                    <div class="card-body">
                        <h3>Audio Example</h3>
                    </div>
                </div>

                <!-- POST EXAMPLE -->
                <div class="card bg-post mb-2">
                    <video class="videoPost" controls>
                        <source src="/upload/marioVideo.mp4" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                    <hr />
                    <div class="card-body">
                        <h3>Video Example</h3>

                    </div>
                </div>



                <div class="card bg-post mb-2">
                    <div class="image_blurred_wrapper">
                        <div class="image_blurred" style="background-image: url('/upload/marioImage.png');"></div>
                        <img class="card-img-top imgPost" src="/upload/marioImage.png" alt="Card image cap">
                    </div>
                    <hr />
                    <div class="card-body">
                        <h3>Image Example</h3>

                    </div>
                </div>

            </section>
        </div>
    </main>
    <!-- END MAIn -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $('.carousel').carousel({
            interval: false
        });

        $(".btnDeletePost").click(function() {
            deletePost(event);
        });




        function deletePost(e) {
            //alert("Handler for .click() called.");

            var buttonClicked = $(e.target);
            var id = buttonClicked.attr('name');
            var message = "";
            var alertType = "";

            $.ajax({
                method: 'POST', // La méthode utilisée pour passer les données en paramètres
                url: '/inc/deletePost.php', // Le fichier appelé sur le serveur
                data: {
                    'id': id
                }, // Les paramètres
                dataType: 'json', // Le type de retour des données

                // success: Lorsque l'appel ajax est retourné sans erreur
                success: function(data) {
                    switch (data.ReturnCode) {
                        case 0: // C'est tout bon
                            message = data.Message;
                            alertType = "success";
                            buttonClicked.closest('.card').remove();
                            // window.location = "./done.html";
                            break;
                        case 1: // Paramètres invalides
                            // On affiche le message d'erreur
                            // et on le cache automatiquement après 3 secondes
                            alertType = "danger";
                            message = data.Message;
                            break;
                        case 2: // User et/ou mot de passe invalide
                            alertType = "danger";
                            message = data.Message;
                            break;
                    }
                    $alertPrepare = `
                    <div class="alert alert-` + alertType + ` alert-dismissible fade show mb-2" role="alert">` + message + `                      
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>  
                        </button>
                    </div>`

                    $('#rightSection').prepend($alertPrepare);


                }, //#end success
                // error: Lorsqu'on a une erreur provenant de l'appel ajax
                // Ce n'est pas les erreurs qui proviennent du retour
                // de votre code php
                error: function(jqXHR) {
                    msg = "Une erreur est survenue. Error : ";
                    switch (jqXHR.status) {
                        case 200:
                            msg = msg + jqXHR.status + " Le json retourné est invalide.";
                            break;
                        case 404:
                            msg = msg + jqXHR.status + " La page deletePost.php est manquante.";
                            break;
                    }
                    alert(msg);
                } //#end error
            }); //#end ajax call
        }
    </script>
</body>

</html>