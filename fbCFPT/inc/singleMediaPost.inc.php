<?php
if (strpos($mediaData[0]['typeMedia'], 'image/') !== false) {
    echo <<<EOT
    <div class="image_blurred_wrapper">
        <div class="image_blurred" style="background-image: url('/upload/{$mediaData[0]['nomMedia']}');"></div>
        <img class="card-img-top imgPost" src="/upload/{$mediaData[0]['nomMedia']}" alt="Card image cap">
    </div>
    
    EOT;
} elseif (strpos($mediaData[0]['typeMedia'], 'video/') !== false) {
    echo <<<EOT
        <video class="videoPost" controls autoplay loop muted>
            <source src="/upload/{$mediaData[0]['nomMedia']}" type="video/mp4">
            Your browser does not support HTML5 video.                   
        </video>        
        EOT;
} elseif (strpos($mediaData[0]['typeMedia'], 'audio/') !== false) {
    echo <<<EOT
        <div class="p-1 bg-audio">
            <audio class="audioPost w-100 bg-audio" controls>
                <source src="/upload/{$mediaData[0]['nomMedia']}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>              
        </div>  
        EOT;
}
