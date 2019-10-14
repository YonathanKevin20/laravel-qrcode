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