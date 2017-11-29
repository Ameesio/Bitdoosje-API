<?php

function getEmployees()
{
    header('Content-Type: application/json');

    $conn = new mysqli('localhost', 'root', '', 'api-hrm');
    $sql = "SELECT *
            FROM personeel";
    $result = $conn->query($sql);
    $rows = array();

    while ($row = mysqli_fetch_array($result)) {
            $rows[] = array(    'ID' => $row['id'],
                                'Voornaam' => $row['voornamen'],
                                'TussenVoegsel' => $row['tussenvoegsel'],
                                'Achternaam' => $row['achternaam'],
                                'Geslacht' => $row['geslacht'],
                                'Geboorte Datum' => $row['geboorte_datum'],
                                'Email' => $row['email']);
        }
    echo json_encode($rows);
}


function getDepartements()
{
    header('Content-Type: application/json');

    $conn = new mysqli('localhost', 'root', '', 'api-hrm');
    $sql = "SELECT *
            FROM afdelingen
            JOIN personeel_afdeling ON (personeel_afdeling.afdeling_id = afdelingen.id)
            JOIN personeel ON (personeel.id = afdelingen.id)";
    $result = $conn->query($sql);
    $rows = array();

    while ($row = mysqli_fetch_array($result)) {
        $rows[] = array('Afdeling ID' => $row['id'],
                        'Afdeling Naam' => $row['dep_naam'],
                        'Leidinggevende' => $row['voornamen'] .' '. $row['tussenvoegsel'] .' '. $row['achternaam']);
    }
    echo json_encode($rows);
}

function getManagers()
{
    header('Content-Type: application/json');

    $conn = new mysqli('localhost', 'root', '', 'api-hrm');
    $sql = "SELECT *
            FROM personeel_afdeling
            JOIN personeel ON (personeel.id = personeel_afdeling.personeel_id)
            JOIN rollen ON (rollen.id = personeel_afdeling.rol_id)
            JOIN afdelingen ON (afdelingen.id = personeel_afdeling.afdeling_id)
            WHERE rollen.id <= 2";

    $result = $conn->query($sql);
    $rows = array();

    while ($row = mysqli_fetch_array($result)) {
        $rows[] = array('Manager' => $row['voornamen'] .' ' . $row['tussenvoegsel'] . ' ' . $row['achternaam'],
                        'Afdeling' => $row['dep_naam'],
                        'Positie' => $row['functienaam']);
    }
    echo json_encode($rows);
}

function getEmployeeId($apiId)
{
    header('Content-Type: application/json');

    $conn = new mysqli('localhost', 'root', '', 'api-hrm');
    $sql = "SELECT * FROM personeel
            INNER JOIN personeel_afdeling ON personeel.id = personeel_afdeling.personeel_id
            INNER JOIN afdelingen ON personeel_afdeling.afdeling_id = afdelingen.id
            INNER JOIN rollen ON personeel_afdeling.rol_id = rollen.id
            INNER JOIN salarissen ON personeel.id = salarissen.personeel_id
            INNER JOIN salarisschalen ON salarissen.salarisschaal_id = salarisschalen.id
            WHERE personeel.id = '$apiId'";
    $result = $conn->query($sql);
    $return_value = [];

    while ($row = $result->fetch_assoc()) {
        $personeelId = $row['personeel_id'];
        $personeelVoornamen = $row['voornamen'];
        $personeelTussenvoegsels = $row['tussenvoegsels'];
        $personeelAchternamen = $row['achternaam'];
        $personeelGeslacht = $row['geslacht'];
        $personeelGeboorteDatum = $row['geboorte_datum'];
        $personeelEmail = $row['email'];
        $personeelDepartement = $row['dep_naam'];
        $personeelFunctie = $row['functienaam'];
        $personeelSalaris = $row['salaris'];
        $personeelSalarisschaal = $row['naam'];

        $return_value = array(  'ID' => $personeelId,
                                'Voornaam' => $personeelVoornamen,
                                'Tussenvoegsel' => $personeelTussenvoegsels,
                                'Achternaam' => $personeelAchternamen,
                                'Geslacht' => $personeelGeslacht,
                                'Geboorte Datum' => $personeelGeboorteDatum,
                                'Email' => $personeelEmail,
                                'Afdeling' => $personeelDepartement,
                                'Functie' => $personeelFunctie,
                                'Salarisschaal' => $personeelSalarisschaal,
                                'Salaris' => $personeelSalaris);

    }
    echo json_encode($return_value);
}

function getDepartementId($apiId)
{
    header('Content-Type: application/json');

    $conn = new mysqli('localhost', 'root', '', 'api-hrm');
    $sql = "SELECT * FROM personeel
            INNER JOIN personeel_afdeling ON personeel.id = personeel_afdeling.personeel_id
            INNER JOIN afdelingen ON personeel_afdeling.afdeling_id = afdelingen.id
            INNER JOIN rollen ON personeel_afdeling.rol_id = rollen.id
            WHERE afdelingen.id = '$apiId'";
    $result = $conn->query($sql);
    $rows = array();

    while ($row = mysqli_fetch_array($result)) {
        $rows[] = array('Afdeling' => $row['dep_naam'],
                        'Voornaam' => $row['voornamen'],
                        'Functie' => $row['functienaam']);
    }
    echo json_encode($rows);
}

