#!/bin/bash

TIMESTAMP=$(date +"%Y-%m-%d %H:%M:%S")
BACKUP_DIR="/var/www/sis/"

cd $BACKUP_DIR || exit 1
echo "Backing up files in $BACKUP_DIR"

git add .
git commit -m "Backup on $TIMESTAMP"
git push origin main

if [ $? -eq 0 ]; then
    echo "Backup successful on $TIMESTAMP"
else
    echo "Backup failed on $TIMESTAMP"
fi
