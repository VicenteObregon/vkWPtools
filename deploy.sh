#!/bin/bash

project=${PWD##*/}
cd ..
rm -f $project.zip
zip -r $project $project -x $project/.git\* $project\*.sh
cd -
