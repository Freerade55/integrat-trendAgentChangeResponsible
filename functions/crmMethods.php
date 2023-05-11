<?php


function entityRelation(string $entity_type, int $id): array
{
    switch ($entity_type) {
        case CRM_ENTITY_CONTACT:
            $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/contacts/$id/links";
            break;
        case CRM_ENTITY_LEAD:
            $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/leads/$id/links";
            break;
        case CRM_ENTITY_COMPANY:
            $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/companies/$id/links";
            break;
    }


    $result = json_decode(connect($link), true);

    if (empty($result)) {
        return [];
    } else {
        return $result;
    }


}







function editEntity(string $entity_type, int $id, int $userId)
{
    switch ($entity_type) {
        case CRM_ENTITY_CONTACT:
            $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/contacts/$id";
            break;
        case CRM_ENTITY_LEAD:
            $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/leads/$id";
            break;

        case CRM_ENTITY_COMPANY:
            $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/companies/$id";


    }


    $queryData = array(

          "responsible_user_id" => $userId


    );


    connect($link, METHOD_PATCH, $queryData);



}



function getTasks(string $entity_type, int $id) {


    switch ($entity_type) {
        case CRM_ENTITY_CONTACT:
            $entity_type = "contacts";
            break;
        case CRM_ENTITY_LEAD:
            $entity_type = "leads";
            break;

        case CRM_ENTITY_COMPANY:
            $entity_type = "companies";
            break;



    }


    $query = [
        "filter" => [
        "entity_type" => $entity_type,
        "entity_id" => $id,
        "is_completed" => 0
    ]
    ];


    $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/tasks?" . http_build_query($query);

    $result = json_decode(connect($link), true);

    if (!empty($result)) {
        foreach ($result["_embedded"]["tasks"] as $value) {

            editTask($value["id"]);
        }

    }



}



function editTask(int $id) {

    $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/tasks/$id";

    $queryData = array(

    "task_type_id" => 2767106

    );

    connect($link, METHOD_PATCH, $queryData);



}



function getUsers() {


    $query = [
        "limit" => 200
    ];


    $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/users?" . http_build_query($query);

    $result = json_decode(connect($link), true);


    return $result;
}







