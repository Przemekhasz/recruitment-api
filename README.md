# Recruitment project

#### Postman
- [JSON link](https://www.getpostman.com/collections/e00e63258a3476125917)
- [API collection](https://app.getpostman.com/join-team?invite_code=ab5431dd4de4dce4b265a39fc974f8e9&target_code=519802c20851d693d791e5a1ac430ba1)

#### Endpoints
```bash
$ POST /api/sign-up
$ POST /api/sign-in
$ POST /api/me/profile
$ POST /api/me/upload-file
```

---

## Setup

#### Flow

1. Create database:

```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
```

2. Schema update:

```bash
$ php bin/console d:s:u --force
# or
$ php bin/console doctrine:schema:update --force
```

3. Migrations & Fixtures:

[DoctrineFixturesBundle](https://symfony.com/doc/3.5.x/bundles/DoctrineFixturesBundle/index.html)

Loading Fixtures
```bash
$ php bin/console doctrine:fixtures:load
# or 
$ php bin/console doctrine:fixtures:load --env=dev
```

#### Database
- [SF Intro](https://symfony.com/doc/current/doctrine.html)

## Tech

Clear cache 4 prod mode:

```
$ php bin/console cache:clear --env=prod --no-debug
$ php bin/console cache:warmup --env=prod --no-debug
$ php bin/console assets:install --env=prod --no-debug --symlink
```

## Deploy 2 prod:
- [SF Deploy Flow](https://symfony.com/doc/current/deployment.html)


## Test
- [SF Testing](https://symfony.com/doc/current/testing.html)
