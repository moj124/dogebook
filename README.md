# Dogebook
Dogebook is a Symfony application created to learn the ins and out of Symfony on the idea of create Dogs' Facebook.

### Sitemap Plan:
  [<p><img src="https://github.com/moj124/dogebook/blob/main/public/resources/images/sitemap.png" width="35%"><p>](https://www.gloomaps.com/nbjvQJtPtA)

## Environments
- Local: [localhost:8000](https://localhost:8000) & [404 Page](https://localhost:8000/_error/404)

## Installation

### Mac/Linux

#### Brew:
```
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

#### PHP: 

Please check the php version matches the [requirements](#requirements).

```
brew install php
brew services start php@7.4
php --version
```

#### Docker:

Please check the docker version matches the [requirements](#requirements).

```
brew cask install docker
docker --version
```

#### Composer:
```
php composer-setup.php --install-dir=bin --filename=composer
```

To add a global alias `composer` to your system, instead of `php bin/composer`, run the below command. 
```
mv composer.phar /usr/local/bin/composer
```

#### Symfony:

Check that your system has the right requirements:

```
symfony check:requirements
```

To add a global alias `symfony` to your system, run the below command. [Docs](https://symfony.com/download). 

```
brew install symfony-cli/tap/symfony-cli
```

### Requirements
- Docker: [www.docker.com/get-started](https://www.docker.com/get-started)
- Composer: [getcomposer.org/doc/00-intro.md](https://getcomposer.org/doc/00-intro.md)
- PHP: PHP@^7.4
- Symfony: [symfony.com/doc/current/setup.html](https://symfony.com/doc/current/setup.html)
## Run
```
make dev
```
## Git Workflow
