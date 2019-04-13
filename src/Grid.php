<?php
namespace Battleship;

class Grid {

    private const emptyCell = "0";
    private const shipCell = "S";
    private const missedShotCell = "*";
    private const destroyedShipCell = "X";
    private const emptyCellImgTag = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/empty.png' />";
    private const shipCellImgTag = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/ship-ok.png' />";
    private const missedShotCellImgTag = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/missed.png' />";
    private const destroyedShipCellImgTag = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/ship-dead.png' />";
    private const emptyCellImgTagCurrentShot = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/empty-current-shot.png' />";
    private const shipCellImgTagCurrentShot = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/ship-ok-current-shot.png' />";
    private const missedShotCellImgTagCurrentShot = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/missed-current-shot.png' />";
    private const destroyedShipCellImgTagCurrentShot = "<img src='https://s3-us-west-2.amazonaws.com/n0r-dev/battleship/ship-dead-current-shot.png' />";

    /**
     * Represents current shot
     * @var array
     */
    private $currentShot;

    /**
     * @var array
     */
    private $grid;

    /**
     * Grid constructor.
     * @param null $grid
     */
    public function __construct($grid = null) {
        if ($grid) $this->grid = $grid;
        else {
            for ($i=0; $i<10; $i++) {
                $this->grid[$i] = array_fill(0, 10, self::emptyCell);
            }
        }
    }

    /**
     * @return array|null
     */
    public function getGrid() {
        return $this->grid;
    }

    /**
     * Displays the Grid. Replaces dev cell notations (S,X,*) with img url tags
     */
    public function displayGrid() {
        list($currentShotI, $currentShotJ) = $this->currentShot;
        echo "<div style='margin-top:5rem; width:100%; text-align: center;'>";
        echo "<div style='display:inline-block;'>";
        for ($i=0; $i<10; $i++) {
            for ($j=0; $j<10; $j++) {
                switch($this->grid[$i][$j]) {
                    case self::shipCell:
                        echo $this->isCurrentShot($i, $j) ? self::shipCellImgTagCurrentShot : self::shipCellImgTag;
                        break;
                    case self::emptyCell:
                        echo $this->isCurrentShot($i, $j) ? self::emptyCellImgTagCurrentShot : self::emptyCellImgTag;
                        break;
                    case self::missedShotCell:
                        echo $this->isCurrentShot($i, $j) ? self::missedShotCellImgTagCurrentShot : self::missedShotCellImgTag;
                        break;
                    case self::destroyedShipCell:
                        echo $this->isCurrentShot($i, $j) ? self::destroyedShipCellImgTagCurrentShot : self::destroyedShipCellImgTag;
                        break;
                }
            }
            echo "<br />";
        }
        echo "</div></div>";
    }

    /**
     * Set of cell(s) which represent ship cells
     * @param array(s) of $cell
     * @return bool
     */
    public function setShip(...$cells) {
        foreach ($cells as $cell) {
            if($this->isEmptyCell([$cell[0], $cell[1]])) {
                $this->grid[$cell[0]][$cell[1]] = self::shipCell;
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
     * Checks if the surrounding area of a cell is not a ship (area is off grid or empty)
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
        return $this->grid[$cell[0]][$cell[1]] === self::emptyCell;
    }

    /**
     * Check if the grid cell is a missed shot cell
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    private function isMissedShotCell(array $cell) {
        return $this->grid[$cell[0]][$cell[1]] == self::missedShotCell;
    }

    /**
     * Check if the grid cell is a destroyed cell
     * @param array $cell
     * @Cell[0] - int $i grid array index
     * @Cell[1] - int $j grid array index
     * @return bool
     */
    private function isDestroyedShipCell(array $cell) {
        return $this->grid[$cell[0]][$cell[1]] == self::destroyedShipCell;
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
        $this->currentShot = [$i, $j];
        if ($this->isMissedShotCell([$i, $j])) return;
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

    /**
     * Marks cell as destroyed
     * @param int $i
     * @param int $j
     */
    private function markShipCellDestroyed(int $i, int $j) {
        $this->grid[$i][$j] = self::destroyedShipCell;
    }

    /**
     * Marks cell as missed shot
     * @param int $i
     * @param int $j
     */
    private function markMissedCell(int $i, int $j) {
        $this->grid[$i][$j] = self::missedShotCell;
    }

    /**
     * Checks if the game is over by iterating the grid and attempting to find a live ship
     * @return bool
     */
    public function isGameOver() {
        $gameOver = true;
        for ($i=0; $i<10; $i++) {
            for ($j=0; $j<10; $j++) {
                if ($this->grid[$i][$j] == self::shipCell) $gameOver = false;
            }
        }
        return $gameOver;
    }

    /**
     * Given the cell, returns true if it's the current shot, false otherwise
     * @param int $i
     * @param int $j
     * @return bool
     */
    private function isCurrentShot($i, $j) {
        return $this->currentShot == [$i, $j];
    }
}