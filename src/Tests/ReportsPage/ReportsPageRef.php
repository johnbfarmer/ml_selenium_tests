<?php 

namespace Tests\reportsPage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ReportsPageRef extends BasereportsPage
{
    protected
        $uid = 'ref reports page';

    protected function runUserTypeTests()
    {
        $this->log(get_called_class());
    }
}