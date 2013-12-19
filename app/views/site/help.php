<style>
    #help-list{
        line-height: 1.7;
    }
    #help-list img{
        margin: 15px 0;
    }
    #help-list h2{
        font-size: 20px;
    }
    </style>
<div class="panel panel-default">

    <div class="panel-heading">
        <h1 class="panel-title">FDUGroup Help</h1>
    </div>

    <div class="panel-body" id="help-list">

        <div class="row" id="find-groups">
            <h2>Find groups</h2>
            你可以通过首页顶端的find groups(红色方框标记部分)查找FDUGroup你感兴趣的小组。
            FDUGroup里拥有丰富多彩的兴趣小组和话题，在这里，你可以根据记得兴趣筛选自己喜欢的小组，如上图上方导航栏部分，“更多”按钮（黄色标记部分）提供了对小组更加细化的分类，便于找到你感兴趣的核心话题。如下图所示：
        <?=RHtmlHelper::showImage("files/images/site/01.png","",array('style'=>"width: 100%;"))?>

        如通过上述分类后，仍不能找到您满意的答案，你也可以通过顶部导航栏上的搜索框直接搜索，系统将为你匹配更合您心意的小组。
        找到感兴趣的小组后，点击该小组下侧导航栏的“+”按钮，向该小组管理者发出申请加入小组的请求，待对方审核通过后，即可加入该小组，进行讨论和发表话题。
            <?=RHtmlHelper::showImage("files/images/site/02.png","",array('style'=>"width: 100%;"))?>
        </div>

        <div class="row" id="groups-management">
            <h2>Groups management</h2>
        本条目将指导您如何对已加入的小组进行管理。单击个人帐号下的home page，进入如下界面后，点击右侧导航栏的“my groups”条目，即可进入group管理界面。
            <?=RHtmlHelper::showImage("files/images/site/03.png","",array('style'=>"width: 100%;"))?>
        每个小组的下方提供了三个按钮（黑色标记部分），其中左侧人物头像表示该小组当前人数，心号表示有多少人认为该小组很赞！您也可以对该小组进行点赞。点击右侧“X”将退出该小组。
        </div>

        <div class="row" id="create-groups">
        <h2>Create Groups</h2>
            <?=RHtmlHelper::showImage("files/images/site/04.png","",array('style'=>"width: 100%;"))?>
        本条目将指导您创建一个小组。在个人主页下，点击如图红色标记部分的“new group”按钮即可创建新的小组，创建界面如下图所示：
        <?=RHtmlHelper::showImage("files/images/site/05.png","",array('style'=>"width: 100%;"))?>

        按照上述步骤进行操作，即可获得您在FDUGroup创建的第一个小组了！对于自己创建的小组，您还可以对小组进行后期的编辑，并且邀请好友加入小组。如下图所示：
        <?=RHtmlHelper::showImage("files/images/site/06.png","",array('style'=>"width: 100%;"))?>
        下图为邀请界面：
        <?=RHtmlHelper::showImage("files/images/site/07.png","",array('style'=>"width: 100%;"))?>

        赶快让你的小伙伴们加入进来吧~

        </div>

        <div class="row" id="posts">
            <h2>Posts</h2>
        本条目将指导您进行话题的创建、管理和参与他人的话题。单击您已经加入小组下的任一话题，如下图所示，即可进入话题讨论界面：

        <?=RHtmlHelper::showImage("files/images/site/08.png","",array('style'=>"width: 100%;"))?>
        你可以在该话题下与其他人讨论、交流以及点赞(绿色标记部分)：

        <?=RHtmlHelper::showImage("files/images/site/09.png","",array('style'=>"width: 100%;"))?>


        你也可以创建新的话题：
            <?=RHtmlHelper::showImage("files/images/site/10.png","",array('style'=>"width: 100%;"))?>
        如下图所示，赶快发表你的第一个话题吧~
        <?=RHtmlHelper::showImage("files/images/site/11.png","",array('style'=>"width: 100%;"))?>
        </div>

        <div class="row" id="friends">
        <h2>Friends</h2>
        本条目将指引你进行朋友管理，包括查找好友，新增好友，查看好友信息等操作。在个人主页下，点击“find friend”按钮（黄色标记部分），即可看到系统之中所有的用户，您可以通过直接输入用户名进行搜索。

            <?=RHtmlHelper::showImage("files/images/site/12.png","",array('style'=>"width: 100%;"))?>

        查找到您感兴趣的用户后，点击该用户头像，在该用户公开信息中，点击“add friend”即可申请好友：
            <?=RHtmlHelper::showImage("files/images/site/13.png","",array('style'=>"width: 100%;"))?>

        你也可以在这里查看该用户的公开信息。对于已成为好友的用户，您可以向对方发送message或解除好友关系：
            <?=RHtmlHelper::showImage("files/images/site/14.png","",array('style'=>"width: 100%;"))?>


        你也可以在这里访问好友的个人信息，他的爱好，他已经加入的小组，他发表过的话题等内容。

        </div>

        <div class="row" id="messages">
        <h2>Messages</h2>
        该条目将指导你对收到的信息进行管理，以及如何发送信息。

            <?=RHtmlHelper::showImage("files/images/site/15.png","",array('style'=>"width: 100%;"))?>
        如图所示，你可以在个人主页中对信息进行管理，在主页messages右侧，有一个标签，提示当前有多少条未读消息（黄色标记部分），你可以对收到的信息进行管理，如查看、回复、标记为已读、删除到垃圾箱中等（绿色标记部分）。你也可以对其他人发送消息（红色标记部分），界面如下图所示：
            <?=RHtmlHelper::showImage("files/images/site/16.png","",array('style'=>"width: 100%;"))?>
        你可以向任何已添加为好友的用户发送消息。
        </div>

        <div class="row" id="profile">

        <h2>Profile</h2>
        该条目将指引你对个人信息进行修改。如图，在个人主页下点击my profile即可查看个人信息，如下图所示：
            <?=RHtmlHelper::showImage("files/images/site/17.png","",array('style'=>"width: 100%;"))?>
        单击右上角的edit(褐色标记部分)，即可修改个人信息，上传照片等。你也可以申请成为VIP用户，成为VIP后，您将享受更多特权和优惠。

        </div>

        <div class="row" id="advertisement">
        <h2>Advertisement</h2>
        该条目将指引您在本网站上发布广告。
        注意！只有VIP用户才有资格申请发布广告。关于如何成为VIP用户，详见profile指引。
            <?=RHtmlHelper::showImage("files/images/site/18.png","",array('style'=>"width: 100%;"))?>
        如上图所示，单击个人主页的“advertisement”条目，界面如上图所示。在这里，您可以发布诸如征友、销售、教育等广告信息，通过publish按钮提交，待管理员审核通过后，即可在屏幕右下方看到您的广告，如下图所示：
            <?=RHtmlHelper::showImage("files/images/site/19.png","",array('style'=>"width: 100%;"))?>
        我们引入虚拟营收机制。用户发布的广告每被点击一次，用户获得1 Group Coin。用户账户中的Group Coins可以支付广告投放费用。广告的展示顺序与用户支付的Group Coin数量和投放时间有关，采用公式 支付金额 + 发布时间的Unix纪元/10000 计算。
        通过审核的广告将在所有用户的个人中心右下角展示。未通过审核的广告所支付费用不退回。请阅读本网站About Publish部分以便广告通过审核。

        </div>

        <div class="row" id="about-publish">
        <h2>About Publish</h2>
        依据相关法律规定，网站禁止传播以下内容：
        (一)反对宪法所确定的基本原则的；
        (二)危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；
        (三)损害国家荣誉和利益的；
        (四)煽动民族仇恨、民族歧视，破坏民族团结的；
        (五)破坏国家宗教政策，宣扬邪教和封建迷信的；
        (六)散布谣言，扰乱社会秩序，破坏社会稳定的；
        (七)散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；
        (八)侮辱或者诽谤他人，侵害他人合法权益的；
        (九)含有法律、行政法规禁止的其它内容的。
        不良信息是指违背社会主义精神文明建设要求、违背中华民族优良文化传统与习惯以及其它违背社会公德的各类信息，包括文字、图片、音视频等等。

        </div>
    </div>

</div>
