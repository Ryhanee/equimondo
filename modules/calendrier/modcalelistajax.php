<?php
session_start();
$is_ajax = isset($_POST['ajax_enabled']) ? $_POST['ajax_enabled'] : false;

if ($is_ajax) {
    echo getCurrentCalendar();
    exit;
}

function getDB()
{
    $bdd = new PDO('mysql:host=localhost;dbname=gestion_equimondo', 'non-root', 'Equi14Mondo');

    if ($bdd->errorCode()) {
        die("Connection failed: " . $bdd->errorCode());
    }

    return $bdd;
}

function getCurrentCalendar()
{
    $start = isset($_POST['start']) ? $_POST['start'] : false;
    $end = isset($_POST['end']) ? $_POST['end'] : false;
    $monitors = isset($_POST['monitors']) ? $_POST['monitors'] : false;
    $discipline = isset($_POST['discipline']) ? $_POST['discipline'] : false;
    $installation = isset($_POST['installation']) ? $_POST['installation'] : false;

    $id_calendar = $_SESSION['hebeappnum'];

    $sql = "SELECT calenum,caledate1,caletext13,caledate2,calendrier_categorie_calecatenum FROM calendrier
            WHERE AA_equimondo_hebeappnum = :id_calendar
            AND caledate1 BETWEEN :first_date AND :last_date";

    if ($monitors && count($monitors) > 0) {
        $sql .= " AND utilisateurs_utilnum IN(:monitors)";
    }

    if ($discipline && $discipline !== 'none') {
        $sql .= " AND caletext6 = :discipline";
    }

    if ($installation && $installation !== 'none') {
        $sql .= " AND caletext8 = :installation";
    }

    $query = getDB()->prepare($sql);
    $query->bindParam('id_calendar', $id_calendar);
    $query->bindParam('first_date', $start);
    $query->bindParam('last_date', $end);
    if ($monitors && count($monitors) > 0) {
        $monitors_ids = implode(',', $monitors);
        $query->bindParam('monitors', $monitors_ids);
    }
    if ($discipline && $discipline !== 'none') {
        $query->bindParam('discipline', $discipline);
    }
    if ($installation && $installation !== 'none') {
        $query->bindParam('installation', $installation);
    }
    $query->execute();
    $appointments = $query->fetchAll(PDO::FETCH_ASSOC);

    $lists = [];

    if ($appointments) {
        foreach ($appointments as $appointment) {
            $wording = getWording($appointment);

            $lists[] = [
                'id' => $appointment['calenum'],
                "start" => $appointment['caledate1'],
                'title' => utf8_encode($wording),
                'url' => 'caleajou.php?calenum=' . $appointment['calenum']
            ];
        }
    }

    return json_encode($lists);
}

function getWording($appointment)
{
    $sql = 'SELECT calecatetype, calecatelibe FROM calendrier_categorie WHERE calecatenum = :id_category';
    $query = getDB()->prepare($sql);
    $query->bindParam('id_category', $appointment['calendrier_categorie_calecatenum']);
    $query->execute();
    $category = $query->fetch(PDO::FETCH_OBJ);
    $calecatelibe = $category->calecatelibe;

    if ($category->calecatetype == 1) {
        $sql_plan = 'SELECT planlecomodlibe FROM planning_modele_calendrier,planning_lecon_modele,calendrier
                                        WHERE calendrier_calenum = calenum
                                        AND planning_lecon_modele_planlecomodnum = planlecomodnum
                                        AND calendrier_calenum = :calenum';
        $query_plan = getDB()->prepare($sql_plan);
        $query_plan->bindParam('calenum', $appointment['calenum']);
        $query_plan->execute();
        $plan = $query_plan->fetch(PDO::FETCH_OBJ);

        if (!empty($appointment['caletext13'])) {
            return $appointment['caletext13'];
        } else if (!empty($plan->planlecomodlibe)) {
            return $plan->planlecomodlibe;
        } else {
            return $category->calecatelibe;
        }

    } elseif (($category->calecatetype == 2 || $category->calecatetype == 3) && !empty($appointment['caletext13'])) {

        return $appointment['caletext13'];

    } elseif ($category->calecatetype == 4 || $category->calecatetype == 5) {
        $query_cp = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = :calenum';
        $query_cp = getDB()->prepare($query_cp);
        $query_cp->bindParam('calenum', $appointment['calenum']);
        $query_cp->execute();
        $cp = $query_cp->fetch();

        if ($cp == 1) {
            $calecatelibe . " <i>(" . $cp . " " . $_SESSION['STrad683'] . ")</i>";
        } elseif ($cp >= 2) {
            $calecatelibe . " <i>(" . $cp . " " . $_SESSION['STrad684'] . ")</i>";
        }

        return $calecatelibe;
    } elseif (!empty($appointment['caletext13'])) {
        return $appointment['caletext13'];
    }

    return $calecatelibe;
}