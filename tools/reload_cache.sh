#!/bin/bash          
# cd ../

sudo chown -R www-data:vagrant /home/vagrant/symfony3_test
sudo chmod -R 775 /home/vagrant/symfony3_test

rm -fr /home/vagrant/symfony3_test/var
php /home/vagrant/symfony3_test/bin/console cache:clear --env=prod
php /home/vagrant/symfony3_test/bin/console cache:clear --env=dev
php /home/vagrant/symfony3_test/bin/console cache:clear --env=test

sudo chown -R www-data:vagrant /home/vagrant/symfony3_test
sudo chmod -R 775 /home/vagrant/symfony3_test


