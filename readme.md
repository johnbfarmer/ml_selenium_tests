# initial setup
these notes are specific to OS X tho they may work on other 'nixes
make sure you have the Java SDK up to date -- probably need to restart after installing, then 
clone this repo to <some_dir> and cd to <some_dir> and run composer install
copy app/parameters_eg.yml to app/parameters.yml and set usernames & passwords & client configs accordingly

# run the server:
```
./start_server
```

# alternatively, run the server in a separate terminal (from the bin directory:
```
java -jar selenium-server-standalone-3.0.1.jar
```

# run the command:
```
app/console ml:front-end-tests -c -estag -tstandard
```
the options available are
* client_uids (not used currently, future expansion)
* env (prod|stag|local)
* browser (chrome | firefox, but only the former works presently)
* username (if not the one specified in config, can be overridden)
* password (if not the one specified in config, can be overridden)
* usertype (admin|ref|captain|standard) -- admin is the default
* log-no-details -- less verbose logging

# for more current and complete information on options
```
app/console ml:front-end-tests --help
```

# read the logs
```
cat app/log/error.log  # hope it's empty!
cat app/log/app.log
```

# terminate the server:
```
./stop_server
```

# references
* http://facebook.github.io/php-webdriver/index.html
* https://github.com/facebook/php-webdriver

