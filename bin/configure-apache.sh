#!/bin/bash

# configure apache

ENV=
DOC_ROOT=
PROJECT=

usage()
{
cat << EOF
    usage: $0 options

    OPTIONS:
       -h      Show this message
       -d      Document Root
       -e      Environment
       -p      Project
EOF
}

FORCE=0
ENV=
while getopts “hd:e:p:” OPTION
do
     case $OPTION in
         h)
             usage
             exit 1
             ;;
         d)

             DOC_ROOT=$OPTARG
             ;;
         e)
             ENV=$OPTARG
             ;;
         p)
             PROJECT=$OPTARG
             ;;
         ?)
             usage
             exit
             ;;
     esac
done

if [[ -z $DOC_ROOT ]] || [[ -z $ENV ]] || [[ -z $PROJECT ]]
then
     usage
     exit 1
fi

cat > /etc/apache2/sites-available/${PROJECT}.${ENV} <<EOF

<VirtualHost *:80>
	DocumentRoot $DOC_ROOT
	SetEnv APPLICATION_ENV $ENV
        ServerName ${PROJECT}.$ENV
	ErrorLog /var/log/apache2/${PROJECT}.$ENV.error.log
        <Directory "$DOC_ROOT">
           Options Indexes MultiViews FollowSymLinks
           AllowOverride All
           Order allow,deny
           Allow from all
        </Directory>
</VirtualHost>
EOF

ln -s /etc/apache2/sites-available/${PROJECT}.${ENV} /etc/apache2/sites-enabled/${PROJECT}.${ENV}

a2enmod rewrite

service apache2 restart
