<?php

namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Tests\TestControl;

class RunTestsCommand extends Command
{
    protected 
        $em,
        $config,
        $parameters,
        $envs = ['prod', 'stag', 'local'];

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }

    protected function configure()
    {
        $this->setName('ml:front-end-tests')
            ->setDescription('')
            ->setHelp('')
            ->addOption(
                'client_uids',
                's',
                InputOption::VALUE_REQUIRED,
                'comma separated list of client uids, if needed'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'check all clients for the specified environment'
            )
            ->addOption(
                'env',
                'e',
                InputOption::VALUE_REQUIRED,
                'prod|stag|local(default)'
            )
            ->addOption(
                'browser',
                null,
                InputOption::VALUE_REQUIRED,
                'chrome|firefox|edge -- currently only chrome'
            )
            ->addOption(
                'username',
                'u',
                InputOption::VALUE_REQUIRED,
                'override the username in the config; must be used with password'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_REQUIRED,
                'with username, override the config'
            )
            ->addOption(
                'usertype',
                't',
                InputOption::VALUE_REQUIRED,
                'limit to one of full|partial|admin. Admin is the default'
            )
            ->addOption(
                'log-no-details',
                'l',
                InputOption::VALUE_NONE,
                'log level info by default; use this to get only basic log messages, log level notice'
            )
            ->addOption(
                'clear-logs',
                'c',
                InputOption::VALUE_NONE,
                'erase the existing logs'
            )
            ->addOption(
                'no-db-writes',
                null,
                InputOption::VALUE_REQUIRED,
                'true|false. by default this will be true in prod mode, false in others. the login will still be written to the change log'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('RUNNING SELENIUM SANITY CHECKS');
        $this->parameters = array_merge($this->config, $input->getArguments(), $input->getOptions());

        $env = isset($this->parameters['env']) ? strtolower($this->parameters['env']) : 'local';
        if (!in_array($env, $this->envs)) {
            throw new \Exception('Env ' . $env . ' is not a recognized env. Choices are ' . implode(', ', $this->envs));
        }

        $this->parameters['loglevel'] = !empty($this->parameters['log-no-details']) ? 'notice' : 'info';

        if (!isset($this->parameters['usertype'])) {
            $this->parameters['usertype'] = 'admin';
        }

        if (!isset($this->parameters['no-db-writes'])) {
            $this->parameters['no-db-writes'] = $env == 'prod';
        }

        if (empty($this->parameters['client_uids']) && empty($this->parameters['all'])) {
            $this->parameters['all'] = true;
        }
        $client_configs = $this->config['clients'][$env];
        if (!empty($this->parameters['all'])) {
            $client_uids = array_keys($client_configs);
        } else {
            $client_uids = explode(',', strtolower($this->parameters['client_uids']));
        }

        foreach ($client_uids as $client_uid) {
            if (!empty($client_configs[$client_uid])) {
                $client_config = $client_configs[$client_uid];
            } else {
                $client_config = $this->findClientConfigByDomain($client_uid, $env);
                if (empty($client_config)) {
                    $output->writeln($client_uid . " not found");
                    continue;
                }
            }

            TestControl::autoExecute($this->parameters);

            // don't clear logs every time, just on the first for the loop
            if (isset($this->parameters['clear-logs'])) {
                unset($this->parameters['clear-logs']);
            }
        }
    }

    protected function findClientConfigByDomain($identifier, $env) {
        foreach ($this->config['clients'][$env] as $uid => $config) {
            $subdomain = strtolower($config['domain']);
            if (strtolower($subdomain) === $identifier) {
                return $config;
            }
        }

        return null;
    }
}

