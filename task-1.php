<?php
/** 
 * Write a function which returns the closest numbers from a sequence based on an input number
 */

function getClosestNumbers($options, $number): array {

    $absoluteDifference = array_map(function($option) use ($number) {
        return abs($option - $number);
    }, $options);
    error_log("Absolute difference: " . print_r($absoluteDifference, true));

    $combinedArray = array_combine($options, $absoluteDifference);
    error_log("Combined array: " . print_r($combinedArray, true));

    $minimumDifference = min($combinedArray);
    error_log("Minimum difference numbers: " . print_r($minimumDifference, true));

    $closestNumbers = array_keys($combinedArray, $minimumDifference);
    error_log("Final array containing our result: " . print_r($closestNumbers, true));

    return $closestNumbers;
}

const sequence = [-908, -852, -475, -355, -102, -100, -55, -25, -18, -7, -6, -5, 0, 1, 7, 8, 99, 101, 122, 147, 5025, 5334, 7410];

$exampleOne = getClosestNumbers(sequence, 90);
$exampleTwo = getClosestNumbers(sequence, 100);

error_log("Result One: " . print_r($exampleOne, true));
error_log("Result Two: " . print_r($exampleTwo, true));
?>
