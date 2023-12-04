<section class=" w3l-header-4 header-sticky">
    <header class="absolute-top">
        <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <h1><a class="navbar-brand" href="index.php"> <!--<span class="fa fa-line-chart" aria-hidden="true"></span> -->
            HOME
            </a></h1>
            <button class="navbar-toggler bg-gradient collapsed" type="button" data-toggle="collapse"
                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa icon-expand fa-bars"></span>
        <span class="fa icon-close fa-times"></span>
            </button>
      
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="reviews.php">Reviews</a>
                    </li>
                    <?php if (strlen($_SESSION['bpmsuid']) == 0) { ?>
                    <li style="padding-left: 200px; font-size: 30px;" class="nav-item">
                        <a class="nav-link" href="login.php">Sign in</a>
                        <?php } ?>
                    </li>
                    <?php if (strlen($_SESSION['bpmsuid']) > 0) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="book-appointment.php">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="booking-history.php">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="invoice-history.php">Receipt</a>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            My settings
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="nav-link" href="profile.php">Profile</a>
                            <a class="nav-link" href="change-password.php">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="nav-link" href="logout.php">Logout</a>
                        </div>
                    </li>
                  <?php }?>
                </ul>
                
            </div>
        </div>

        </nav>
    </div>
      </header>
</section>