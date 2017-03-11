<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

use Tests\BaseTest;

class BaseGamePage extends BaseTest
{
    protected
        $uid = 'game page details';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}