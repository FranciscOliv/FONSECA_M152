<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-blue">
    <a class="navbar-brand" href="#">
        <svg width="30px" height="30px" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path id="logoImg" fill-rule="evenodd" clip-rule="evenodd" d="M23 0C10.2975 0 0 10.2975 0 23V233C0 245.703 10.2975 256 23 256H233C245.703 256 256 245.703 256 233V23C256 10.2975 245.703 0 233 0H23ZM165.669 96.6C157.669 92.0667 148.735 89.8 138.869 89.8C126.069 89.8 116.002 93.5333 108.669 101V51.6H70.6687V200H106.869V189.2C113.935 197.6 124.602 201.8 138.869 201.8C148.735 201.8 157.669 199.533 165.669 195C173.802 190.333 180.202 183.733 184.869 175.2C189.669 166.667 192.069 156.8 192.069 145.6C192.069 134.4 189.669 124.6 184.869 116.2C180.202 107.667 173.802 101.133 165.669 96.6ZM147.269 164.8C143.002 169.333 137.535 171.6 130.869 171.6C124.202 171.6 118.735 169.333 114.469 164.8C110.202 160.133 108.069 153.733 108.069 145.6C108.069 137.6 110.202 131.333 114.469 126.8C118.735 122.267 124.202 120 130.869 120C137.535 120 143.002 122.267 147.269 126.8C151.535 131.333 153.669 137.6 153.669 145.6C153.669 153.733 151.535 160.133 147.269 164.8Z" fill="currentColor" />
        </svg>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse">
        <div class="input-group md-form form-sm form-2 pl-0">
            <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>

    <div class="collapse navbar-collapse ml-2" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!-- HOME BUTTON -->
            <li class="nav-item mr-2">
                <a class="nav-link text-white" href="index.php">
                    <i class="fas fa-home text-white" aria-hidden="true"></i>
                    Home <span class="sr-only">(current)</span></a>
            </li>

            <!-- POST BUTTON -->
            <li class="nav-item mr-2">
                <a class="nav-link text-white" href="post.php">
                    <i class="fas fa-plus text-white font" aria-hidden="true"></i>
                    Post <span class="sr-only">(current)</span></a>
            </li>

            <!-- BADGE BUTTON -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <b class=" text-blue rounded-pill bg-white p-1">badge</b> <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <!-- BTN USER -->
            <li class="nav-item">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fas fa-user text-white" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn mb-2" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- END NAVBAR -->