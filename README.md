# Dogebook
Dogebook is a Symfony application created to learn the ins and out of Symfony on the idea of create Dogs' Facebook.

### Sitemap Plan:
  [<p><img src="https://github.com/moj124/dogebook/blob/main/public/resources/images/sitemap.png" width="35%"><p>](https://www.gloomaps.com/nbjvQJtPtA)
  
### Kanban Board:
  [<p><img width="35%" alt="Screenshot 2022-04-05 at 22 10 01" src="https://user-images.githubusercontent.com/32649229/161849658-f63982c4-5bd9-47aa-a03a-a5981642ef31.png"><p>](https://www.notion.so/af6e85e83ddd45be9f12525a7a0da854?v=e8ce83ff98064b3cb87560e545a2d496)
    
### Figma Site Design:
  [<p><img width="10%" alt="Screenshot 2022-04-05 at 22 10 01" src="https://user-images.githubusercontent.com/32649229/161850645-70f2b1fe-1ca7-4b7f-a588-c1533da6e564.svg"><p>](https://www.figma.com/file/HtpSRUdIA4lW0fh2vLeyX2/Dogebook?node-id=0%3A1)

### Database Schema:
  [<p><img width="35%" alt="Screenshot 2022-04-05 at 22 10 01" src="https://user-images.githubusercontent.com/32649229/165402738-6f4bdbdd-4ecf-4ff1-8eea-5ebd1c90f580.png"><p>](https://dbdiagram.io/d/625ebbb31072ae0b6aac0958)

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

To add a node, I use NVM to manage the node versions:

```
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
```

Then set your node to use version 12.0 via NVM

```
nvm install 12
```
### Requirements
- Docker: [www.docker.com/get-started](https://www.docker.com/get-started)
- Composer: [getcomposer.org/doc/00-intro.md](https://getcomposer.org/doc/00-intro.md)
- PHP: PHP@^7.4
- Symfony: [symfony.com/doc/current/setup.html](https://symfony.com/doc/current/setup.html)
- Node: node@^12.0
## Run
```
make dev
```

Then run webpack to compile your `assests/` into `build/`:

```
yarn dev-server
```
## Git Workflow
