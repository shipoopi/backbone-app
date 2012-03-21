#!/bin/bash


# install basic packages
apt-get update

sudo apt-get -y  install \
  git-core \
  php5 php5-cli php-apc php5-mysql php5-xdebug phpunit php-pear php5-xdebug  \
  apache2 openssh-client vim php5-curl


# install Doctrine

pear channel-discover pear.doctrine-project.org
pear channel-discover pear.symfony-project.com
pear channel-discover pear.symfony.com
pear install doctrine/DoctrineORM

# Doctrine migrations dependencies
cd /usr/share/php
sudo git clone git://github.com/doctrine/migrations.git /usr/share/php/migrations
sudo ln -s /usr/share/php/migrations/lib/Doctrine/DBAL/Migrations /usr/share/php/Doctrine/DBAL/Migrations


# install zend framework
pear channel-discover zend.googlecode.com/svn
pear install zend/Zend
