<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>
<div class="jumbotron">
    <div class="page-header">
        <h1>Hi!<?php echo " ".$user->name." "; ?><span class="badge">FDUGroup</span></h1>
        <h1><small>This is your information</small></h1>
    </div>

    <p class="panel panel-info"></p>
        <?php
                foreach($user->columns as $objCol=>$dbCol){
                    switch($objCol)
                    {
                        case "id":;
                        case "status":;
                        case "picture":;
                        case "privacy":;
                        case "credits":break;
                        case "intro":
                            echo  "Introduction: ".$user->$objCol."<br/>";break;
                       default:     echo  $objCol.": ".$user->$objCol."<br/>";break;
                    }

                }
        ?>

</div>