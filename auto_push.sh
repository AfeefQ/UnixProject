#!/bin/bash

# If no commit message provided, use timestamp
if [ -z "$1" ]; then
    COMMIT_MSG="Automatic commit: $(date '+%Y-%m-%d %H:%M:%S')"
else
    COMMIT_MSG="$1"
fi


git add .
git commit -m "$COMMIT_MSG"


git push origin main
echo "Changes pushed to remote repository successfully!"
