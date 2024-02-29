<?php
/** Za zadatak broj.2, najbitnije metode su 'array_intersect' za pronaći vrijednosti koje se ponavljaju u više nizova, i 'array_difference' za pronaći vrijednosti koje su u samo jednom nizu. */

// Funkcija 'find' koja prima 3 argumenta i ne vraća ništa
function find($arrayA, $arrayB, $arrayC) :void {

    // pronađimo zajedničke vrijednosti
   $commonValues = array_intersect($arrayA, $arrayB, $arrayC);

    // Pronađimo vrijednosti koje su samo u '$arrayA'
    $uniqueInArrayA = array_diff($arrayA, $arrayB, $arrayC);

    // Pronađimo vrijednosti koje su samo u $arrayB
    $uniqueInArrayB = array_diff($arrayB, $arrayA, $arrayC);
   
    // Pronađimo vrijednosti koje su samo u $arrayC
    $uniqueInArrayC = array_diff($arrayC, $arrayA, $arrayB);

    // Rezultate možemo ispisati pomoću 'echo' konstrukta, PHP_EOL osigurava siguran 'line-break'
    echo "Common values: " . print_r($commonValues, true) . PHP_EOL;
    echo "Unique values in array A: " . print_r($uniqueInArrayA, true) . PHP_EOL;
    echo "Unique values in array B: " . print_r($uniqueInArrayB, true) . PHP_EOL;
    echo "Unique values in array C: " . print_r($uniqueInArrayC, true) . PHP_EOL;
}

$ourArrayA = ['a', 'b', 'c', 'dd', '234', '22', 'rc'];
$ourArrayB = ['a', 'b2', 'c', 'dad', 'rc', '24', '222'];
$ourArrayC = ['222', 'a', 'be', 'rc', 'dd', '234', '22', 'pp'];

find($ourArrayA, $ourArrayB, $ourArrayC);
?>