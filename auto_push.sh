#!/bin/bash

# Navigate to correct directory
cd /home/afeef/UnixProject/Simple_LAMP_NEW || {
    echo "Error: Cannot navigate to project directory"
    exit 1
}

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