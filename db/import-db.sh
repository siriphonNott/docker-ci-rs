#!/bin/bash

mysql -u root -p${MYSQL_ROOT_PASSWORD}

CREATE DATABASE new_database; 

exit

mysql -u root -p${MYSQL_ROOT_PASSWORD} rm_crm < dump.sql