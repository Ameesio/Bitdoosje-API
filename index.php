<?php
@include_once('app/HttpStatus.php');
@include_once('app/apifunctions.php');

if(!isset($_POST['cmd'])) {
    HttpStatus::http_return(405);
}

switch($_POST['cmd']) {

    case 'employees':
        getEmployees();
        break;

    case 'departements':
        getDepartements();
        break;

    case 'managers':
        getManagers();
        break;

    case 'employee':
        getEmployeeId($_POST['apiId']);
        break;

    case 'departement':
        getDepartementId($_POST['apiId']);
        break;

    default:

        HttpStatus::http_return(404);
}







