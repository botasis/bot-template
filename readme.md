# Telegram bot template

All you need to start - to write your app logic, everything other is in the template.

## Quick Start

There are a few things to do assuming you have already
- created your telegram bot and know its token
- port 3306 for MySQL on your computer is opened (you can configure any other port of your choice, it's just the default value)

1. `git clone git@github.com:viktorprogger/bot-template.git`
2. Create `.env` file in the project root and set there your bot token to the key `BOT_TOKEN` like this: `BOT_TOKEN=12345:abcdef`. 
   See [`.env.example`](.env.example) to get list of all available environment variables
3. Run `docker compose build php`
4. Run `docker compose --profile console-tools run --rm --no-deps php composer i`
5. Run `docker compose --profile console-tools run --rm --no-deps php vendor/bin/rr get`
6. Run `docker compose --profile main up -d`
7. Type `/start` to your bot in Telegram, and you'll get an answer in half a minute (app asks for the [getUpdates](https://core.telegram.org/bots/api#getupdates) every 30 seconds)

## Available docker-compose profiles
This repo uses docker-compose profiles mechanism to get only needed services working

- `console-tools` - it start php service only, without DB, AMQP and other services. Useful to run `composer`, `psalm` and other console tools.
- `main` - get your application up and running. It starts `php`, `db` and `amqp` services.
- `full` - get working Loki and Grafana with Promtail for convenient logs reading. This app produces tons of logs, so these services will be useful to get in what's happening inside your app.

## Components
### DBAL
This app uses [yiisoft/yii-cycle](https://github.com/yiisoft/yii-cycle) as DBAL. 
In dev mode it automatically syncs your DB schema with your code, see `\Cycle\Schema\Generator\SyncTables` class.
