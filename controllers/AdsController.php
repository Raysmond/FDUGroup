<?php
/**
 * AdsController class file
 *
 * @author: songrenchu, Raysmond
 */
class AdsController extends BaseController
{
    public $layout = "user";
    public $defaultAction = "view";

    public $access = [
        Role::VIP => ['view', 'apply', 'remove', 'edit'],
        Role::ADMINISTRATOR => ['approve', 'admin']
    ];

    public function actionView($type = 'published')
    {
        $userId = Rays::user()->id;
        RAssert::is_true($type != '' && in_array($type, ["blocked", 'published', 'applying']));

        if ($type === 'blocked') {
            $data['ads'] = Ads::find(["userId", $userId, "status", Ads::BLOCKED])->all();
            $data['type'] = Ads::BLOCKED;
        } else if ($type === 'published') {
            $data['ads'] = Ads::find(["userId", $userId, "status", Ads::APPROVED])->all();
            $data['type'] = Ads::APPROVED;
        } else {
            $data['ads'] = Ads::find(["userId", $userId, "status", Ads::APPLYING])->all();
            $data['type'] = Ads::APPLYING;
        }

        $this->setHeaderTitle('My Advertisements');
        $this->render('view', $data, false);
    }

    public function actionApply()
    {
        $data = array();
        if (Rays::isPost()) {
            $rules = array(
                array('field' => 'ads-title', 'label' => 'Ads title', 'rules' => 'trim|required|min_length[5]|max_length[255]'),
                array('field' => 'ads-content', 'label' => 'Ads content', 'rules' => 'required'),
                array('field' => 'paid-price', 'label' => 'Paid price', 'rules' => 'trim|required|number'),
            );
            $validation = new RValidation($rules);
            if ($validation->run()) {
                //Money cannot exceed wallet remaining
                $money = Rays::user()->getWallet()->money;
                if ($money < (int)$_POST['paid-price']) {
                    $this->flash('error', 'You cannot overdraft your ' . Wallet::COIN_NAME . ' to publish advertisements.');
                    $data['applyForm'] = $_POST;
                } else {
                    Rays::user()->getWallet()->cutMoney((int)$_POST['paid-price']); //Pay the price
                    $ads = new Ads();
                    $result = $ads->apply(
                        Rays::user()->id,
                        $_POST['ads-title'],
                        RHtml::encode($_POST['ads-content']),
                        $_POST['paid-price']
                    );
                    if ($result == true) {
                        $this->flash('message', 'Your ads was applied successfully.');
                    } else {
                        $data['applyForm'] = $_POST;
                        $this->flash('message', 'Apply failed.');
                    }
                }
            } else {
                $data['applyForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->setHeaderTitle("Ads application");
        $this->render('apply', $data, false);
    }

    public function actionRemove($adId = null, $type)
    {
        $ad = Ads::get($adId);
        RAssert::not_null($ad);
        $currentUserId = Rays::user()->id;

        if ($ad->userId == $currentUserId) {
            $ad->delete();

            $this->flash('message', 'Advertisement removed successfully.');
            $redirect = null;
            switch ($type) {
                case Ads::APPROVED:
                    $redirect = 'published';
                    break;
                case Ads::APPLYING:
                    $redirect = 'applying';
                    break;
                case Ads::BLOCKED:
                    $redirect = 'blocked';
                    break;
            }
            $this->redirectAction('ads', 'view', $redirect);
            return;
        } else {
            $this->flash("error", 'Permission denied');
            $this->page404();
        }
    }

    public function actionEdit($adId, $type)
    {
        $ad = Ads::get($adId);
        RAssert::not_null($ad);

        $data = ['ad' => $ad, 'edit' => true, 'type' => $type];

        if (Rays::isPost()) {
            $rules = array(
                array('field' => 'ads-title', 'label' => 'Ads title', 'rules' => 'trim|required|min_length[5]|max_length[255]'),
                array('field' => 'ads-content', 'label' => 'Ads content', 'rules' => 'required'),
                array('field' => 'paid-price', 'label' => 'Paid price', 'rules' => 'trim|required|number'),
            );
            $validation = new RValidation($rules);
            if ($validation->run()) {
                $ad->title = $_POST['ads-title'];
                $ad->content = RHtml::encode($_POST['ads-content']);
                $ad->save();
                $this->flash('message', 'Your ads was edited successfully.');
                $redirect = null;
                switch ($type) {
                    case Ads::APPROVED:
                        $redirect = 'published';
                        break;
                    case Ads::APPLYING:
                        $redirect = 'applying';
                        break;
                    case Ads::BLOCKED:
                        $redirect = 'blocked';
                        break;
                }
                $this->redirectAction('ads', 'view', $redirect);
            } else {
                $data['applyForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->setHeaderTitle("Edit Advertisement");
        $this->render('apply', $data, false);
    }

    public function actionAdmin()
    {
        $this->setHeaderTitle('Advertisement');
        $this->layout = 'admin';

        if (Rays::isPost()) {
            if (isset($_POST['checked_ads'])) {
                $selected = $_POST['checked_ads'];
                if (is_array($selected)) {
                    $operation = $_POST['operation_type'];
                    foreach ($selected as $id) {
                        $ad = Ads::get($id);
                        if ($ad == null) break;
                        switch ($operation) {
                            case "block":
                                $ad->status = Ads::BLOCKED;
                                $ad->save();
                                break;
                            case "active":
                                $ad->status = Ads::APPROVED;
                                $ad->save();
                                break;
                        }
                    }
                }
            }
        }
        $curPage = $this->getPage('page');
        $pageSize = $this->getPageSize("pagesize", 10);

        $filterStr = Rays::getParam('search', null);
        $query = Ads::find()->join("publisher");
        if ($name = trim($filterStr)) {
            $names = preg_split("/[\s]+/", $name);
            foreach ($names as $key) {
                $query = $query->like("name", $key);
            }
        }
        $count = $query->count();
        $ads = $query->order_desc("id")->range($pageSize * ($curPage - 1), $pageSize);

        $data = ['ads' => $ads, 'count' => $count];

        $url = RHtml::siteUrl('ads/admin');
        if ($filterStr != null) $url .= '?search=' . urlencode(trim($filterStr));

        $pager = new RPager('page', $count, $pageSize, $url, $curPage);
        $data['pager'] = $pager->showPager();

        $this->render('admin', $data, false);
    }

    public function actionHitAd()
    {
        if (Rays::isAjax()) {
            $adId = (int)$_POST['adId'];
            $ad = Ads::get($adId);
            if ($ad !== null) {
                (new Counter())->increaseCounter($adId, Ads::ENTITY_TYPE); //Ad访问计数器
                /** TODO 刷广告访问监测机制 */
                $user = User::get($ad->userId);
                if ($user !== null) {
                    $wallet = $user->getWallet(); //访问一次挣一元钱
                    $wallet->addMoney(1);
                }

            }
        }
    }
}