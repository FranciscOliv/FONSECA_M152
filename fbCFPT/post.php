<?php
//require_once "inc/function.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/upload.php";
//getAll();
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

    <title>Hello, world!</title>
</head>

<body>

    <!-- NAVBAR -->
    <?php
    include_once "inc/nav.inc.php";
    ?>
    <!-- END NAVBAR -->

    <!-- MAIN -->
    <main class="container mt-4">

        <?php
        if (!empty($errors)) {
            foreach ($errors as $value) {
                echo "<div class='mt-2 alert alert-danger alert-dismissible fade show' role='alert' >" . $value . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
            unset($errors);
        }
        ?>

        <div class="card">
            <div class="card-header">
                Créer un post
            </div>
            <div class="card-body">
                <form method="POST" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <textarea class="form-control" id="postTextarea" rows="3" placeholder="Write something..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input id="inputFileImage" name="inputImg[]" type="file" class="custom-file-input" accept="image/x-png,image/gif,image/jpeg" multiple>
                            <label class="custom-file-label" for="inputFileImage">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>



        <!-- <form method="POST" action="/inc/upload.php" enctype="multipart/form-data">
            
            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            Fichier : <input type="file" name="avatar">
            <input type="submit" name="envoyer" value="Envoyer le fichier">
        </form> -->
    </main>
    <!-- END MAIn -->


    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <script type="text/javascript">
        $(document).on('change', '#inputFileImage', function(event) {

            var filename = "";
            for (i = 0; i < this.files.length; i++) {
                filename += '"' + this.files.item(i).name + '" '

            }
            $(this).next('.custom-file-label').html(filename);

        })
    </script>

</body>

</html>