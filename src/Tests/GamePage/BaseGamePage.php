<?php 

namespace Tests\GamePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

use Tests\BasePageTest;

class BaseGamePage extends BasePageTest
{
    protected
        $uid = 'game page details',
        $link_text = 'Games';

    protected function runBaseTests()
    {
        $this->log('base page');
    }
}