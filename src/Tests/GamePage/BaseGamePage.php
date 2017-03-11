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
        $this->log('no writes: '.$this->no_db_writes);
        $this->notice(get_called_class());
        $this->runUserTypeTests();
    }
}