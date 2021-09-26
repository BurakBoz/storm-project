#!/bin/bash
php storm-project app:build storm-project
echo "Build complete."
echo "If you don't want to install system wide press CTRL + C"
sudo rm /bin/storm-project -f && sudo cp builds/storm-project /bin/ && echo "storm-project command installed to system";

