<?php

class WallysWidgetsCalculator
{
    /**
     * Your solution should return an array with the pack sizes as the key
     * and the number of packs in that size as the value.
     *
     * Pack sizes that are not required should not be included.
     *
     * Example:
     *
     * getPacks(251, [
     *  250,
     *  500,
     *  1000
     * ])
     *
     * should return:
     *
     * [500 => 1]
     */

    public function getPacks(int $widgetsRequired, array $packSizes)
    : array
    {
        if(count($packSizes)<1){
            $packSizes = array(250,500,1000,2000,5000);
        }
        
        sort($packSizes);
        $packSizes2 = array_reverse($packSizes);
        $packCounts = array();
        $sum=0;
            
        $packLength = count($packSizes);

        // Count widgets using Greedy approach
        for ($i = 0; $i < $packLength; $i++)
        {
            if(!isset($packCounts[$i])){
                $packCounts[$i]=0;
            }
            if ($widgetsRequired > $packSizes2[$i])
            {
                $packCounts[$i] = intval($widgetsRequired /
                                        $packSizes2[$i]);
                $widgetsRequired = $widgetsRequired -
                        $packCounts[$i] *
                        $packSizes2[$i];
                $sum=$sum+$packCounts[$i] *
                $packSizes2[$i];
            }
        }	
        // Add the last pack remaining
        for ($i = 0; $i < $packLength; $i++)
        {
            if ($widgetsRequired !=0 && $widgetsRequired < $packSizes[$i]){
                $packCounts[$packLength-$i-1]+=1;
                $sum=$sum+$packSizes[$i];
                break;
            }
        }

        // Filtering to use least number of packs
        for ($i = 0; $i < $packLength-1; $i++){
            if ( $i!=0 && $packCounts[$i+1]==2 && $packSizes2[$i]==2*$packSizes2[$i+1]){
                $packCounts[$i+1]=$packCounts[$i+1]-2;
                $packCounts[$i]=$packCounts[$i]+1;
            }
        }

       // The following is basically array_combine(), but skipping key-value pairs with value 0
        $result = array();
        foreach ($packSizes2 as $i => $k) {
            if($packCounts[$i] == 0)
                continue;
            $result[$k][] = $packCounts[$i];
        }
        array_walk($result, function(&$v){
        $v = (count($v) == 1) ? array_pop($v): $v;
        });
        return $result;

    

    }
}
