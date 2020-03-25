<?php
$uniqueCarouselID = "carousel" . uniqid();

//CAROUSEL START / CAROUSEL INDICATORS START 
echo <<<EOT
<div id="$uniqueCarouselID" class="carousel slide card-img-top" data-ride="carousel">                                      
EOT;


if (!in_array('audio/mp3', array_column($mediaData, 'typeMedia'))) { // search value in the array

    echo '<ol class="carousel-indicators">';
    // POST IMAGE LIST
    for ($i = 0; $i < count($mediaData); $i++) {
        if ($i == 0) {
            echo '<li data-target="#' . $uniqueCarouselID . '" data-slide-to="' . $i . '" class="active"></li>';
        } else {
            echo '<li data-target="#' . $uniqueCarouselID . '" data-slide-to="' . $i . '"></li>';
        }
    }
    echo '</ol>';
}

//CAROUSEL
echo '<div class="carousel-inner">';

for ($i = 0; $i < count($mediaData); $i++) {
    $activeBool = "";

    if ($i == 0) $activeBool = "active";



    if (strpos($mediaData[$i]['typeMedia'], 'image/') !== false) {
        echo <<<EOT
            <div class="carousel-item $activeBool image_blurred_wrapper">
                <div class="image_blurred" style="background-image: url('/upload/{$mediaData[$i]['nomMedia']}')"></div>                               
                <img alt="image" class="imgPost" src="/upload/{$mediaData[$i]['nomMedia']}" /> 
            </div>                                   
            EOT;
    } elseif (strpos($mediaData[$i]['typeMedia'], 'video/') !== false) {
        echo <<<EOT
            <div class="carousel-item $activeBool">
                <video class="videoPost" controls autoplay loop muted>
                    <source src="/upload/{$mediaData[$i]['nomMedia']}" type="video/mp4">
                    Your browser does not support HTML5 video.                   
                </video>
            </div>                                 
            EOT;
    } elseif (strpos($mediaData[$i]['typeMedia'], 'audio/') !== false) {
        echo <<<EOT
            <div class="carousel-item $activeBool bg-audio pb-1 pt-1">
                <audio class="audioPost" controls>
                    <source src="/upload/{$mediaData[$i]['nomMedia']}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>        
            </div>            
            EOT;
    }
}
echo <<<EOT
    </div>
    <a class="carousel-control-prev" href="#$uniqueCarouselID" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#$uniqueCarouselID" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
EOT;

