  
  <div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
          <ul class="nav" id="side-menu">
            <li>
              <a href="dashboard.php"><i class="fa fa-home nav_icon"></i>Dashboard</a>
            </li>
            <!-- /nav-second-level -->
            <li>
              <a href="customer-list.php"><i class="fa fa-users nav_icon"></i>Users<span class="fa arrow"></span> </a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="customer-list.php">Manage Customer</a>
                </li>
                <?php if ($_SESSION['userRole'] !== 'Staff') { ?>
                <li>
                  <a href="manage-staff.php">Manage Staff</a>
                </li>
                <?php } ?>
              </ul>
              <!-- /nav-second-level -->
              <?php if ($_SESSION['userRole'] !== 'Staff') { ?>
            <li>
              <a href="add-services.php"><i class="fa fa-cogs nav_icon"></i>Services<span class="fa arrow"></span> </a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="add-services.php">Add Services</a>
                </li>
                <li>
                  <a href="manage-services.php">Manage Services</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
            <li class="">
              <a href="about-us.php"><i class="fa fa-book nav_icon"></i>Pages <span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="about-us.php">About Us</a>
                </li>
                <li>
                  <a href="contact-us.php">Contact Us</a>
                </li>
                <li>
                  <a href="manage-reviews.php">Reviews</a>
                </li>
              </ul>
              <?php } ?>
            </li>
            <li>
              <a href="all-appointment.php"><i class="fa fa-check-square-o nav_icon"></i>Appointments<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="all-appointment.php">All Appointments</a>
              </li>
              </ul>
              <!-- //nav-second-level -->
            </li>
           
        
           <li>
              <a href="readenq.php"><i class="fa fa-check-square-o nav_icon"></i>Enquiries<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li><a href="readenq.php">Read Enquiry</a></li>
        <li><a href="unreadenq.php">Unread Enquiry</a></li>
               
              </ul>
              <!-- //nav-second-level -->
            </li>
            <?php if ($_SESSION['userRole'] !== 'Staff') { ?>
              <li>
              <a href="invoices.php"><i class="fa fa-check-square-o nav_icon"></i>Sales<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li><a href="invoices.php"> Manage Sales</a></li>
              </ul>
              <!-- //nav-second-level -->
            </li>
            <?php } ?>
          </ul>
          <div class="clearfix"> </div>
          <!-- //sidebar-collapse -->
        </nav>
      </div>
    </div>