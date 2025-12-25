#!/bin/bash

cd "$(dirname "$0")"

git add .
git commit -m "automatic commit: $(date '+%Y-%m-%d %H:%M:%S')"

git push origin main
echo "Changes pushed to remote repo"
