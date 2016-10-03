<?php
/**
 * List To Bootstrap Grid
 *
 * Splits a list into bootstrap-compatible rows
 * and calculates column width & last-row offset
 *
 * Usage: See README.md
 *
 * License: MIT-style license http://opensource.org/licenses/MIT
 * Authors: Techno Joy development team (www.technojoy.co.nz)
 */

class ListToBootstrapGrid extends ArrayList
{
    public function __construct(SS_List $list, $items_per_row = 3, $center = true)
    {
        if (12 % $items_per_row != 0) {
            throw new Exception('$items_per_row (' . $items_per_row . ') must divide into 12');
        }

        $this->setItemsPerRow($items_per_row);

        $this->setColWidth(12 / $items_per_row);

        $this->getRows($list, $items_per_row, $center);
    }

    public function getItemsPerRow()
    {
        return $this->items_per_row;
    }

    private function setItemsPerRow($width)
    {
        $this->items_per_row = $width;
    }

    public function getColWidth()
    {
        return $this->col_width;
    }

    private function setColWidth($width)
    {
        $this->col_width = $width;
    }

    private function getRows($list, $items_per_row, $center)
    {
        $count = 0;

        foreach ($list as $item) {
            $count++;

            if ($count == 1) { // create new row
                $rowobj = ArrayData::create(
                    array(
                        'Width' => $this->getColWidth(),
                        'Offset' => 0,
                        'Items' => ArrayList::create()
                    )
                );
                $this->add($rowobj);
            }

            $rowobj->Items->push($item);

            if ($count == $this->getItemsPerRow()) {
                $count = 0; // start new row with next result
            }
        }

        /* Create Offset to center-align remaining uneven row */
        if ($center) {
            $last_row = $this->last();
            $last_row_count = $last_row->Items->Count();
            if ($last_row && $last_row_count != $this->getItemsPerRow()) {
                $offset = ($this->getItemsPerRow() - $last_row_count) / 2 * $this->getColWidth();
                $last_row->Offset = $offset;
            }
        }
    }
}
