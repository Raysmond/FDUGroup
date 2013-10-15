<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>
<div class="jumbotron">
    <div class="page-header">
        <h2>Hi!<?php echo " " . $user->name . " "; ?><span class="badge">FDUGroup</span></h2>
    </div>

    <p class="panel panel-info"></p>

    <div class="panel-body">
        <div class="navbar-right">
            <?php
            echo RHtmlHelper::linkAction('user', 'Edit', 'edit', $user->id, array('class' => 'btn btn-success'));
            ?>
        </div>
        <?php
        foreach ($user->columns as $objCol => $dbCol) {
            switch ($objCol) {
                case "id":
                    break;
                case "status":
                    break;
                case "picture":
                    break;
                case "privacy":
                    break;
                case 'permission':
                    break;
                case "password":
                    break;
                case "credits":
                    break;
                case "registerTime":
                    echo "Register time: " . $user->registerTime . "<br/>";
                    break;
                case "qq":
                    echo "QQ: " . $user->qq . "<br/>";
                    break;
                case "roleId":
                    echo "Role: " . User::$roles[$user->roleId - 1] . "<br/>";
                    break;
                case "intro":
                    echo "Introduction: " . $user->$objCol . "<br/>";
                    break;
                default:
                    echo ucfirst($objCol) . ": " . $user->$objCol . "<br/>";
                    break;
            }

        }
        ?>
    </div>

</div>