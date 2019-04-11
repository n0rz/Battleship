<?php
namespace Battleship;

class Grid {

    /**
     * Grid constructor.
     */
    public function __construct() {
        for ($i=0; $i<10; $i++) {
            $this->grid[$i] = array_fill(0, 10, '0');
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
     * Checks if coordinate is on grid
     * @param $i
     * @param $j
     * @return bool
     */
    public function isCoordOnGrid($i, $j) {
        return isset($this->grid[$i][$j]);
    }

    /**
     * @param int $i
     * @param int $j
     * @return bool
     * Check if the grid lot is empty
     */
    public function isEmptyLot(int $i, int $j) {
        return $this->grid[$i][$j] == '0';
    }

    /**
     * Check if an area surrounding a lot is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isSurroundingEmpty(int $i, int $j) {
        return $this->isUpEmpty($i, $j) &&
            $this->isUpRightEmpty($i, $j) &&
            $this->isRightEmpty($i, $j) &&
            $this->isDownRightEmpty($i, $j) &&
            $this->isDownEmpty($i, $j) &&
            $this->isDownLeftEmpty($i, $j) &&
            $this->isLeftEmpty($i, $j) &&
            $this->isUpLeftEmpty($i, $j);
    }


    /**
     * Check if UP is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isUpEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i-1, $j) && !$this->isEmptyLot($i-1,$j)) {
            return false;
        }
        return true;
    }

    /**
     * Check if UP-Right is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isUpRightEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i-1, $j+1) && !$this->isEmptyLot($i-1,$j+1)) {
            return false;
        }
        return true;
    }

    /**
     * Check if Right is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isRightEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i, $j+1) && !$this->isEmptyLot($i,$j+1)) {
            return false;
        }
        return true;
    }

    /**
     * Check if Down-Right is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isDownRightEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i+1, $j+1) && !$this->isEmptyLot($i+1,$j+1)) {
            return false;
        }
        return true;
    }

    /**
     * Check if Down is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isDownEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i+1, $j) && !$this->isEmptyLot($i+1,$j)) {
            return false;
        }
        return true;
    }

    /**
     * Check if Down-Left is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isDownLeftEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i+1, $j-1) && !$this->isEmptyLot($i+1,$j-1)) {
            return false;
        }
        return true;
    }

    /**
     * Check if Left is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isLeftEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i, $j-1) && !$this->isEmptyLot($i,$j-1)) {
            return false;
        }
        return true;
    }


    /**
     * Check if Up-Left is empty
     * @param int $i
     * @param int $j
     * @return bool
     */
    public function isUpLeftEmpty(int $i, int $j) {
        if ($this->isCoordOnGrid($i-1, $j-1) && !$this->isEmptyLot($i-1,$j-1)) {
            return false;
        }
        return true;
    }


    /**
     * Set(s) of coordinates which represent ship parts
     * @param array(s) ...$IJ
     * @return bool
     */
    public function setShip(...$coords) {
        foreach ($coords as $iY) {
            if($this->isEmptyLot($iY[0], $iY[1])) {
                $this->grid[$iY[0]][$iY[1]] = "X";
            } else return false;
        }
        return true;
    }
}