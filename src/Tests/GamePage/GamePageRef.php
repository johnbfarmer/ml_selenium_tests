<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GamePageRef extends BaseGamePage
{
    protected
        $uid = 'ref game page';

    protected function runUserTypeTests()
    {
        $this->log(get_called_class());
    }
}