<?php

require_once dirname(__DIR__) . '\Battleship\vendor\autoload.php';
use Battleship\Grid as Grid;
use Battleship\Ship as Ship;

$grid = new Grid();
$dotShip1 = new Ship(Ship::DOT_SHAPE, $grid);
$dotShip2 = new Ship(Ship::DOT_SHAPE, $grid);
$iHShip = new Ship(Ship::I_SHAPE, $grid);
$lShip = new Ship(Ship::L_SHAPE, $grid);
$grid->displayGrid();