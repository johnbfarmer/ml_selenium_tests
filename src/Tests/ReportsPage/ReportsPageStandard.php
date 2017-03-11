<?php 

namespace Tests\reportsPage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ReportsPageStandard extends BasereportsPage
{
    protected
        $uid = 'standard reports page';

    protected function runUserTypeTests()
    {
        $this->log(get_called_class());
    }
}