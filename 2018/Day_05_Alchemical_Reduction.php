<?php 

/* Candidate for better optimization! */

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $data = file_get_contents("./data/day_05.txt");
    switch ($action) {
        case 'a':
            part_a($data);
            break;
        case 'b':
            part_b($data);
            break;
    }
}

function part_b($data)
{
    $unique_chars = [];
    $data = str_split($data);
    $shortest_polymer = [99999999999, "letter"];
    foreach ($data as $letter) {
        $_letter = strtolower($letter);
        if (!in_array($_letter, $unique_chars)) {
            $unique_chars[] = $letter;
        }
    }
    $stop = 1;
    foreach ($unique_chars as $char) {
        $tmp = [];
        $tmp = remove_problem($data, $char);
        [$result, $result_len] = doStuff($tmp);
        if ($result_len < $shortest_polymer) {
            $shortest_polymer[0] = $result_len;
            $shortest_polymer[1] = $char;
        }
        $stop +=1;
        if($stop == 21){
            break;
        }
    }
    echo("Total unique polymers: ".count($unique_chars)."<br>");
    echo ("Shortest Polymer: <b>" . $shortest_polymer[1] . "</b> with chain length <b>" . $shortest_polymer[0] . "</b><br>");
    #echo ($result);
}

function part_a($data)
{
    [$result, $result_len] = doStuff($data);

    echo ("<h1>Result: </h1>" . $result);
    echo ("<h1>Size: " . $result_len . "</h1>");
}

function doStuff($data, $iter = 0, $result_len = 0)
{
    $check_again = true;

    while ($check_again == true) {
        $result = "";
        $chunks = explode("\n", trim(chunk_split($data, 1000)));
        if ($iter == 0) {
            #echo ("Original Size: " . strlen($data) . "<br>");
        };
        foreach ($chunks as $chunk) {
            $result .= analyze_string($chunk);
        }

        if (verify_string($result)) {
            $result_len = strlen($result);
            #echo ("<h1>Result: </h1>" . $result);
            #echo ("<h1>Size: " . $result_len . "</h1>");
            $check_again = false;
        } else {
            $data = $result;
            $iter += 1;
        }
    }
    return [$result, $result_len];
}


function analyze_string(&$input, &$analyze_again = false)
{
    $analyze_again = true;
    while ($analyze_again == true) {
        $input = str_split($input);
        $target_index = [];
        $position = 0;
        $found_antipair = false;
        for ($i = $position; $i < count($input) - 1; $i++) {
            $current_letter = $input[$i];
            $next_letter = $input[$i + 1];
            if ($current_letter != "*" || $next_letter != "*") {
                if (antipairs($current_letter, $next_letter)) {
                    $input[$i] = "*";
                    $input[$i + 1] = "*";
                    $found_antipair = true;
                }
            }
            $position += 1;
        }
        $input = remove_anitpairs($input);
        if ($found_antipair == false) {
            $analyze_again = false;
        }
    }

    $result = $input;
    return $result;
}

function check_targets($targets, &$array)
{

    foreach ($targets as $target) {

        if (!in_array($target, $array)) {
            array_push($array, $target);
        }
    }
    return $array;
}

function antipairs($a, $b)
{

    $_a = strtolower($a);
    $_b = strtolower($b);
    $a_ = ctype_upper($a);
    $b_ = ctype_upper($b);
    if ($_a == $_b) {
        if (!$a_ == $b_) {

            return true;
        } else {

            return false;
        }
    } else {
        return false;
    }
}
function remove_anitpairs($input)
{
    $input = join("", $input);
    $input = trim(str_replace("*", "", $input));
    return $input;
}

function verify_string($input)
{

    $input = str_split($input);
    $position = 0;
    for ($i = $position + 1; $i < count($input) - 1; $i++) {
        $current_letter = $input[$position];
        $next_letter = $input[$i];
        if (antipairs($current_letter, $next_letter)) {
            #echo ("Match: " . $current_letter . ", " . $next_letter);

            return false;
        } else {
            $position += 1;
        }
    }
    return true;

}

function remove_problem($array, $item)
{
    $a = strtolower($item);

    foreach ($array as $key => $letter) {
        $b = strtolower($letter);
        if ($a == $b) {
            $array[$key] = "*";
        }
    }
    return trim(str_replace("*", "", join("", $array)));
}


?>