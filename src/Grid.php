<?php
namespace Battleship;

class Grid {

    /**
     * @var array
     */
    private $grid;

    /**
     * Grid constructor.
     */
    public function __construct($grid = null) {
        if ($grid) $this->grid = $grid;
        else {
            for ($i=0; $i<10; $i++) {
                $this->grid[$i] = array_fill(0, 10, '0');
            }
        }
    }

    /**
     * Displays the Grid. For dev purposes so far
     */
    public function displayGrid() {
        for ($i=0; $i<10; $i++) {
            for ($j=0; $j<10; $j++) {
                echo $this->grid[$i][$j]." ";
            }
            echo "\n";
        }
    }

    /**
     * Set of cell(s) which represent ship cells
     * @param array(s) of $cell
     * @return bool
     */
    public function setShip(...$cells) {
        foreach ($cells as $cell) {
            if($this->isEmptyCell([$cell[0], $cell[1]])) {
                $this->grid[$cell[0]][$cell[1]] = "S";
            } else return false;
        }
        return true;
    }

    /**
     * Check if the surrounding area of a cell is empty
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    public function isSurroundingEmpty(array $cell) {
        list($i, $j) = $cell;
        return $this->isEmptyCell($this->getUpCell($i, $j)) &&
            $this->isEmptyCell($this->getUpRightCell($i, $j)) &&
            $this->isEmptyCell($this->getRightCell($i, $j)) &&
            $this->isEmptyCell($this->getDownRightCell($i, $j)) &&
            $this->isEmptyCell($this->getDownCell($i, $j)) &&
            $this->isEmptyCell($this->getDownLeftCell($i, $j)) &&
            $this->isEmptyCell($this->getLeftCell($i, $j)) &&
            $this->isEmptyCell($this->getUpLeftCell($i, $j));
    }

    /**
     * Checks if the surrounding area of a cell is not a ship
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    public function isSurroundingNotShip(array $cell) {
        list($i, $j) = $cell;
        return
            (!$this->isCellOnGrid($this->getUpCell($i, $j)) || $this->isEmptyCell($this->getUpCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getUpRightCell($i, $j)) || $this->isEmptyCell($this->getUpRightCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getRightCell($i, $j)) || $this->isEmptyCell($this->getRightCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getDownRightCell($i, $j)) || $this->isEmptyCell($this->getDownRightCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getDownCell($i, $j)) || $this->isEmptyCell($this->getDownCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getDownLeftCell($i, $j)) || $this->isEmptyCell($this->getDownLeftCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getLeftCell($i, $j)) || $this->isEmptyCell($this->getLeftCell($i, $j))) &&
            (!$this->isCellOnGrid($this->getUpLeftCell($i, $j)) || $this->isEmptyCell($this->getUpLeftCell($i, $j)));
    }

    /**
     * Checks if Cell is on grid
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    public function isCellOnGrid(array $cell) {
        echo "Cell ".$cell[0]." ".$cell[1];
        echo isset($this->grid[$cell[0]][$cell[1]]) ? " is " : " is not ";
        echo "on grid. \n";
        return isset($this->grid[$cell[0]][$cell[1]]);
    }

    /**
     * Check if the grid cell is empty
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    public function isEmptyCell(array $cell) {
        echo "Cell ".$cell[0]." ".$cell[1];
        echo isset($this->grid[$cell[0]][$cell[1]]) ? " is " : " is not ";
        echo "an empty cell. \n";
        return $this->grid[$cell[0]][$cell[1]] === '0';
    }

    /**
     * Check if the grid cell is a missed shot cell
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    private function isMissedShotCell(array $cell) {
        echo "Cell ".$cell[0]." ".$cell[1];
        echo $this->grid[$cell[0]][$cell[1]] == '*' ? " is " : " is not ";
        echo "a missed shot. \n";
        return $this->grid[$cell[0]][$cell[1]] == '*';
    }

    private function isDestroyedShipCell(array $cell) {
        echo "Cell ".$cell[0]." ".$cell[1];
        echo $this->grid[$cell[0]][$cell[1]] == '*' ? " is " : " is not ";
        echo "a destroyed ship (part). \n";
        return $this->grid[$cell[0]][$cell[1]] == 'X';
    }

    /**
     * Check if the cell is a ship cell
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    private function isShipCell(array $cell) {
        return $this->isCellOnGrid($cell) &&
            !$this->isEmptyCell($cell) &&
            !$this->isMissedShotCell($cell) &&
            !$this->isDestroyedShipCell($cell);
    }

    /**
     * Returns Array Keys of Up Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getUpCell(int $i, int $j) {
        return [$i-1, $j];
    }

    
    /**
     * Returns Array Keys of Up-Right Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getUpRightCell(int $i, int $j) {
        return [$i-1, $j+1];
    }


    /**
     * Returns Array Keys of Right Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getRightCell(int $i, int $j) {
        return [$i, $j+1];
    }
    
    /**
     * Returns Array Keys of Down-Right Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getDownRightCell(int $i, int $j) {
        return [$i+1, $j+1];
    }

    /**
     * Returns Array Keys of Down Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getDownCell(int $i, int $j) {
        return [$i+1, $j];
    }


    /**
     * Returns Array Keys of Down-Left Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getDownLeftCell(int $i, int $j) {
        return [$i+1, $j-1];
    }

    
    /**
     * Returns Array Keys of Left Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getLeftCell(int $i, int $j) {
        return [$i, $j-1];
    }

    
    /**
     * Returns Array Keys of Up-Left Cell
     * @param int $i
     * @param int $j
     * @return array
     */
    private function getUpLeftCell(int $i, int $j) {
        return [$i-1, $j-1];
    }


    /**
     * Shoot cell
     * @param int $i
     * @param int $j
     */
    public function shoot(int $i, int $j) {
        if ($this->isEmptyCell([$i, $j])) {
            $this->markMissedCell($i, $j);
        } else {
            $this->destroyShip([$i, $j]);
        }
    }

    /**
     * Recursively destroy all immediately near ship cells
     * @param array $cell
     */
    private function destroyShip(array $cell) {
        echo "Cell ".$cell[0]." ".$cell[1];
        echo isset($this->grid[$cell[0]][$cell[1]]) ? " is " : " is not ";
        echo "being destroyed. \n";

        list($i, $j) = $cell;
        $this->markShipCellDestroyed($i, $j);

        if ($this->isShipCell($this->getUpCell($i, $j))) $this->destroyShip($this->getUpCell($i, $j));
        if ($this->isShipCell($this->getUpRightCell($i, $j))) $this->destroyShip($this->getUpRightCell($i, $j));
        if ($this->isShipCell($this->getRightCell($i, $j))) $this->destroyShip($this->getRightCell($i, $j));
        if ($this->isShipCell($this->getDownRightCell($i, $j))) $this->destroyShip($this->getDownRightCell($i, $j));
        if ($this->isShipCell($this->getDownCell($i, $j))) $this->destroyShip($this->getDownCell($i, $j));
        if ($this->isShipCell($this->getDownLeftCell($i, $j))) $this->destroyShip($this->getDownLeftCell($i, $j));
        if ($this->isShipCell($this->getLeftCell($i, $j))) $this->destroyShip($this->getLeftCell($i, $j));
        if ($this->isShipCell($this->getUpLeftCell($i, $j))) $this->destroyShip($this->getUpLeftCell($i, $j));
    }

    private function markShipCellDestroyed(int $i, int $j) {
        $this->grid[$i][$j] = 'X';
    }

    private function markMissedCell(int $i, int $j) {
        $this->grid[$i][$j] = '*';
    }
}