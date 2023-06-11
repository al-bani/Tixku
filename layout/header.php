<nav id="nav">
    <ul>
        <img src="./assets/images/logo/logoW.png" alt="logo" style="width: 110px; margin-bottom: -2.5px;">
        <li><a href="index.php" id="Home-btn">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="https://albani.gitbook.io/tixku/" target="_blank" id="Cari-btn">Docs</a></li>
        <?php if (isset($_SESSION['logged_in'])) {
            echo '<li><a href="./user/profile.php">Profile</a></li>';
            echo '<li><a href="./index.php?logout=success" onclick="confirmLogout(event);">Logout</a></li>';
        } else {
            echo '<li><a href="./login.php">Login</a></li>';
        } ?>
    </ul>
</nav>
<script>
    function confirmLogout(event) {
        if (!confirm("Apakah Anda yakin ingin logout?")) {
            event.preventDefault();
        }
    }
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.dropotron.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>