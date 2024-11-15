<!-- 
<link rel="stylesheet" href="../assets/css/style.css">
<div class="navigation-container">
    <a href="dashboard.php" class="nav-link home"></a>
    <a href="control.php" class="nav-link control"></a>
    <a href="#" class="nav-link vote"></a>
    <a href="#" class="nav-link settings"></a>
    <a href="#" class="nav-link logout"></a>
</div> -->

<link rel="stylesheet" href="/project/assets/css/style.css">
<div class="navigation-container">
    <a href="/project/admin/dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard') ? 'home-active active' : 'home-passive passive'; ?>">"></a>
    <a href="/project/admin/control/control.php" class="nav-link <?php echo ($currentPage == 'control') ? 'control-active active' : 'control-passive passive'; ?>">"></a>
    <a href="/project/admin/votes/votes.php" class="nav-link <?php echo ($currentPage == 'votes') ? 'vote-active active' : 'vote-passive passive'; ?>">"></a>
    <!-- <a href="#" class="nav-link <?php echo ($currentPage == 'settings') ? 'settings-active active' : 'settings-passive passive'; ?>">"></a> -->
    <a href="/project/auth/logout.php" class="nav-link <?php echo ($currentPage == 'logout') ? 'logout-active active' : 'logout-passive passive'; ?>">"></a>
</div>