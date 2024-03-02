<?php
// Funkcija koja uzima 2 argumenta i vraća niz
function getClosestNumbers($options, $number): array {

    //'array_map' metoda će stvoriti novi niz brojeva uz anonimnu callback funkciju koja ce izračunati apsolutnu razliku između brojeva i broja kojeg tražimo.
    $absoluteDifference = array_map(function($option) use ($number) {
        return abs($option - $number);
    }, $options);
    error_log("Absolute difference: " . print_r($absoluteDifference, true));

    // Novi niz kao kombinacija nizova '$options' i '$absoluteDifference'
    $combinedArray = array_combine($options, $absoluteDifference);
    error_log("Combined array: " . print_r($combinedArray, true));

    //'min' metoda će pronaći najmanju razliku između brojeva.
    $minimumDifference = min($combinedArray);
    error_log("Minimum difference numbers: " . print_r($minimumDifference, true));

    //'array_keys' metoda će iz '$combinedArray' niza izvuć vrijednosti koje su jednake '$minimumDifference'
    $closestNumbers = array_keys($combinedArray, $minimumDifference);
    error_log("Final array containing our result: " . print_r($closestNumbers, true));

    return $closestNumbers;
}

// Primjer niza
const sequence = [-908, -852, -475, -355, -102, -100, -55, -25, -18, -7, -6, -5, 0, 1, 7, 8, 99, 101, 122, 147, 5025, 5334, 7410];

$exampleOne = getClosestNumbers(sequence, 90);
$exampleTwo = getClosestNumbers(sequence, 100);

// Prikaz rezultata
error_log("Result One: " . print_r($exampleOne, true));
error_log("Result Two: " . print_r($exampleTwo, true));
?>
