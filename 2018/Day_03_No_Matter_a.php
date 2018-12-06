<?php

/*
This is super messy and highly unoptimized -- need to revisit
*/



$data = file_get_contents("./data/day_03.txt");
$output = doStuff($data);

function doStuff($input)
{
    $input = explode('+', $input);
    $fabric = [];
    $total_matches = 0;
    $all_claims = get_claims($input);
    foreach ($input as $item) {
        $tmp = preg_split("/[@:]/", $item);

        $tmp_claim = str_replace("#", "", $tmp[0]);
        $tmp_pos = preg_split("/[,]/", $tmp[1]);
        $tmp_size = preg_split("/[x]/", $tmp[2]);

        $left = (int)$tmp_pos[0];
        $top = (int)$tmp_pos[1];

        $width = (int)$tmp_size[0];
        $height = (int)$tmp_size[1];

        $this_match_has_overlap = false;
        $has_overlap = false;
        for ($k = 0; $k < $height; $k++) {
            $top_pos = $top + $k;
            for ($i = 0; $i < $width; $i++) {
                $left_pos = $left + $i;
                $position = "L" . $left_pos . "T" . $top_pos;
                if (isset($fabric[$position])) {
                    if (check_for_overlap($fabric[$position])) {
                        $fabric[$position] .= "," . $tmp_claim;
                       
                    } else {
                        $b =  $fabric[$position];
                        $fabric[$position] = "X::".$b.",". $tmp_claim;
                    }
                } else {
                    $fabric[$position] = $tmp_claim;
                }
            }
        }
    }
    foreach ($fabric as $locations) {
        if (check_for_overlap($locations)) {
            $total_matches += 1;
        }
    }

    $perfect_match = find_perfect_match($fabric, $all_claims);

    if ($total_matches > 0) {
        echo ("<br>Total Matches: <strong>" . $total_matches . "</strong>");
    } else {
        echo ("<br>Something is wrong... you broke it. There are no matches... assuming there's supposed to be matches... hmmm.");
    }
    echo("<br> Perfect Claim: ".$perfect_match);

}

function check_for_overlap($input)
{
    if (substr($input, 0, 1) === "X") {
        return true;
    } else {
        return false;
    }
}

function get_claims($input)
{
    $claims = [];
    foreach ($input as $item) {
        $tmp = preg_split("/[@:]/", $item);
        $claim = str_replace("#", "", $tmp[0]);
        array_push($claims, $claim);

    }
    return $claims;

}

function check_null($var)
{
    return (!($var === null));
}

function find_perfect_match($fabric, $all_claims)
{
    $perfect_vals = [];
    $overlap_vals = [];
    foreach ($fabric as $item) {
        if (check_for_overlap($item)) {
            $tmp = str_replace("X::", "", $item);
            $claims = explode(",", $tmp);
            foreach ($claims as $claim) {
                if (!in_array($claim, $overlap_vals)) {
                    array_push($overlap_vals, $claim);
                }
            }
        }
    }
    foreach ($overlap_vals as $matches) {
        $key = array_search($matches,$all_claims);
        if($key){
            unset($all_claims[$key]);
        }
    }
    foreach($all_claims as $claim){
        $perfect_claim[] = $claim;
    }
    return $perfect_claim[1];
}


?>