<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GamePageCaptain extends BaseGamePage
{
    protected
        $uid = 'captain game page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}