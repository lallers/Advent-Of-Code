<?php
$data = explode(",", file_get_contents("./data/day_04.txt"));

$data = setup_data($data);

$guard_data = setup_guards($data);
#print_r($guard_data);

$guard_data = check_asleep_total($guard_data);


$bad_elf = most_minutes_slept($guard_data);

$baddest_elf = frequency_of_sleep($guard_data);

echo ("Most minutes slept by Guard <b>" . $bad_elf[0] . "</b> with <b>" . $bad_elf[1] . "</b> minutes slept... The longest duration started at minute <b>" . $bad_elf[2] . "</b>! <br>");
echo ("Result A: <b>" . $bad_elf[3] . "</b><br>");
echo("<br>");
echo ("Frequency of minute slept by Guard <b>" . $baddest_elf[0] . "</b>, sleeping <b>" . $baddest_elf[1] . "</b> times during the <b>". $baddest_elf[2]."</b> minute<br>");
echo ("Result B: <b>" . $baddest_elf[3] . "</b><br>");


function setup_data($data)
{
    usort($data, 'check_timestamp');
    return $data;
}
function check_timestamp($a, $b)
{
    $t1 = get_timestamp($a);
    $t2 = get_timestamp($b);
    if ($t1 == $t2) {
        return 0;
    }
    return ($t1 < $t2) ? -1 : 1;
}

function get_timestamp($item, $minutes = false)
{
    preg_match("/\[([^\]]*)\]/", $item, $match);
    $tmp = $match[1];
    if ($minutes == true) {
        $tmp = explode(" ", $tmp);
        $tmp = explode(":", $tmp[1]);
        $tmp = $tmp[1];
        return (int)$tmp;
    }
    return $tmp;
}
function get_details($item)
{

    return trim(substr($item, strpos($item, "]") + 1));

}

function setup_guards($data)
{
    $guard_data = [];
    foreach ($data as $item) {

        $details = get_details($item);
        $sub_details = substr($details, 0, 1);
        if ($sub_details == "G") {
            $guard_id = format_guard_id($details);
            if (!isset($guard_data[$guard_id])) {
                $guard_data[$guard_id]['details'] = [];
                $guard_data[$guard_id]['asleep_for'] = [];
            }
        } else {
            $guard_data[$guard_id]['details'][] = $item;
        }
    }
    return $guard_data;
}
function format_guard_id($item)
{
    $item = str_replace("begins shift", "", $item);
    $item = str_replace(" #", "", $item);
    return $item;
}
function is_asleep($item)
{
    return strpos($item, "falls asleep");
}

function check_asleep_total($guards)
{

    foreach ($guards as $guard_key => $guard) {
        $start_sleep = 0;
        $sleep_end = 0;
        $most_minutes = 0;
        $ppp_sleep = false;
        $working_period = array_fill(0, 60, 0);
        foreach ($guard['details'] as $detail_key => $detail) {
            if (is_asleep($detail)) {
                $start_sleep = get_timestamp($detail, true);
                $ppp_sleep = true;
            } else {
                if (!$ppp_sleep = true) {
                    echo ("SOMETHING WRONG<br>");
                } else ($ppp_sleep = false);
                $sleep_end = get_timestamp($detail, true);
                #echo("<br>".$sleep_end);
                $total_sleep = $sleep_end - $start_sleep;

                for ($i = $start_sleep; $i < $sleep_end+1; $i++) {

                    $working_period[$i] += 1;
                }
                #echo ($guard_key . ' ' . $start_sleep . " -> " . $sleep_end . " = " . $total_sleep . "<br>");
                #if ($total_sleep > $most_minutes) {
                #    $most_minutes = $total_sleep;
                #    $guards[$guard_key]["most_minutes_slept"] = $start_sleep;
                #}
                $guards[$guard_key]["asleep_for"][] = $total_sleep;
            }
        }

        $max_times_minute = array_keys($working_period, max($working_period));
        $max_times_minute = $max_times_minute[0];
        /* FOR PART B */
        $guards[$guard_key]["most_frequent_slept"] = $working_period;
        /* END PART B */
        $guards[$guard_key]["most_minutes_slept"] = $max_times_minute;
        $guards[$guard_key]["total_asleep_for"] = array_sum($guards[$guard_key]["asleep_for"]);

    }
    return $guards;
}

function most_minutes_slept($guards)
{
    $result = ["Guard", 0, 0, 0];
    foreach ($guards as $guard_key => $guard) {

        $total = $guard['total_asleep_for'];

        if ($total > $result[1]) {
            $guard_id = (int)str_replace("Guard", "", $guard_key);
            if (isset($guard['most_minutes_slept'])) {
                $most_minutes = $guard['most_minutes_slept'];
            } else {
                $most_minutes = 0;
            }

            $out = $guard_id * $most_minutes;
            $result = [$guard_id, $total, $most_minutes, $out];
        }

    }
    return $result;
}

function frequency_of_sleep($guards)
{
    $result = ["Guard", 0, 0, 0];
    $most_mins = 0;
    foreach ($guards as $guard_key => $guard) {
        $freq = $guards[$guard_key]["most_frequent_slept"];
        
        $guard_id = (int)str_replace("Guard", "", $guard_key);
        $max = max($freq);
        
        $most_mins_g = array_keys($freq, $max);
        
        $most_mins_g = $most_mins_g[0];
        
        if ($max > $most_mins) {
            $most_mins = $max;
            $out = $most_mins_g * $guard_id;
            $result = [$guard_id,$max, $most_mins_g, $out];
        }
    }
    
    return $result;
}










?>