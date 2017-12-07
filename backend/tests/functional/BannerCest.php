<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-12-07 19:31
 */
namespace backend\tests\functional;

use backend\models\User;
use backend\tests\FunctionalTester;
use backend\fixtures\UserFixture;
use yii\helpers\Url;

/**
 * Class BannerCest
 */
class BannerCest
{

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findIdentity(1));
    }

    public function checkIndex(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/banner/index'));
        $I->see('	Banner类型');
        $I->see("	描述");
        $I->click("a[title=编辑]");
        $I->see("	编辑Banner类型");
        $I->fillField("BannerForm[tips]", 'banner类型描述');
        $I->submitForm("button[type=submit]", []);
        $I->seeInField("BannerForm[tips]", "banner类型描述");
    }

    public function checkBanners(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/banner/index'));
        $urls = $I->grabMultiple("a[title=编辑]", 'href');
        $I->amOnPage($urls[0]);
        $I->see("图片");
        $I->click("a[title=进入]");
        $I->fillField("BannerForm[desc]", 'banner图片描述');
        $I->submitForm("button[type=submit]", []);
        $I->seeInField("BannerForm[desc]", "banner图片描述");
    }
}