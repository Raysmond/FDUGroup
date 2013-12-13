<?= RFormHelper::openForm('post/admin', array('id' => 'topicsAdminForm')) ?>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <div class="heading-actions">
                <input type="submit" onclick="return confirm('Are you sure to delete selected topics?')" value="Delete" class="btn btn-xs btn-danger" />
            </div>
            <h1 class="panel-title">Topics</h1>
        </div>
        <div class="panel-body">
            <table id="admin-topics" class="table">
                <thead>

                <tr>
                    <?php $order = Rays::getParam("order","asc")=="asc"?"desc":"asc"; ?>
                    <?php echo '<th><input type="checkbox" id="check-all" onclick="javascript:checkReverse(\'checked_topics[]\')" /></th>'; ?>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Group</th>

                    <th><a class="highlight" href="<?=RHtmlHelper::siteUrl("post/admin?orderBy=createTime&&order=".$order)?>">
                            Create Time <?php if(Rays::getParam("orderBy",null)=="createTime"){
                                if(Rays::getParam("order","asc")=="asc"){
                                    echo '<span class="glyphicon glyphicon-chevron-up"></span>';
                                }
                                else{
                                    echo '<span class="glyphicon glyphicon-chevron-down"></span>';
                                }
                            }?>
                        </a>
                    </th>

                    <th><a class="highlight" href="<?=RHtmlHelper::siteUrl("post/admin?orderBy=replies&&order=".$order)?>">
                            Replies <?php if(Rays::getParam("orderBy",null)=="replies"){
                                if(Rays::getParam("order","asc")=="asc"){
                                    echo '<span class="glyphicon glyphicon-chevron-up"></span>';
                                }
                                else{
                                    echo '<span class="glyphicon glyphicon-chevron-down"></span>';
                                }
                            }?>
                        </a>
                    </th>

                    <th><a class="highlight" href="<?=RHtmlHelper::siteUrl("post/admin?orderBy=views&&order=".$order)?>">
                            Views <?php if(Rays::getParam("orderBy",null)=="views"){
                                if(Rays::getParam("order","asc")=="asc"){
                                    echo '<span class="glyphicon glyphicon-chevron-up"></span>';
                                }
                                else{
                                    echo '<span class="glyphicon glyphicon-chevron-down"></span>';
                                }
                            }?>
                        </a>
                    </th>

                    <th><a class="highlight" href="<?=RHtmlHelper::siteUrl("post/admin?orderBy=likes&&order=".$order)?>">
                            Likes <?php if(Rays::getParam("orderBy",null)=="likes"){
                                if(Rays::getParam("order","asc")=="asc"){
                                    echo '<span class="glyphicon glyphicon-chevron-up"></span>';
                                }
                                else{
                                    echo '<span class="glyphicon glyphicon-chevron-down"></span>';
                                }
                            }?>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($topics as $topic) {
                    echo '<tr>';
                    echo '<td>' . RFormHelper::input(array('type' => 'checkbox', 'name' => 'checked_topics[]', 'value' => $topic->id)) . '</td>';
                    echo '<td>' . RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) . '</td>';
                    echo '<td>' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) . '</td>';
                    echo '<td>' . RHtmlHelper::linkAction('group', $topic->group->name, 'detail', $topic->group->id) . '</td>';
                    echo '<td>' . $topic->createdTime . '</td>';
                    echo '<td>' . $topic->commentCount . '</td>';
                    echo '<td>' . ($topic->counter->totalCount!=null?$topic->counter->totalCount:"0"). '</td>';
                    echo '<td>' . ($topic->rating->value!=null?$topic->rating->value:"0") . '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?= isset($pager)?$pager:"" ?>
        </div>
    </div>
<?= RFormHelper::endForm() ?>
