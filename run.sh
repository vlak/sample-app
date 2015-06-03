#!/bin/bash
chown apache:apache /home/gemini/sample-app/ -R
#source /etc/apache2/envvars
#exec apache2 -D FOREGROUND

echo "DB_PORT_3306_TCP_ADDR = $DB_PORT_3306_TCP_ADDR"
echo "DB_ENV_MYSQL_USER=$DB_ENV_MYSQL_USER"
echo "DB_ENV_MYSQL_PASSWORD=$DB_ENV_MYSQL_PASSWORD"
echo "MYSQL_USER=$MYSQL_USER"
echo "MYSQL_PASSWORD=$MYSQL_PASSWORD"

if [ -z "$DB_ENV_MYSQL_USER" ]
then
  export DB_ENV_MYSQL_USER=$MYSQL_USER
fi
if [ -z "$DB_ENV_MYSQL_PASSWORD" ]
then
  export DB_ENV_MYSQL_PASSWORD=$MYSQL_PASSWORD
fi

echo "DB_ENV_MYSQL_USER=$DB_ENV_MYSQL_USER"
echo "DB_ENV_MYSQL_PASSWORD=$DB_ENV_MYSQL_PASSWORD"

sleep 30

# create database
echo "--running cmd: mysql -u$DB_ENV_MYSQL_USER -p$DB_ENV_MYSQL_PASSWORD -h$DB_PORT_3306_TCP_ADDR -P$DB_PORT_3306_TCP_PORT -e \"CREATE DATABASE IF NOT EXISTS \`sample-app\`\""
mysql -u$DB_ENV_MYSQL_USER -p$DB_ENV_MYSQL_PASSWORD -h$DB_PORT_3306_TCP_ADDR -P$DB_PORT_3306_TCP_PORT -e "CREATE DATABASE IF NOT EXISTS \`sample-app\`"
echo "command exit code: $?"
# create table
echo "--running cmd: mysql --database=sample-app -u$DB_ENV_MYSQL_USER -p$DB_ENV_MYSQL_PASSWORD -h$DB_PORT_3306_TCP_ADDR -P$DB_PORT_3306_TCP_PORT < \"samples.sql\""
mysql --database=sample-app -u$DB_ENV_MYSQL_USER -p$DB_ENV_MYSQL_PASSWORD -h$DB_PORT_3306_TCP_ADDR -P$DB_PORT_3306_TCP_PORT < "samples.sql"
echo "command exit code: $?"
#

echo "export DB_PORT_3306_TCP_ADDR=$DB_PORT_3306_TCP_ADDR" >> /etc/sysconfig/httpd
echo "export DB_PORT_3306_TCP_PORT=$DB_PORT_3306_TCP_PORT" >> /etc/sysconfig/httpd
echo "export DB_ENV_MYSQL_USER=$DB_ENV_MYSQL_USER" >> /etc/sysconfig/httpd
echo "export DB_ENV_MYSQL_PASSWORD=$DB_ENV_MYSQL_PASSWORD" >> /etc/sysconfig/httpd

service httpd restart
tail -f /var/log/httpd/error_log