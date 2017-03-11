<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GamePageStandard extends BaseGamePage
{
    protected
        $uid = 'standard game page';

    protected function runUserTypeTests()
    {
        $this->log(get_called_class());
    }
}