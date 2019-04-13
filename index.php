<?php
session_start();

require_once dirname(__DIR__) . '\Battleship\vendor\autoload.php';
use Battleship\Grid as Grid;
use Battleship\Ship as Ship;


if (!isset($_SESSION['grid'])) {
    $grid = new Grid();
    $dotShip1 = new Ship(Ship::DOT_SHAPE, $grid);
    $dotShip2 = new Ship(Ship::DOT_SHAPE, $grid);
    $iHShip = new Ship(Ship::I_SHAPE, $grid);
    $lShip = new Ship(Ship::L_SHAPE, $grid);
    $_SESSION['grid'] = $grid->getGrid();
} else {
    try {
        $grid = new Grid($_SESSION['grid']);
        if (isset($_POST['shot_fired'])) {
            $grid->shoot(rand(0,9), rand(0,9));
            $_SESSION['grid'] = $grid->getGrid();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<form action="" method="post">
    <input type="hidden" name="shot_fired"/>
    <button type="submit">
        Shoot!
    </button>
</form>

<?php
$grid->displayGrid();

if ($grid->isGameOver()) {
    echo "<div><h3>Game Over!</h3></div>";
    unset ($_SESSION['grid']);
}