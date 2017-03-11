# initial setup
these notes are specific to OS X tho they may work on other 'nixes
make sure you have the Java SDK up to date -- probably need to restart after installing, then 
clone this repo to <some_dir> and cd to <some_dir> and run
run composer install
copy app/parameters_eg.yml to app/parameters.yml and set usernames & passwords & client configs accordingly

# run the server:
cd bin
java -jar selenium-server-standalone-3.0.1.jar  > /dev/null&
cd ..
(shell script ./start_server does this too)

# alternatively, run the server in a separate terminal:
java -jar selenium-server-standalone-3.0.1.jar

# run the KO script:
app/console ko:front-end-tests
the options available are
* client_uids (eg frontline or merf)
* env (prod|stag|local)
* browser (chrome | firefox, but only the former works presently)
* username (if not the one specified in config, can be overridden)
* password (if not the one specified in config, can be overridden)
* usertype (admin|full|partial) -- full is the default
* loglevel (info|notice) -- info is the default and is more verbose
app/console ko:front-end-tests --help (for this info, but may be more up-to-date)

# run sanity checks on all clients
chmod a+x run_all.sh (if necessary)
./run_all.sh

# read the logs
cat app/log/app.log
cat app/log/error.log

# if using one terminal, you can terminate the server using
fg
^C
(shell script ./stop_server now does this)

# references
* http://facebook.github.io/php-webdriver/index.html
* https://github.com/facebook/php-webdriver

