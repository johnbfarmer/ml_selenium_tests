<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GamePageAdmin extends BaseGamePage
{
    protected
        $uid = 'admin game page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}