<?php

function generatorCombinations($from, $by)
{
    $comb = range(0, $by - 1);
    yield $comb;
    $max = $from - 1;
    $last_index = $by - 1;
    while ($comb[0] != $max - $last_index) {
        $min = $comb[$last_index];
        for ($i = $min + 1; $i <= $max; $i++) {
            $comb[$last_index] = $i;
            yield $comb;
        }
        $j = 0;
        for ($i = $last_index; $i >= 0; $i--) {
            if ($comb[$i] < $max - $j) {
                $comb[$i]++;
                for ($k = $i + 1; $k<=$last_index; $k++) {
                    $comb[$k] = $comb[$k-1] + 1;
                }
                yield $comb;
                break;
            }
            $j++;
        }
    }
}

function generatorPermutations($array)
{
    $last_permutation = FALSE;
    do {
        yield $array;
        $nextPermutation = [];
        $n = count($array);
        $i = 1;
        $tail = [];
        while ($i < $n and empty($tail)) {
            if ($array[$n - $i] > $array[$n-$i-1]) {
                $tail = array_slice($array, -$i);
            }
            $i++;
        }
        if (empty($tail))
           $last_permutation = TRUE; 
        else {
            $tail = array_reverse($tail);
            foreach ($tail as $key => $elem) {
                if ($elem > $array[$n-$i]) {
                    $reserve = $array[$n-$i];
                    $array[$n-$i] = $elem;
                    $tail[$key] = $reserve;
                    break;
                }
            }
            array_splice($array, -$i + 1, $n, $tail);
        }
    } while (!$last_permutation);
}

function getAllCombWithPerm($from, $by)
{
    foreach (generatorCombinations($from, $by) as $combination) {
        yield from generatorPermutations($combination);
    }
}
