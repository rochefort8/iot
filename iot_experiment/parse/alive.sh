#!/bin/bash

cd $(dirname $0)
date >> alive.txt
php alive.php
