<?php


function addCompaniesLeads():array {

    $link = "https://{$_ENV["SUBDOMAIN"]}.amocrm.ru/api/v4/companies";

    $queryData = array(


        [
            "name" => "test"

        ]


    );

    return json_decode(connect($link, METHOD_POST, $queryData), true);



}

















