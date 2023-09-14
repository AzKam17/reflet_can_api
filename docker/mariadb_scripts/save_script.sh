#!/bin/bash

# Define the backup filename with the current date and time
backup_filename="/root/saves/prod_$(date +'%d_%m_%Y_%H_%M').sql"

# Perform a database backup using mysqldump
mariadb-dump -u root --password="${MYSQL_ROOT_PASSWORD}" rc_can_app > "$backup_filename"

# Check if the backup was successful
if [ $? -eq 0 ]; then
  echo "Database backup completed successfully. Backup saved to: $backup_filename"
else
  echo "Database backup failed."
fi
