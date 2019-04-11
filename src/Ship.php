<?php
namespace Battleship;

use Battleship\Grid as Grid;


class Ship {

    public const L_SHAPE = 'L';
    public const I_SHAPE = 'I';
    public const DOT_SHAPE = 'DOT';

    /**
    * @var String
    */
    private $shape;

    private const ROTATIONS = ['H', 'V'];

    /**
    * @var $rotation String
    * (H)orizontal or (V)ertical
    */
    private $rotation;

    /**
     * Ship constructor.
     * @param string $shape
     * @param \Battleship\Grid $grid
     */
    public function __construct(string $shape, Grid $grid) {
        $this->rotation = $this->rotation[array_rand(self::ROTATIONS)];
        switch ($shape) {
             case self::DOT_SHAPE:
                 $this->shape = self::DOT_SHAPE;
                 $this->generateDotShipPosition($grid);
                 break;
             case self::L_SHAPE:
                 $this->shape = self::L_SHAPE;
                 $this->generateLShapePosition($grid);
                 break;
             case self::I_SHAPE:
                 $this->shape = self::I_SHAPE;
                 $this->generateIShapePosition($grid);
                 break;
        }
    }

    /** Generates position for Single-cell(dot)-shaped ship
     * @param \Battleship\Grid $grid
     */
    private function generateDotShipPosition(Grid $grid) {
        $i = (int) rand(0, 9);
        $j = (int) rand(0, 9);

        while (!$grid->isSurroundingEmpty($i,$j)) {
            $i = (int) rand(0,9);
            $j = (int) rand(0,9);
        }

        $grid->setShip([$i, $j]);
        $this->startPos = [$i, $j];
    }

    /**
     * Generates a position for the I-shaped ship
     * @param \Battleship\Grid $grid
     */
    private function generateIShapePosition(Grid $grid) {
        $firstCellI = rand(0,9);
        $firstCellJ = rand(0,9);
        if ($this->rotation === 'H') { //Horizontal Ship
            while (true) {
                if($grid->isSurroundingEmpty($firstCellI, $firstCellJ)) { //First Cell
                    if ($grid->isCoordOnGrid($firstCellI, $firstCellJ+1) &&
                        $grid->isSurroundingEmpty($firstCellI, $firstCellJ+1)) { //Second Cell
                        if ($grid->isCoordOnGrid($firstCellI, $firstCellJ+2) &&
                            $grid->isSurroundingEmpty($firstCellI, $firstCellJ+2)) { //Third Cell
                            if ($grid->isCoordOnGrid($firstCellI, $firstCellJ+3) &&
                                $grid->isSurroundingEmpty($firstCellI, $firstCellJ+3)) { //Fourth Cell
                                $grid->setShip(
                                    [$firstCellI, $firstCellJ],
                                    [$firstCellI, $firstCellJ+1],
                                    [$firstCellI, $firstCellJ+2],
                                    [$firstCellI, $firstCellJ+3]
                                );
                                break;
                            }
                        }
                    }
                }
                $firstCellI = rand(0,9);
                $firstCellJ = rand(0,9);
            }
        } else { //Vertical Ship
            while (true) {
                if($grid->isSurroundingEmpty($firstCellI, $firstCellJ)) { //First Cell
                    if ($grid->isCoordOnGrid($firstCellI+1, $firstCellJ) &&
                        $grid->isSurroundingEmpty($firstCellI+1, $firstCellJ)) { //Second Cell
                        if ($grid->isCoordOnGrid($firstCellI+2, $firstCellJ) &&
                            $grid->isSurroundingEmpty($firstCellI+2, $firstCellJ+2)) { //Third Cell
                            if ($grid->isCoordOnGrid($firstCellI+3, $firstCellJ) &&
                                $grid->isSurroundingEmpty($firstCellI+3, $firstCellJ)) { //Fourth Cell
                                $grid->setShip(
                                    [$firstCellI, $firstCellJ],
                                    [$firstCellI+1, $firstCellJ],
                                    [$firstCellI+2, $firstCellJ],
                                    [$firstCellI+3, $firstCellJ]
                                );
                                break;
                            }
                        }
                    }
                }
                $firstCellI = rand(0,9);
                $firstCellJ = rand(0,9);
            }
        }
    }

    /**
     * Generates a position for the L-shaped ship
     * @param \Battleship\Grid $grid
     */
    private function generateLShapePosition(Grid $grid) {
        $firstCellI = rand(0,9);
        $firstCellJ = rand(0,9);
        if ($this->rotation == 'H') {
            while (true) {
                //Because the "L" will point up, check if "up" exists on grid. Checking the fourth cell.
                if ($grid->isCoordOnGrid($firstCellI-1, $firstCellJ+2) && //Fourth Cell
                    $grid->isSurroundingEmpty($firstCellI-1, $firstCellJ+2)) {
                    if ($grid->isSurroundingEmpty($firstCellI, $firstCellJ)) { //First Cell
                        if($grid->isCoordOnGrid($firstCellI, $firstCellJ+1) &&
                            $grid->isSurroundingEmpty($firstCellI, $firstCellJ+1)) { //Second Cell
                            if ($grid->isCoordOnGrid($firstCellI, $firstCellJ+2) &&
                                $grid->isSurroundingEmpty($firstCellI, $firstCellJ+2)) { //Third Cell
                                $grid->setShip(
                                    [$firstCellI, $firstCellJ],
                                    [$firstCellI, $firstCellJ+1],
                                    [$firstCellI, $firstCellJ+2],
                                    [$firstCellI-1, $firstCellJ+2]
                                );
                                break;
                            }
                        }
                    }
                }
                $firstCellI = rand(0,9);
                $firstCellJ = rand(0,9);
            }
        } else {
            while (true) {
                //Because the "L" will point right, check if "right" exists on grid. Checking the fourth cell.
                //Fourth Cell
                if ($grid->isCoordOnGrid($firstCellI+2, $firstCellJ+1) &&
                    $grid->isSurroundingEmpty($firstCellI+2, $firstCellJ+1)) {
                    //First Cell
                    if ($grid->isSurroundingEmpty($firstCellI, $firstCellJ)) {
                        //Second Cell
                        if($grid->isCoordOnGrid($firstCellI+1, $firstCellJ) &&
                            $grid->isSurroundingEmpty($firstCellI+1, $firstCellJ)) {
                            //Third Cell
                            if ($grid->isCoordOnGrid($firstCellI+2, $firstCellJ) &&
                                $grid->isSurroundingEmpty($firstCellI+2, $firstCellJ)) {
                                $grid->setShip(
                                    [$firstCellI, $firstCellJ],
                                    [$firstCellI+1, $firstCellJ],
                                    [$firstCellI+2, $firstCellJ],
                                    [$firstCellI+2, $firstCellJ+1]
                                );
                                break;
                            }
                        }
                    }
                }
                $firstCellI = rand(0,9);
                $firstCellJ = rand(0,9);
            }
        }
    }

    public function getRotation() {
        return $this->rotation;
    }
    
    public function getShape() {
        return $this->shape;
    }
}