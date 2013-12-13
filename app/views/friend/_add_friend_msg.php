<?php
/**
 * "Add friends" request message content.
 * @author: Raysmond
 */
echo '<p>';
echo RHtmlHelper::linkAction('user', $user->name, 'view', $user->id);
echo ' wants to be your friends. <br/>';
echo '</p>';

echo '<p>';
echo RHtmlHelper::linkAction('friend', 'Confirm', 'confirm', $user->id, array('class' => 'btn btn-xs btn-success'));
echo '&nbsp;&nbsp;';
echo RHtmlHelper::linkAction('friend', 'Decline', 'decline', $user->id, array('class' => 'btn btn-xs btn-danger'));
echo '</p>';
