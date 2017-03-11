<?php 

namespace Tests\reportsPage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ReportsPageCaptain extends BasereportsPage
{
    protected
        $uid = 'captain reports page';

    protected function runUserTypeTests()
    {
        $this->log(get_called_class());
    }
}