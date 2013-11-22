<?=RFormHelper::openForm('group/recommend',array('id'=>'recommendGroupForm'))?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Group recommendation</b>
        <div style="float: right;">
            <?=RFormHelper::input(array('type'=>'submit','class'=>'btn btn-xs btn-info','value'=>'Recommend'))?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Groups</b>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <?=RFormHelper::input(array(
                                    'id'=>'search_groups',
                                    'name'=>'search_groups',
                                    'class'=>'form-control',
                                    'placeholder'=>'Search groups'))?>
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:search_groups()" search_url="<?=RHtmlHelper::siteUrl('group/recommend')?>" class="btn btn-sm btn-info">Search</a>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <b>Selected Groups</b>
                            <ul class="list-group" id="to-recommend-groups">

                            </ul>
                        </div>
                        <div id="recommend-groups" class="row" style="padding: 10px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Users</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <?=RFormHelper::input(array(
                                    'id'=>'search_users',
                                    'name'=>'search_users',
                                    'class'=>'form-control',
                                    'placeholder'=>'Search users'))?>
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:search_users()" search_url="<?=RHtmlHelper::siteUrl('group/recommend')?>" class="btn btn-sm btn-info">Search</a>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <b>Selected users</b>
                            <ul class="list-group" id="to-recommend-users">

                            </ul>
                        </div>
                        <div id="recommend-users" class="row" style="padding: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=RFormHelper::endForm()?>
<script>
    var recommendGroups = new Array();
    var toRecommendGroups = new Array();
    var recommendUsers = new Array();
    var toRecommendUsers = new Array();
    function search_groups(){
        if($str = $('#search_groups').val()){
            $.ajax({
                type: 'POST',
                url: $('#search_groups').attr('search_url'),
                data: {'action':'search_groups','name':$str}
            }).done(function(data){
                    var groups = eval('('+data+')');
                    recommendGroups = groups;
                    var html = '<ul class="list-group">';
                    for(var i=0;i<groups.length;i++){
                        var group = groups[i];
                        html+='<li class="list-group-item">'
                            +'<input type="checkbox" class="selected_groups" name="selected_groups[]" value="'+i+'" />'
                            +'&nbsp&nbsp'
                            +'<a href="'+group.link+'" target="_blank">'+group.name+'</a></li>';
                    }
                    html+='<li class="list-group-item"><a href="javascript:addGroups()" class="btn btn-xs btn-success">Add groups</a></li>';
                    html+='</ul>';
                    $("#recommend-groups").html(html);
                });
        }
    }

    function showToRecommendGroups(){
        var html = '';
        for(var i=0;i<toRecommendGroups.length;i++){
            var group = toRecommendGroups[i];
            html +='<li class="list-group-item">'
                +'<a href="javascript:removeGroup('+i+')"><span style="color: red;">X</span></a>'
                +'&nbsp&nbsp'
                +'<a href="'+group.link+'" target="_blank">'+group.name+'</a></li>'
                +'<input type="hidden" name="selected_recommend_groups[]" value="'+group.id+'">';
        }
        $('#to-recommend-groups').html(html);
    }

    function addGroups(){
        $('input[name="selected_groups[]"]:checked').each(function(){
            var groupIndex = $(this).val();
            var group = recommendGroups[groupIndex];
            toRecommendGroups.push(group);
            showToRecommendGroups();
        });
    }

    function removeGroup(index){
        toRecommendGroups.splice(index,1);
        showToRecommendGroups();
    }


    function search_users(){
        if($str = $('#search_users').val()){
            $.ajax({
                type: 'POST',
                url: $('#search_users').attr('search_url'),
                data: {'action':'search_users','name':$str}
            }).done(function(data){
                    var users = eval('('+data+')');
                    recommendUsers = users;
                    var html = '<ul class="list-group">';
                    for(var i=0;i<users.length;i++){
                        var user = users[i];
                        html+='<li class="list-group-item">'
                            +'<input type="checkbox" class="selected_users" name="selected_users[]" value="'+i+'" />'
                            +'&nbsp&nbsp'
                            +'<a href="'+user.link+'" target="_blank">'+user.name+'</a></li>';
                    }
                    html+='<li class="list-group-item"><a href="javascript:addUsers()" class="btn btn-xs btn-success">Add users</a></li>';
                    html+='</ul>';
                    $("#recommend-users").html(html);
                });
        }
    }

    function showToRecommendUsers(){
        var html = '';
        for(var i=0;i<toRecommendUsers.length;i++){
            var user = toRecommendUsers[i];
            html +='<li class="list-group-item">'
                +'<a href="javascript:removeUser('+i+')"><span style="color: red;">X</span></a>'
                +'&nbsp&nbsp'
                +'<a href="'+user.link+'" target="_blank">'+user.name+'</a></li>'
                +'<input type="hidden" name="selected_recommend_users[]" value="'+user.id+'">';
        }
        $('#to-recommend-users').html(html);
    }

    function addUsers(){
        $('input[name="selected_users[]"]:checked').each(function(){
            var index = $(this).val();
            var user = recommendUsers[index];
            toRecommendUsers.push(user);
            showToRecommendUsers();
        });
    }

    function removeUser(index){
        toRecommendUsers.splice(index,1);
        showToRecommendUsers();
    }
</script>