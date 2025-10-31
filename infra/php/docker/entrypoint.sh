#!/bin/bash

# Start cron service
service cron start

# Execute the main command
exec "$@"
