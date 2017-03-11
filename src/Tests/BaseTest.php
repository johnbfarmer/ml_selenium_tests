<?php 

namespace Tests;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BaseTest
{
    protected
        $parameters,
        $driver,
        $usertype,
        $username,
        $password,
        $base_url,
        $tests_passed = true,
        $logger,
        $log_level = 'INFO',
        $uid = 'uid unknown',
        $app_should_be_present = true,
        $no_db_writes = true;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $this->driver = $parameters['driver'];
        $this->usertype = $parameters['usertype'];
        $this->username = $parameters['username'];
        $this->password = $parameters['password'];
        $this->no_db_writes = !empty($parameters['no-db-writes']);
        $this->base_url = isset($parameters['base_url']) ? $parameters['base_url'] : null;
        $this->logger = $parameters['logger'];
        $this->error_logger = $parameters['error_logger'];
    }

    protected function execute()
    {
        $this->runTests();
        $this->logMessages();
    }

    protected function overviewTest()
    {
        try {
            $metric_overview = $this->driver->findElement(
                WebDriverBy::cssSelector('#metricOverview')
            );

            $this->driver->wait(20, 1000)->until(
                WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                    WebDriverBy::className('metric')
                )
            );

            if ($metric_overview) {
                $this->log('metric overview found');
                $metrics = $metric_overview->findElements(
                    WebDriverBy::className('metric')
                );
                if (empty($metrics)) {
                    $this->error('metrics is empty');
                } else {
                    foreach ($metrics as $metric) {
                        $label = $metric->findElement(
                            WebDriverBy::cssSelector('h2')
                        )->getText();
                        $value = $metric->findElement(
                            WebDriverBy::cssSelector('h1')
                        )->getText();
                        if ($label && $value) {
                            $this->log($label . ': ' . $value);
                            break;
                        } else {
                            continue;
                        }
                    }
                }

            } else {
                $this->error('No overview found');
            }
        } catch (\Exception $e) {
            $this->error('No overview found');
        }
    }

    protected function chartTest()
    {
        try {
            $chart_wrapper = $this->driver->findElement(
                WebDriverBy::cssSelector('#chartWrapper')
            );

            $this->driver->wait(20, 1000)->until(
                WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                    WebDriverBy::className('highcharts-container')
                )
            );

            if ($chart_wrapper) {
                $this->log('chart wrapper found');
                $chart = $chart_wrapper->findElement(
                    WebDriverBy::className('highcharts-container')
                );
                if (empty($chart)) {
                    $this->error('highcharts-container is empty');
                } else {
                    $this->log('chart found');
                    $this->log($chart->getText());
                }

            } else {
                $this->error('No chart found');
            }
        } catch (\Exception $e) {
            $this->error('No chart found');
        }
    }

    protected function gridTest($container_selector = '.metrics-table-top', $grid_selector = '#topKeywordClustersGrid')
    {
        try {
            $grid_wrapper = $this->driver->findElement(
                WebDriverBy::cssSelector($container_selector)
            );

            $this->driver->wait(20, 1000)->until(
                WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                    WebDriverBy::cssSelector($grid_selector)
                )
            );

            if ($grid_wrapper) {
                $this->log('grid wrapper found');
                $grid = $this->driver->findElement(
                    WebDriverBy::cssSelector($grid_selector)
                );
                if (empty($grid)) {
                    $this->error($grid_selector . ' is empty');
                } else {
                    $this->log('grid found');
                    $this->log($grid->getText());
                }

            } else {
                $this->error('No grid found');
            }
        } catch (\Exception $e) {
            $this->error('No grid found');
        }
    }

    protected function treemapTest()
    {
        try {
            $treemap_link = $this->driver->findElement(
                WebDriverBy::cssSelector('li[title="Treemap"]')
            );

            if ($treemap_link) {
                $this->log('treemap link found');
                $treemap_link->click();

                $this->driver->wait(20, 1000)->until(
                    WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                        WebDriverBy::className('aw-treemap-chart')
                    )
                );
                $chart = $this->driver->findElement(
                    WebDriverBy::className('aw-treemap-chart')
                );
                if (empty($chart)) {
                    $this->error('treemap chart is empty');
                } else {
                    $this->log('treemap found');
                    $svg = $chart->findElements(
                        WebDriverBy::cssSelector('svg')
                    );
                    $this->log(count($svg) . ' svgs found');
                }

            } else {
                $this->error('No treemap found');
            }
        } catch (\Exception $e) {
            $this->error('No treemap found');
        }
    }

    protected function checkAbsence($link_is_present)
    {
        $app_absent = true;
        try {
            $product_page_div = $this->driver->findElement(
                WebDriverBy::cssSelector('.product-page')
            );

            if (!$product_page_div) {
                $app_absent = false;
            }
        } catch (\Exception $e) {
            $app_absent = false;
        }

        if ($app_absent) {
            $this->log($this->uid . ' is absent as expected');
        } else {
            $this->error($this->uid . ' product page expected but not found');
            $body = $this->driver->findElement(
                WebDriverBy::cssSelector('body')
            );
            $this->log($body->getText());
        }
    }

    protected function getUrlPath($url)
    {
        $path_parts = explode('/', parse_url($url, PHP_URL_PATH));
        return $path_parts[count($path_parts) - 1];
    }

    protected function logMessages()
    {
        if ($this->tests_passed) {
            $this->notice($this->uid . ' tests passed');
        } else {
            $this->error($this->uid . ' tests failed');
        }
    }

    protected function log($message, $to_console = false)
    {
        if ($to_console) {
            print $message . "\n";
        }
        $this->logger->info($message);
    }

    protected function notice($message, $to_console = false)
    {
        if ($to_console) {
            print $message . "\n";
        }
        $this->logger->notice($message);
    }

    protected function error($message, $to_console = true)
    {
        $this->tests_passed = false;
        $message = $this->base_url . ' ' . $this->uid . ': ' . $message;
        if ($to_console) {
            print $message . "\n";
        }
        $this->error_logger->error($message);
    }

    public static function autoExecute($parameters)
    {
        $class = get_called_class();
        $me = new $class($parameters);
        $me->execute();
        return $me;
    }
}