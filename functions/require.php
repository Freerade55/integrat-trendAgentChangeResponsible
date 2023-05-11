<?php

const
CRM_ENTITY_LEAD = "lead",
CRM_ENTITY_CONTACT = "contact",
CRM_ENTITY_COMPANY = "company",

METHOD_GET = "GET",
METHOD_POST = "POST",
METHOD_PATCH = "PATCH";


require ROOT . "/functions/display-errors.php";
require ROOT . "/vendor/autoload.php";
require ROOT . "/logs/logs.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

require ROOT . "/functions/connectToCrm.php";
require ROOT . "/functions/refreshToken.php";
require ROOT . "/functions/crmMethods.php";
require ROOT . "/once/testCompaniesLeads.php";
