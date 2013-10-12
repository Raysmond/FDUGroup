<div class="jumbotron">
    <h1>Welcome to FDUGroup</h1>
    <p>
        Surround yourself with good people. People who are going to be honest with you and look out for your best interests.
        <br/>
        Derek Jeter
    </p>
</div>

All users:
<br/>
<table>
<?php
    foreach($data[0]->columns as $col=>$dbcol){
        echo "<th>".$col."</th>";
    }
    foreach($data as $user){
        echo "<tr>";
        foreach($user->columns as $col=>$dbcol){
            if(isset($user->$col))
                echo '<td>'.$user->$col."</td>";
            else
                echo '<td>NULL</td>';
        }
        echo "</tr>";
    }

?>
</table>

<br/>
