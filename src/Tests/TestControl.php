<?php 

namespace Tests;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;

class TestControl
{
    protected
        $parameters,
        $host,
        $env,
        $browser,
        $username,
        $password,
        $usertype,
        $logger,
        $loglevel = 'info',
        $base_url = '',
        $log_file = 'app/log/app.log',
        $error_log_file = 'app/log/error.log',
        $driver;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $this->host = 'http://localhost:4444/wd/hub';
        $this->env = !empty($parameters['env']) ? $parameters['env'] : 'local';
        $this->browser = !empty($parameters['browser']) ? $parameters['browser'] : 'chrome';
        $this->usertype = !empty($parameters['usertype']) ? $parameters['usertype'] : 'admin';
        $this->loglevel = !empty($parameters['loglevel']) ? strtolower($parameters['loglevel']) : 'info';
        $this->username = !empty($parameters['username']) 
            ? $parameters['username']
            : $parameters['user'][$this->env][$this->usertype]['username'];
        $this->password = !empty($parameters['password']) 
            ? $parameters['password']
            : $parameters['user'][$this->env][$this->usertype]['password'];
        $this->logger = new Logger('TestsInterface');
        $this->error_logger = new Logger('TestsInterfaceError');
        $log_level = $this->loglevel === 'notice' ? Logger::NOTICE : Logger::INFO;
        $this->logger->pushHandler(new StreamHandler($this->log_file, $log_level));
        $this->error_logger->pushHandler(new StreamHandler($this->error_log_file, Logger::ERROR));
        if ($parameters['clear-logs']) {
            $this->eraseLogs();
        }
        $this->getBaseUrl();
    }

    protected function execute()
    {
        $message = $this->getMessage();
        $this->logger->notice($message);

        if ($this->browser === 'firefox') {
            $capabilities = DesiredCapabilities::firefox();
        } else {
            $capabilities = DesiredCapabilities::chrome();
        }

        $this->driver = RemoteWebDriver::create($this->host, $capabilities, 4000);
        $this->driver->manage()->timeouts()->implicitlyWait = 10;
        $this->driver->manage()->window()->setSize(new WebDriverDimension(1200, 900));

        $this->login();
        $this->runTests();
        $this->logout();
        $this->driver->quit();
    }

    protected function getBaseUrl()
    {
        $this->base_url =  $this->parameters['clients'][$this->env]['domain'];
    }

    protected function login()
    {
        Login::autoExecute($this->getParams());
    }

    protected function logout()
    {
        Logout::autoExecute($this->getParams());
    }

    protected function runTests()
    {
        MainTest::autoExecute($this->getParams());
    }

    protected function getParams()
    {
        return [
            'driver' => $this->driver,
            'usertype' => $this->usertype,
            'username' => $this->username,
            'password' => $this->password,
            'base_url' => $this->base_url,
            'loglevel' => $this->loglevel,
            'logger' => $this->logger,
            'error_logger' => $this->error_logger,
        ];
    }

    protected function getMessage()
    {
        $msg = '*** TESTING ' . $this->base_url . ' FOR USER ' . $this->username . ' ***';

        return $msg;
    }

    protected function log($message)
    {
        $this->logger->info($message);
    }

    protected function eraseLogs()
    {
        $file = $this->log_file;
        $error_file = $this->error_log_file;
        file_put_contents($file, "");
        file_put_contents($error_file, "");
    }

    public static function autoExecute($parameters)
    {
        $class = get_called_class();
        $me = new $class($parameters);
        $me->execute();
        return $me;
    }
}