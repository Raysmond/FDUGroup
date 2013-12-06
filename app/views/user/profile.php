<div id="profile" class="panel panel-default">
    <div class="panel-heading" style="font-weight: bold;"><?=$user->name?></div>
    <div class="panel-body">
        <div class="col-lg-8">
            <ul class="list-group">
            <?php
            $skip = array('id', 'status', 'picture', 'privacy', 'password', 'credits', 'name');
            foreach ($user->columns as $objCol => $dbCol) {
                if (in_array($objCol, $skip)) continue;
                echo '<li class="list-group-item">';
                switch ($objCol) {
                    case "gender":
                        echo "Gender: " . User::getGenderName($user->gender);
                        break;
                    case "registerTime":
                        echo "Register time: " . $user->registerTime . "<br/>";
                        break;
                    case "qq":
                        echo "QQ: " . $user->qq . "<br/>";
                        break;
                    case "roleId":
                        echo "Role: " . User::$roles[$user->roleId - 1] ."&nbsp;";
                        if ($user->roleId == Role::AUTHENTICATED_ID) {
                            echo RHtmlHelper::linkAction('user','Apply for VIP','applyVIP', null, ['class' => 'btn btn-xs btn-info']);
                        }
                        echo "<br/>";
                        break;
                    case "intro":
                        echo "Introduction: " . $user->$objCol . "<br/>";
                        break;
                    case "weibo":
                        echo "Webo: " . RHtmlHelper::link($user->name, $user->weibo, $user->weibo) . "<br/>";
                        break;
                    case "homepage":
                        echo "Homepage: " . RHtmlHelper::link($user->name, $user->homepage, $user->homepage) . "<br/>";
                        break;
                    default:
                        echo ucfirst($objCol) . ": " . $user->$objCol . "<br/>";
                        break;
                }
                echo '</li>';

            }
            $wallet = $user->getWallet();
            echo '<li class="list-group-item">Wallet: '.$wallet->money.' '.Wallet::COIN_NAME.'</li>';
            ?>
            </ul>
        </div>

        <div class="col-lg-4">
            <div style="float: right;">
                <?=RHtmlHelper::linkAction('user',"Edit profile",'profile/edit',$user->id,array('class'=>'btn btn-xs btn-info'))?>
            </div>
            <div style="margin-top: 30px;">
                <?php
                $pic = (isset($user->picture) && $user->picture != '') ? $user->picture : "public/images/default_pic.png";
                $thumbnail = RImageHelper::styleSrc($user->picture,$user::getPicOptions());
                echo RHtmlHelper::showImage($thumbnail, $user->name, array('class' => 'img-thumbnail', 'width' => '200px'));
                ?>
            </div>
        </div>
    </div>
</div>
