<?php
/**
 * "Add friends" request message content.
 * @author: Raysmond
 */
echo '<p>';
echo RHtml::linkAction('user', $user->name, 'view', $user->id);
echo ' wants to be your friends. <br/>';
echo '</p>';

echo '<p>';
echo RHtml::linkAction('friend', 'Confirm', 'confirm', $user->id, array('class' => 'btn btn-xs btn-success'));
echo '&nbsp;&nbsp;';
echo RHtml::linkAction('friend', 'Decline', 'decline', $user->id, array('class' => 'btn btn-xs btn-danger'));
echo '</p>';
