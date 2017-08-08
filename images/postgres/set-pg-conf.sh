#!/bin/bash

# Set recommended for TeamCity settings
# https://confluence.jetbrains.com/pages/viewpage.action?pageId=74847395#HowTo...-ConfigureNewlyInstalledPostgreSQLServer
PG_CONF=/var/lib/postgresql/data/postgresql.conf

grep -q -F 'synchronous_commit=off' $PG_CONF || echo 'synchronous_commit=off' >> $PG_CONF
