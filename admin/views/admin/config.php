<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 25.04.12
 * Time: 07:58
 *
 */
$conf = new Configuration();
?>
<fieldset>
    <legend>Zmień konfiguracje</legend>
    <form method="post">
        <?php echo HTMLManager::makeSelect(
        array(
            'name' => 'date',
            'id' => 'date',
            'label' => 'Format Daty:',
            'selected' => $conf->getDateFormat(),
            'values' => $conf->getDateFormats(),
        )
    );
        echo '<br />';
        echo HTMLManager::makeSelect(
            array(
                'name' => 'zone',
                'id' => 'zone',
                'label' => 'Strafa czasowa: ',
                'selected' => $conf->getTimeZone(),
                'values' => $conf->getTimeZones(),
            )
        );
        echo '<br />';
        echo HTMLManager::makeSelect(
            array(
                'name' => 'time',
                'id' => 'time',
                'label' => 'Format czasu: ',
                'selected' => $conf->getTimeFormat(),
                'values' => $conf->getTimeFormats(),
            )
        );
        echo '<br />';
        echo HTMLManager::makeSelect(
            array(
                'name' => 'template',
                'id' => 'template',
                'label' => 'Szablon: ',
                'selected' => $conf->getTemplate(),
                'values' => $conf->getAllTemplates(),
            )
        );
        echo '<br />';
        ?>
        <input type="button" value="Zapisz" class="submit" id="saveConfig" value='Save'/>
    </form>
</fieldset>