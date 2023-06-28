<nav class="nav">
    <a href="index.php" class="nav-link">Acceuil</a>
    <a href="index.php?page=view/liste" class="nav-link">Liste des cours</a>
    <a href="index.php?page=view/profile" class="nav-link">Profile</a>
    <?php if (!empty($_SESSION['userid'])) {
        $user = getUser('id', $_SESSION['userid']);
        if ($user->admin == 1) {
            ?>
            <a href="index.php?page=view/admin" class="nav-link">Admin</a>
        <?php }
    }
    if (!empty($_SESSION['userid'])) {
        ?>
        <a href="index.php?page=view/logout" class="nav-link">Logout</a>
        <?php
    } else {
        ?>
        <a href="index.php?page=view/login" class="nav-link">Login</a>
        <?php
    }
    ?>

</nav>