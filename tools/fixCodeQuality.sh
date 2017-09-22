#!/bin/bash
cd /home/user/Projects/symfony3_test/

# Run PSR2 problems fixer:
php ~/Tools/phpcbf.phar --standard=PSR2 --no-patch /home/user/Projects/symfony3_test/src/
php ~/Tools/phpcbf.phar --standard=PSR2 --no-patch /home/user/Projects/symfony3_test/tests/

# Run php-cs-fixer latest version:
# php ~/Tools/php-cs-fixer_v1.12.0.phar fix --verbose
# rm -f /home/user/Projects/Hitmeister/sms/.php_cs.cache
#php ~/Tools/php-cs-fixer_v2.0.0.phar fix --verbose

# Run PSR2 problems checker:
#> ~/tmp/codeCheck.txt
#php ~/Tools/phpcs.phar --standard=PSR2 --ignore=/home/user/Projects/Hitmeister/sms/src/Hitmeister/AppBundle/Migrations/* /home/user/Projects/Hitmeister/sms/src/ > ~/tmp/codeCheck.txt
#php ~/Tools/phpcs.phar --standard=PSR2 /home/user/Projects/Hitmeister/sms/tests/ >> ~/tmp/codeCheck.txt

# Run PHP Mess Detector:
# php ~/Tools/phpmd.phar ~/Projects/Hitmeister/sms/src/ text ~/Projects/Hitmeister/sms/phpmd.xml >> ~/tmp/codeCheck.txt

# Open code check log file:
#gedit ~/tmp/codeCheck.txt
