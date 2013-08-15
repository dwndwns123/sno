<header>
  <div class="navbar">
    <div class="navbar-inner">
      <a class="brand" href="index.php">GP/FP SNOMED CT RefSet and ICPC-2 mapping project - Field Test</a>
      <?php
      if($_SESSION["logged"]){
      ?>
      <ul class="nav pull-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#"><?= ($_SESSION['title'] !== 'Other' ? $_SESSION['title'].' ' : ''); ?><?= $_SESSION['first_name'].' '.$_SESSION['last_name'] ?> <b class="caret"></b></a>
          <ul class="dropdown-menu" role="menu">
            <li role="presentation"><a href="index.php" tabindex="-1" role="menuitem">Home</a></li>
            <li role="presentation"><a href="profile.php" tabindex="-1" role="menuitem">Profile</a></li>
            <li role="presentation"><a href="encounters.php" tabindex="-1" role="menuitem">Encounters</a></li>
            <li role="presentation"><a href="logout.php" tabindex="-1" role="menuitem">Log out</a></li>
          </ul>
        </li>
      </ul>
      <?php
      }
      ?>
    </div>
  </div>
</header>