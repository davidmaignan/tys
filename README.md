Testyrskills.com
========================

Welcome 

1) Installing 
----------------------------------

When it comes to installing you have the following options.

### Use Composer (*recommended*)

As Symfony uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

    php composer.phar install

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.

