# The Luck
### The InnoGames GmbH test project

<b>Database:</b> PosgreSQL <br>
<b>Backend:</b> PHP v7.4 (Laravel v6.0 LTS) <br>
<b>Frontend:</b> Vue.js <br>
<b>Managing:</b> Trello, https://trello.com/b/Qu8kgZne

## Installation
### Server
The project is tested with IIS 10 which explains the web.config in public folder <br>

#### Install Packages
<code>npm run build</code>

#### Database migration

```
php artisan migrate
php artisan db:seed
```

### .env file example
```
APP_NAME="The Luck"
APP_ENV=local
APP_KEY="use php artisan key:generate to generate the key"
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE={DB_NAME}
DB_USERNAME={DB_USERNAME}
DB_PASSWORD={DB_PASSWORD}

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

CONTESTANTS_PER_CONTEST=10
JUDGES_PER_ROUND=3
SICKNESS_PROBABILITY=5
```

## Images

### Image #1
When there is no contest available for the current `session`.
![Image of Yaktocat](https://github.com/farhadnowzari/the_luck/blob/master/blank_menu.png?raw=true)
### Image #2
Image #2 shows how a contest looks like with 6 contestants(Its adjudtable from the env file) <br>
`Note`: if the contestant gets sick a yellow frown face appears near their name.
![Image of Yaktocat](https://github.com/farhadnowzari/the_luck/blob/master/contest.png?raw=true)
### Image #3
Image #3 shows a main menu when the current `session` at least has one finished contest.
![Image of Yaktocat](https://github.com/farhadnowzari/the_luck/blob/master/filled_menu.png?raw=true)