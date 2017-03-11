<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GamePageStandard extends BaseGamePage
{
    protected
        $uid = 'standard game page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}