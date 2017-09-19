#!/bin/bash

sudo chown -R www-data:vagrant /home/vagrant/symfony3_test
sudo chmod -R 775 /home/vagrant/symfony3_test

php /home/vagrant/symfony3_test/bin/console --env=dev debug:router

sudo chown -R www-data:vagrant /home/vagrant/symfony3_test
sudo chmod -R 775 /home/vagrant/symfony3_test
