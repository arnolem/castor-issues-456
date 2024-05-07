## Install PHP 8.3 on Ubuntu 24.04 LTS

PHP
```bash
sudo apt install php8.3-cli
```

Composer
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

## Install castor with installer

```bash
curl "https://castor.jolicode.com/install" | bash
```

## Install globally

```bash
mv /home/<USER>/.local/bin/castor /usr/local/bin/castor
```

> Restart your terminal

## Setup the castor project

```bash
$ castor

[WARNING] Could not find root "castor.php" file.                                                                       
Do you want to create a new project? (yes/no) [no]:
yes
```

## Verify Castor version and command

```bash
$ castor -V
castor v0.15.0

$ castor list --raw
completion   Dump the shell completion script
hello        Welcome to Castor!
help         Display help for a command
list         List commands
```

## Try to use ``castor composer``
(As explained in [the documentation](https://castor.jolicode.com/going-further/extending-castor/remote-imports/#manipulating-castor-composer-file))
```bash
$ castor composer require "phpseclib/phpseclib"

Command "composer" is not defined.
```

## Try to use directly ``composer``
(As view on [this example](https://github.com/monsieurbiz/SyliusPluginMaker/blob/master/castor.php) in [the documentation](https://castor.jolicode.com/examples/#real-world-examples))

```bash
$ composer require "phpseclib/phpseclib"

./composer.json has been created
[...]
Writing lock file
[...]
Using version ^3.0 for phpseclib/phpseclib
[...]
Generating autoload files
```

## Test Castor

```bash
$ castor hello

Hello arnaud!
=============
```

## Declare a new Task to try to use external library SFTP and test it

```php
<?php

use Castor\Attribute\AsTask;
use phpseclib3\Net\SFTP;

#[AsTask]
function sftp(): void
{
    $sftp = new SFTP('127.0.0.1');
}
```

Test it -> Failed ❌
```bash
$ castor sftp

In castor.php line 9:
Class "phpseclib3\Net\SFTP" not found
```

Add autoload ?
```php
<?php

use Castor\Attribute\AsTask;
use phpseclib3\Net\SFTP;

require_once __DIR__ . '/vendor/autoload.php';

#[AsTask]
function sftp(): void
{
    $sftp = new SFTP('127.0.0.1');
    dd(get_class($sftp));
}
```

Test it -> Good ✅
```bash
$ castor sftp

^ "phpseclib3\Net\SFTP"
```

## Package the application
(according to [the documentation](https://castor.jolicode.com/going-further/extending-castor/repack/))

```bash
$ composer require jolicode/castor

Using version ^0.15.0 for jolicode/castor
```
> ☝️ I will not continue with this step because it is not the purpose of this demonstration.

## Retry my sftp function

Try -> Good ✅
```bash
$ castor sftp
^ "phpseclib3\Net\SFTP"
```

## Now, I want to upgrade Castor for new packaging option

```json
{
    "require": {
        "phpseclib/phpseclib": "^3.0",
        "jolicode/castor": "dev-main"
    }
}
```

```bash
$ composer update

[...]
Upgrading jolicode/castor (v0.15.0 => dev-main 505a4c0): Checking out 505a4c05e5 from cache
```

## Retry my sftp function

Try -> Good ✅
```bash
$ castor sftp

19:45:05 WARNING   [castor] User Deprecated: Since castor 0.16: The "Castor\Descriptor\TaskDescriptorCollection" class is deprecated, use "Castor\Descriptor\DescriptorsCollection" instead. ["exception" => ErrorException { …}]

In TaskCommand.php line 39:
                                                                                                                                                                                                     
  Castor\Console\Command\TaskCommand::__construct(): Argument #2 ($expressionLanguage) must be of type Castor\ExpressionLanguage, Castor\EventDispatcher given, called in phar:///home/arnaud/.loc   
  al/bin/castor/src/Console/Application.php on line 148                                                                                                                                              
                                                                                                                                                                                                     
```