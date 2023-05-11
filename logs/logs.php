<?php
//
////// логи
//
function logs()
{
    if (file_exists(ROOT . "/hook.json")) {
        $log = file_get_contents(ROOT . "/hook.json");
        $log = json_decode($log, true);
    } else {
        $log = [];
    }

    $t = explode(" ",microtime());
    $log[date("Y-m-d H:i:s", $t[1]).substr((string)$t[0],1,4)] = $_REQUEST;
    $log = json_encode($log, JSON_UNESCAPED_UNICODE);
    file_put_contents(ROOT . "/hook.json", $log);
}

function finishValue($data) {
    $finishJson = file_get_contents(ROOT . "/finishValues.json");
    $finishJson = json_decode($finishJson, true);

    $t = explode(" ",microtime());
    $finishJson[date("Y-m-d H:i:s", $t[1]).substr((string)$t[0],1,4)] = $data;
    $finishJson = json_encode($finishJson, JSON_UNESCAPED_UNICODE);
    file_put_contents(ROOT . "/finishValues.json", $finishJson);





}
