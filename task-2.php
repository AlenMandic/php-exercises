<?php
/**
 * From different sequences, find values which are in all 3 sequences, and values which are in only one sequence.
 */

function find($arrayA, $arrayB, $arrayC) :void {

   $commonValues = array_intersect($arrayA, $arrayB, $arrayC);

    $uniqueInArrayA = array_diff($arrayA, $arrayB, $arrayC);

    $uniqueInArrayB = array_diff($arrayB, $arrayA, $arrayC);
   
    $uniqueInArrayC = array_diff($arrayC, $arrayA, $arrayB);

    echo "Zajedničke vrijednosti: " . print_r($commonValues, true) . PHP_EOL;

    echo "Jedinstvene vrijednosti u nizu A: " . print_r($uniqueInArrayA, true) . PHP_EOL;
    echo "Jedinstvene vrijednosti u nizu B: " . print_r($uniqueInArrayB, true) . PHP_EOL;
    echo "Jedinstvene vrijednosti u nizu C: " . print_r($uniqueInArrayC, true) . PHP_EOL;
}

$ourArrayA = ['a', 'b', 'c', 'dd', '234', '22', 'rc'];
$ourArrayB = ['a', 'b2', 'c', 'dad', 'rc', '24', '222'];
$ourArrayC = ['222', 'a', 'be', 'rc', 'dd', '234', '22', 'pp'];

find($ourArrayA, $ourArrayB, $ourArrayC);

?>