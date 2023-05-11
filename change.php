<?php
    const ROOT = __DIR__;

    require ROOT . "/../integration-amoCRM/classes/connectionMySQL.php";
    require ROOT . "/functions/require.php";

    $DB = new ConnectMySQL(null);

    use League\Csv\Reader;

    $csv = Reader::createFromPath("ta.csv", "r");

    $records = $csv->getRecords();

    foreach ($records as $value) {

        $value[1] = trim($value[1]);

        // $value[0] - id Компании
        // $value[1] - Имя ответственного

        $getUsers = getUsers();


        foreach ($getUsers["_embedded"]["users"] as $userName) {

            if ($userName["name"] == $value[1]) {

                $res = entityRelation(CRM_ENTITY_COMPANY, $value[0]);


                if (!empty($res)) {
                    $DB->DB->query("UPDATE auto_tasks SET last_task_with_result = ? WHERE (last_task_with_result is not null) and (last_task_status = ?) and (company_id = ?)", [strval(time()), "unset", $value[0]]);



                    editEntity(CRM_ENTITY_COMPANY, $value[0], $userName["id"]);



                    getTasks(CRM_ENTITY_COMPANY, $value[0]);



                    if (!empty($res["_embedded"]["links"])) {

                        foreach ($res["_embedded"]["links"] as $linkValue) {

                            if ($linkValue["to_entity_type"] == "contacts") {

                                editEntity(CRM_ENTITY_CONTACT, $linkValue["to_entity_id"], $userName["id"]);

                                getTasks(CRM_ENTITY_CONTACT, $linkValue["to_entity_id"]);


                            } else {
                                if ($linkValue["to_entity_type"] == "leads") {

                                    editEntity(CRM_ENTITY_LEAD, $linkValue["to_entity_id"], $userName["id"]);

                                    getTasks(CRM_ENTITY_LEAD, $linkValue["to_entity_id"]);


                                }
                            }
                        }

                    }

                }

            }
        }

        finishValue($value);

    }

