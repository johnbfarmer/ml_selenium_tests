<?php 

namespace Tests\reportsPage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ReportsPageAdmin extends BasereportsPage
{
    protected
        $uid = 'admin reports page';

    protected function runUserTypeTests()
    {
        $this->log(get_called_class());
    }

    protected function handleLinkNotFound()
    {
        $this->error('Missing Link ' . $this->link_text);
    }
}