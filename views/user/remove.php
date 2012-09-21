<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 25.04.12
 * Time: 14:32
 *
 */
$usr = $this->model->getById(HTMLManager::cleanInput($_GET["us_id"]));

if (!isset($usr->id_user)) {
    echo "Nie udało się usunąć, skontakuj się ze samym sobą!(czyt. z Maciejem Romańskim)";
} else {
    echo "Usunięto użytkownika";
}
?>

