<?php

//print the array for testing purposes
function printArray($arrayToSort) {
    foreach($arrayToSort as $row) {
        foreach($row as $item) {
            echo $item . " ";
        }
        echo "<br>";
    }
    echo "<br>";
}

//defining the biggest number of the array
function findBiggestNumber($array) {
    $biggestNumber = 0;
    foreach ($array as $row) {
        foreach ($row as $item) {
            if($item > $biggestNumber)
                $biggestNumber = $item;
        }
    }

    return $biggestNumber;
}

//searching for the biggest number in the array
//returns an array of indices, the indices are corrected for the task at hand
function indicesOfBiggestNumber($array,$biggestNumber) {

    foreach ($array as $arrayKey => $row) {
        foreach ($row as $rowKey => $item) {
            if($item == $biggestNumber)
                $indices[]= [$arrayKey+2,$rowKey+1];
        }
    }
    return $indices;
}

//sums indices
function sumIndices($array) {
    $return = 0;
    array_walk_recursive($array, function($value) use (&$return){$return+=$value;});
        return $return;
}


//$arrayToSort = [[7,2,9],[9,2,5],[3,6,9]];
$arrayToSort = '{"1":{"1":5,"2":1,"3":3,"4":7,"5":4,"6":6,"7":8,"8":2,"9":9},"2":{"1":4,"2":2,"3":9,"4":2,"5":9,"6":3,"7":4,"8":7,"9":4},"3":{"1":1,"2":8,"3":1,"4":4,"5":2,"6":4,"7":9,"8":8,"9":5},"4":{"1":5,"2":8,"3":2,"4":5,"5":6,"6":9,"7":4,"8":6,"9":2},"5":{"1":6,"2":1,"3":4,"4":1,"5":2,"6":5,"7":6,"8":3,"9":5},"6":{"1":6,"2":9,"3":2,"4":1,"5":9,"6":8,"7":4,"8":6,"9":2},"7":{"1":9,"2":4,"3":1,"4":8,"5":9,"6":2,"7":5,"8":5,"9":9},"8":{"1":4,"2":2,"3":7,"4":5,"5":3,"6":6,"7":2,"8":6,"9":8},"9":{"1":4,"2":5,"3":7,"4":8,"5":4,"6":7,"7":9,"8":4,"9":4}}
';

//decoding json, the last parameter formats the return value of the function into an array
$arrayToSort = json_decode($arrayToSort, true);

printArray($arrayToSort);


//sorting the first row
$firstRow = array_shift($arrayToSort);
asort($firstRow);


//setting up the array acording to which the array will be sorted
$keysToSortBy = array_keys($firstRow);
$arrayToSortBy = [];
foreach ($keysToSortBy as $position=>$key) {
    $arrayToSortBy[$key] = $position+1;
}

//sorting the whole array using foreach and and a "user key sort" function
foreach($arrayToSort as $key=>$value) {
    uksort($arrayToSort[$key],
        function($a, $b) use ($arrayToSortBy) {
            return $arrayToSortBy[$a] < $arrayToSortBy[$b] ? -1 : 1;

        });
}

//normalizing keys so they can be summed up
foreach($arrayToSort as $rowKey => $row) {
    foreach ($row as $itemKey => $item) {
        $arrayToSortWithNormalizedKeys[$rowKey][]=$item;
    }
}

printArray($arrayToSortWithNormalizedKeys);


$biggestNumber  = findBiggestNumber($arrayToSortWithNormalizedKeys);

$indices = indicesOfBiggestNumber($arrayToSortWithNormalizedKeys,$biggestNumber);



echo sumIndices($indices);
