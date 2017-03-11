#! /bin/bash

ps -ef | grep selenium-server | grep -v grep | awk '{print $2}' | xargs kill -9