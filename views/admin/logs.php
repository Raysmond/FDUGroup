<div class="system-logs panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">System logs (<?= $count ?>)</h1></div>
    <div class="panel-body">
        <div class="system-logs-list">
            <table class="table">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Message</th>
                    <th>Path</th>
                    <th>User</th>
                    <th>Host</th>
                    <th>Timestamp</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($logs as $log) {
                    echo '<tr>';
                    echo '<td>' . $log->type . '</td>';
                    echo '<td>' . $log->severity . '</td>';
                    echo '<td>' . $log->message . '</td>';
                    echo '<td>' . RHtml::link($log->path, $log->path, $log->path) . '</td>';
                    if ($log->userId == 0) {
                        echo '<td>Anonymous</td>';
                    } else {
                        echo '<td>' . RHtml::linkAction('user', $log->user->name, 'view', $log->user->id) . '</td>';
                    }
                    echo '<td>' . $log->host . '</td>';
                    echo '<td>' . $log->timestamp . '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

        </div>
        <?= $pager ?>
    </div>

</div>