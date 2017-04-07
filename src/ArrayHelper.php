<?php

/**
 * Class ArrayHelper
 */

class ArrayHelper {

    /**
     * Flatten a multidimensional array
     *
     * @param array $multiDimensionalArray
     * @return array
     */
    public function flatten($multiDimensionalArray = []) {

        if (!$multiDimensionalArray or !is_array($multiDimensionalArray)) throw new InvalidArgumentException;

        $flattenedArray = [];

        array_walk_recursive($multiDimensionalArray, function($item) use (&$flattenedArray) {
            $flattenedArray[] = $item;
        });

        return $flattenedArray;

    }
}