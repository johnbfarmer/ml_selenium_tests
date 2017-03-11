<?php 

namespace Tests\reportsPage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

use Tests\BasePageTest;

class BaseReportsPage extends BasePageTest
{
    protected
        $uid = 'reports page details',
        $link_text = 'Reports';

    protected function runBaseTests()
    {
        $this->log('base page');
    }

    protected function handleLinkNotFound()
    {
        // this is ok for all but admin
    }
}