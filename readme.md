# Telegram bot template

It's a ready-to-use application template meant to boost creation of a new Telegram bot for you. 
All you need to start is to write your app logic, everything other is in the template.

## Quick Start
### Prerequisites
- Your Telegram bot is created via [@BotFather](https://t.me/BotFather), and you know its token
- The latest version of `docker` is installed and running
- Port 3306 for MySQL on your computer is opened (you can configure any other port of your choice in the `.env` file, it's just the default value)

### Installing
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

- `console-tools` - starts php service only, without DB, AMQP and other services. Useful to run `composer`, `psalm` and other console tools.
- `main` - get your application up and running. It starts `php`, `db` and `amqp` services.
- `full` - get working Loki, Grafana and Promtail for convenient logs reading. This app produces tons of logs, so these services will be useful to get in what's happening inside your app.

To get everything down regardless of a set of running services, run `docker compose down --remove-orphans`

## Components
### DBAL
This app uses [yiisoft/yii-cycle](https://github.com/yiisoft/yii-cycle) as DBAL. 
In dev mode it automatically syncs your DB schema with your code, see `\Cycle\Schema\Generator\SyncTables` class.
