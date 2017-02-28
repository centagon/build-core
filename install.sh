#!/bin/bash

# dive into the src directory
pushd src



function exitWith {
    popd
    exit $1
}

# install npm
function installNpm {
    npm install
    
}

# install bower
function installBower {
    npm install -g bower
}


# install bower
function installBowerComponents {
    bower install
}


installNpm
if [ $? != 0 ]; then
    exitWith $?;
fi


installBower
if [ $? != 0 ]; then
    exitWith $?;
fi


installBowerComponents
if [ $? != 0 ]; then
    exitWith $?;
fi


exitWith 0