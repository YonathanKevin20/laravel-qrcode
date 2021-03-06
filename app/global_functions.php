<?php
function listMonths() {
    $months = array(
        array('text' => 'January', 'value' => 1),
        array('text' => 'February', 'value' => 2),
        array('text' => 'March', 'value' => 3),
        array('text' => 'April', 'value' => 4),
        array('text' => 'May', 'value' => 5),
        array('text' => 'June', 'value' => 6),
        array('text' => 'July', 'value' => 7),
        array('text' => 'August', 'value' => 8),
        array('text' => 'September', 'value' => 9),
        array('text' => 'Oktober', 'value' => 10),
        array('text' => 'November', 'value' => 11),
        array('text' => 'December', 'value' => 12)
    );
    return $months;
}

function listYears() {
    $years = App\Models\Presence::select(['year'])->groupBy('year')->pluck('year');
    return $years;
}

function weekOfMonth($check_in) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date('Y-m-01', $check_in));
    //Apply above formula.
    return intval(date('W', $check_in)) - intval(date('W', $firstOfMonth)) + 1;
}

function getWeeks($date, $rollover) {
    $cut = substr($date, 0, 8);
    $daylen = 86400;

    $timestamp = strtotime($date);
    $first = strtotime($cut . "00");
    $elapsed = ($timestamp - $first) / $daylen;

    $weeks = 1;

    for($i = 1; $i <= $elapsed; $i++) {
        $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
        $daytimestamp = strtotime($dayfind);

        $day = strtolower(date("l", $daytimestamp));

        if($day == strtolower($rollover)) $weeks++;
    }

    return $weeks;

    // echo getWeeks("2011-06-11", "sunday");
}