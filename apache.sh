#!/bin/bash

rm -rf /Applications/mampstack-8.1.9-0/apache2/htdocs/*
cp -r ~/Desktop/projects/camagru/ /Applications/mampstack-8.1.9-0/apache2/htdocs/
rm -rf /Applications/mampstack-8.1.9-0/apache2/htdocs/.git /Applications/mampstack-8.1.9-0/apache2/htdocs/apache.sh
