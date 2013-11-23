<?php
/**
 * Created by JetBrains PhpStorm.
 * User: songrenchu
 */
?>

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        VIP applications
    </div>
    <!-- Table -->

    <table id="admin-applications" class="table">
        <thead>
        <tr>
            <th>Submit Time</th>
            <th>Name</th>
            <th style="width:50%;">Statement of Purpose</th>
            <th>Decision</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 0;
        foreach ($applications as $apply) {
            echo '<tr>';
            ?><td><?=$apply->sendTime;?></td>
            <td><?=RHtmlHelper::linkAction('user', $users[$count]->name, 'view', $users[$count]->id);?></td>
            <td><?=RHtmlHelper::decode($apply->content);?></td>
            <td>
                <?=RHtmlHelper::linkAction('user', 'Accept', 'processVIP?censorId='.$apply->id.'&op=0', [], ['class' => 'btn btn-xs btn-success']);?>
                <?=RHtmlHelper::linkAction('user', 'Decline', 'processVIP?censorId='.$apply->id.'&op=1', [], ['class' => 'btn btn-xs btn-danger']);?>

            </td>
        <?php
            echo '</tr>';
            ++$count;
        }
        ?>
        </tbody>
    </table>
</div>

<?= (isset($pager) ? $pager : '') ?>