#!/usr/bin/env bash

function info {
  echo " "
  echo "--> $1"
  echo " "
}

apt-get update

sudo apt-get install -y nginx php5-fpm php5-cli php-apc php5-pgsql php5-mysql

info "Configure PHP-FPM"
sudo sed -i 's/user = www-data/user = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sudo sed -i 's/group = www-data/group = vagrant/g' /etc/php5/fpm/pool.d/www.conf
sudo sed -i 's/owner = www-data/owner = vagrant/g' /etc/php5/fpm/pool.d/www.conf
echo "Done!"

info "Configure NGINX"
sudo sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
sudo ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"

info "Restart web-stack"
sudo service php5-fpm restart
sudo service nginx restart
#sudo service postgresql restart
echo "Done!"
