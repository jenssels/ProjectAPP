<nav id="hoofding" class="navbar navbar-default navbar-fixed-top text-white bg-TMOrange">
    <div class="container">
        <h1><?php echo anchor('organisator/index', 'Personeelsfeest') ?></h1>
        <?php
        if ($emailGebruiker != '') {
            echo "<span class='navbar-text'><i class='fas fa-user'></i> $emailGebruiker</span>";
        } else {            
            echo "<span class='navbar-text'><i class='fas fa-user'></i> " . anchor('organisator/aanmelden', 'Organisator login') . "</span>";
        }
        ?>  
    </div>
</nav>