#!/bin/bash

cd /home/afeef/UnixProject/Simple_LAMP_NEW || exit 1

# Ensure we're on main
git checkout main
git pull origin main

if [ -z "$1" ]; then
    COMMIT_MSG="Auto commit: $(date '+%Y-%m-%d %H:%M:%S')"
else
    COMMIT_MSG="$1"
fi

git add .
git commit -m "$COMMIT_MSG"
git push origin main
echo "Pushed to main branch successfully!"