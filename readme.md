# Telegram bot template

All you need to start - to write your app logic, everything other is in the template.

## Quick Start

There are a few things to do assuming you have already created your telegram bot and port 3306 for MySQL on your computer are opened:

1. `git clone git@github.com:viktorprogger/bot-template.git`
2. Create `.env` file in the project root and set there your bot token to the key `BOT_TOKEN` like this: `BOT_TOKEN=12345:abcdef`
3. Run console command `docker compose --profile warmup up -d`. It will pull and up MySQL and RabbitMQ services.
4. Run console command `docker compose build php`. You can do it in parallel with the previous command.
5. When the php service is built, run `docker compose --profile main up -d`
6. Type `/start` to your bot in Telegram
