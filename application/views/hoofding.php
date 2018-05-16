<?php
/**
 * @file hoofding.php
 *
 * View waarin de hoofding wordt gemaakt
 * - gebruikt bootstrap nav
 */
?>

<nav id="hoofding" class="navbar navbar-default navbar-fixed-top text-white bg-TMOrange">
    <div class="container">
        <h1>Personeelsfeest</h1>
        <span class='navbar-text'>
            <?php
            if ($this->session->userdata('emailgebruiker')) {
                echo "<i class='fas fa-user'></i> " . $this->session->userdata('emailgebruiker');
                echo "  |  ";
                if ($this->session->userdata('gebruikerTypeId') == 1) {
                    echo anchor ('organisator/personeelsFeestOverzicht', '<i class="fas fa-list-ul"></i>  Overzicht');
                    echo "  |  ";
                    } elseif ($this->session->userdata('gebruikerTypeId') == 3) {
                    echo anchor ('personeel/index/' . $this->session->userdata('gebruikerHashcode'), '<i class="fas fa-list-ul"></i>  Inschrijven');
                    echo "  |  ";
                    echo anchor ('personeel/overzichtalbums/', '<i class="fas fa-camera"></i>  Fotoalbums');
                    echo "  |  ";
                }

                echo anchor('home/afmelden', '<i class="fas fa-sign-out-alt"></i>  Afmelden');
            } else {
                echo "<i class='fas fa-user'></i> " . anchor('home/aanmelden', 'Organisator login');
            }
            ?>
        </span>        
    </div>
</nav>