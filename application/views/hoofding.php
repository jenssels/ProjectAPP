<nav id="hoofding" class="navbar navbar-default navbar-fixed-top text-white bg-TMOrange">
    <div class="container">
        <h1><?php echo anchor('home/index', 'Personeelsfeest') ?></h1>
        <?php
        if ($this->session->userdata('emailgebruiker')) {
            echo "<span class='navbar-text'><i class='fas fa-user'></i>" . $this->session->userdata('emailgebruiker') . "</span>";
            echo "<span class='navbar-text'><i class='fas fa-user'></i>" . anchor('home/afmelden', 'Afmelden') . "</span>";
        } else {
            echo "<span class='navbar-text'><i class='fas fa-user'></i> " . anchor('home/aanmelden', 'Organisator login') . "</span>";
        }
        ?>
    </div>
</nav>