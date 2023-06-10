 <nav id="nav">
     <ul>
         <li><a href="index.php" id="Home-btn">Home</a></li>
         <li><a href="about.html">About</a></li>
         <li><a href="events.php" id="Cari-btn">Docs</a></li>
         <?php if (isset($_SESSION['logged_in'])) {
                echo '<li><a href="./user/profile.php">Profile</a></li>';
                echo '<li><a href="./index.php?logout=success">Logout</a></li>';
            } else {
                echo '<li><a href="./login.php">Login</a></li>';
            } ?>
     </ul>
 </nav>

 <script src="assets/js/jquery.min.js"></script>
 <script src="assets/js/jquery.dropotron.min.js"></script>
 <script src="assets/js/browser.min.js"></script>
 <script src="assets/js/breakpoints.min.js"></script>
 <script src="assets/js/util.js"></script>
 <script src="assets/js/main.js"></script>