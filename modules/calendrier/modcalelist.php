<?php
$Dossier = "../../";
include $Dossier . 'header.php';
?>

<?php

function getDB()
{
    $bdd = new PDO('mysql:host=localhost;dbname=gestion_equimondo', 'non-root', 'Equi14Mondo');

    if ($bdd->errorCode()) {
        die("Connection failed: " . $bdd->errorCode());
    }

    return $bdd;
}

function getCalNum()
{
    $id_calendar = $_SESSION['hebeappnum'];

    $sql = "SELECT calenum FROM calendrier WHERE AA_equimondo_hebeappnum = :id_calendar";

    $query = getDB()->prepare($sql);
    $query->bindParam('id_calendar', $id_calendar);
    $query->execute();

    return $query->fetch(PDO::FETCH_OBJ);
}

function getMonitors()
{
    $utiltype = 1;
    $items = [];

    $req = 'SELECT utilnum,utilnom,utilprenom,utilville FROM utilisateurs WHERE utiltype = "' . $utiltype . '" AND AA_equimondo_hebeappnum = "' . $_SESSION['hebeappnum'] . '" AND utilsupp = "1" ORDER BY utilnom ASC';

    $reqResult = getDB()->query($req) or die ('Erreur SQL !' . $req . '<br />' . mysqli_error());
    while ($reqAffich = $reqResult->fetch()) {
        $name = $reqAffich[1] . " " . $reqAffich[2];
        if (!empty($reqAffich[3])) {
            $name .= " (" . $reqAffich[3] . ")";
        }
        $items[] = [
            'value' => $reqAffich[0],
            'name' => $name
        ];

    }

    return $items;
}

function getDiscipline()
{
    $req = 'SELECT * FROM calendrier_discipline_configuration WHERE AA_equimondo_hebeappnum = "' . $_SESSION['hebeappnum'] . '" ORDER BY calediscconflibe ASC';
    $reqResult = getDB()->query($req);
    $get_num = getCalNum();
    $num = $get_num ? $get_num->calenum : false;

    $items = [];

    if ($num) {
        while ($reqAffich = $reqResult->fetch()) {
            $items[] = [
                'value' => $reqAffich['calediscconflibe'],
                'name' => $reqAffich['calediscconflibe']
            ];
        }
    }

    return $items;
}

function getInstallation(){
    $items = [];

    $req = 'SELECT instlibe, instnum FROM installations WHERE instsupp="1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY instlibe ASC';
    $reqResult = getDB()->query($req);
    while($reqAffich = $reqResult->fetch())
    {
        $items[] = [
            'value' => $reqAffich['instlibe'],
            'name' => $reqAffich['instlibe']
        ];
    }

    return $items;
}
ob_start();

$disciplines = getDiscipline();
$monitors = getMonitors();
$installations = getInstallation();

$view_calendar = $_SERVER['DOCUMENT_ROOT'] . '/modules/calendrier/views/calendrier.php';
require_once $view_calendar;

echo ob_get_clean();

?>

<?php include $Dossier . "footer.php"; ?>
