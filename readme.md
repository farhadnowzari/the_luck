# The Luck
### The InnoGames GmbH test project

<b>Database:</b> PosgreSQL <br>
<b>Backend:</b> PHP v7.4 (Laravel v6.0 LTS) <br>
<b>Frontend:</b> Vue.js <br>
<b>Managing:</b> Trello, https://trello.com/b/Qu8kgZne

## Installation
### Server
The project is tested with IIS 10 which explains the web.config in public folder <br>

### Installation steps
```
- composer install
- npm install
- create .env file from sample
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
```

### .env file example
```
APP_NAME="The Luck"
APP_ENV=local
APP_KEY=
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
## Config
1. <b>Number of contestants per contest:</b> this value is adjustable from .env file
2. <b>Number of judges per contest:</b> this value is adjustable from .env file
3. <b>Sickness probability:</b> this value is adjustable from .env file
4. <b>Number of rounds per contest:</b> You can adjust this value by simply toggle the active field in genres table
5. <b>Bonus point:</b> The bonus point is just usable by FriendlyJudge but you can change for any judges if its needed for future changes. you can set the value in Judges table.
## Images

### Image #1
When there is no contest available for the current `session`.
![Image of Yaktocat](https://github.com/farhadnowzari/the_luck/blob/master/blank_menu_1.png?raw=true)
### Image #2
Image #2 shows how a contest looks like with 10 contestants(Its adjudtable from the env file) <br>
`Note`: if the contestant gets sick a red frown face appears near their name.
![Image of Yaktocat](https://github.com/farhadnowzari/the_luck/blob/master/contest_1.png?raw=true)
### Image #3
Image #3 shows a main menu when the current `session` at least has one finished contest.
![Image of Yaktocat](https://github.com/farhadnowzari/the_luck/blob/master/filled_menu_1.png?raw=true)

## Short description
Normally I would also disable Lazy loading because it can cost performance issues. but instead I just tried to eager load everything that I needed in my ORM queries, but its better that it gets disabled so no one in a team mistakenly loads a relation in a for loop, 'n' time(s).