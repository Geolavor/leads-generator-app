> :warning: 20% of the software has not yet been published due to market research. Next year the whole thing should be available.

> :warning: The demo version does not allow you to run the search function.


<p align="center">
  <a href="#">
    <img src="https://github.com/LeadBrowser/app/blob/main/images/mini-white.png?raw=true" width="100px" alt="LeadBrowser logo" />
  </a>
</p>

<h1 align="center">LeadBrowser</h1>
<p align="center">Prospects AI browser. Unique AI tool to extract contact details from all over the Internet, from all over the world in the real time. Better alternative to Hunter.io and Snov.io</p>
<p align="center"><a href="http://leadbrowser.co" target="_blank">Live demo</a> | <a href="https://mariuszmalek.notion.site/313cf5e7333a44df8f934dbf7b3432ca?v=1e910d54ee3c4008892a266328280a92" target="_blank">Documentation</a> | <a href="https://mariuszmalek.notion.site/1908b69787e24e5c8d4d5d83392495a3?v=7f1b76e330154b59a9ae49a08f3cc4ca" target="_blank">FAQ</a> | <a href="https://discord.gg/MqGkh3Wt" target="_blank">Discord</a></p>

<br />

<p align="center">
  <a href="https://www.codetriage.com/leadbrowser/leads-generator-app" target="_blank">
    <img src="https://www.codetriage.com/leadbrowser/leads-generator-app/badges/users.svg" alt="LeadBrowser on codetriage" />
  </a>
</p>

<br>

## Getting Started

If you are using Snov.io or Hunter.io, with LeadBrowser you will be able to get better data on your own server for free! I'm a supporter of true democracy and decentralization, so I'm betting on transparency and I'm sure that our community will overtake all solutions present on the market. Create web3 with me!

![alt text](https://github.com/LeadBrowser/app/blob/main/images/landing.png?raw=true)

LeadBrowser is a tool designed to help users find high-quality, up-to-date data.
It uses a browser-like interface to search for information, allowing users to easily find the data they need. With its ability to search for and extract data from a variety of sources, including LinkedIn, LeadBrowser is able to find better data than many other tools that rely on off-the-shelf databases. 

Additionally, LeadBrowser can quickly and easily extract data from LinkedIn profiles without the need for any plugins, providing users with ready-to-use data in just a few minutes. Overall, LeadBrowser is a versatile and efficient tool for finding and extracting high-quality data.

<br>

## How to use the LeadBrowser?
1. You can go to the "Database" tab in search page and buy a finished result that someone else has already found.
2. You can enter the "Live search" tab in search page and start looking for new companies, by phrase and specific parameters.

<p align="center"><a href="https://youtu.be/QuLQ615UDo0">Check video presentation</a></p>

<br>

## Features 🚀

* **AI Classify**, we classify websites, with the life of AI. This allows us to better match prospects.
* **Live search** function. Prospects are searched in real time. It works similarly to a browser.
* **Linkedin** search. We search for employees from Linkedin without any browser plug-in/extension.
* **Go to market**, the tool is 100% ready to enter the market.
* **DNS** information (who owns it and dates).
* **Validation** mail.
* **AI Risk** calculation of contact with a prospect.
* **Search phrase**, any words you can search on the page.
* **AI Observer** function. Your prospects and evaluates future prospects based on what you have generated in the past.
* **Web Archive** integration. Checking when the site was created and the ability to retrieve past data.
* **Technologies** catching from website.
* **ChatGPT** integration.
* **External traffic** monitoring and tracking.


![alt text](https://github.com/LeadBrowser/app/blob/main/images/dashboard.png?raw=true)

<br>

![alt text](https://github.com/LeadBrowser/app/blob/main/images/ai.png?raw=true)

<br>

## Compare us

Compared to paid tools, we perform better in almost every field. We want to go farther all the time and fully deliver value to our users that they won't find anywhere else. We strongly believe in our functionality.

![alt text](https://github.com/LeadBrowser/app/blob/main/images/compare-us.png?raw=true)

<br>

## Use-cases 📁

* **Search for small businesses**
* **Information about active companies**
* **Analyze the market**

<br>

## Documentation

#### LeadBrowser Documentation: [Open documentation](https://mariuszmalek.notion.site/313cf5e7333a44df8f934dbf7b3432ca?v=1e910d54ee3c4008892a266328280a92)

![alt text](https://github.com/LeadBrowser/app/blob/main/images/fnc.png?raw=true)

<br>

## Requirements

-   **SERVER**: Apache 2 or NGINX.
-   **RAM**: 3 GB or higher.
-   **PHP**: 7.4 or higher.
-   **For MySQL users**: 5.7.23 or higher.
-   **For MariaDB users**: 10.2.7 or Higher.
-   **Node**: 8.11.3 LTS or higher.
-   **Composer**: 1.6.5 or higher.

<br>

## Installation and Configuration

-   Find **.env** file in root directory and change the **APP_URL** param to your **domain**.

-   Also, Configure the **Mail** and **Database** parameters inside **.env** file.

```
php artisan leadbrowser:install
```

When you are done, remember to upload the database with countries, provinces and cities. Without this, the search will not work.

**To execute LeadBrowser**:

##### On server:

Warning: Before going into production mode we recommend you uninstall developer dependencies.
In order to do that, run the command below:

> composer install --no-dev

```
Open the specified entry point in your hosts file in your browser or make an entry in hosts file if not done.
```

##### On local:

```
php artisan route:clear
php artisan serve
```

##### Docker:

All docker commands are abstracted into [Makefile](./Makefile) instructions.

They are very simple and often just instead of the `docker-compose` command you need to write `make` in your terminal.

Of course, you can still use the `docker-compose` commands in the terminal, but you should remember that development and production environments rely on different docker-compose files. 

Example:
```
# Make command
make up

# Full command
docker-compose -f docker-compose.dev.yml up -d
```

Because *make* commands are much easier to use than full docker-compose commands, I prefer and recommend using them, so free to explore them and edit according to your needs.

### Start containers

```bash
# Make command
make up

# Full command
docker-compose -f docker-compose.dev.yml up -d
```

Now you can open [http://localhost:8000](http://localhost:8000) URL in your browser.

### Stop containers

```bash
# Make command
make down

# Full command
docker-compose -f docker-compose.dev.yml down
```

### Bash aliases

Also, there is a set of [bash aliases](./aliases.sh) which you can apply using the command:

```bash
source aliases.sh
```

Now to run any artisan command you can use:

```bash
artisan make:model Product
```

### Logs

All laravel logs are forwarded to the docker log collector via the `stderr` channel.

See the latest logs, running the command:

```bash
docker-compose logs app
```

### Storage

To use the `public` disk of the Laravel storage system you need to create a symlink.

The symlink should be relative to work properly inside the docker environment and outside it at the same time.

First, you need to install `symfony/filesystem` package which allows generating relative symlinks.

```bash
docker-compose -f docker-compose.dev.yml exec app composer require symfony/filesystem --dev
```

Then create the symlink using the command:

```bash
# Make command
make storage:link

# Raw command
docker-compose -f docker-compose.dev.yml exec app php artisan storage:link --relative
```

On production environment it will be created automatically.


**How to log in as admin:**

> _http(s)://example.com/admin/login_

```
email:admin@leadbrowser.co
password:password
```

<br>

## Contact

Mariusz Malek (author)
> Linkedin: https://www.linkedin.com/in/mariuszmalek/
> Mail: mariuszmalek.dev@gmail.com

You can find us in our Discord server: <a href="https://discord.gg/MqGkh3Wt" target="_blank">Link to server</a>

<br>

## License

LeadBrowser is a truly opensource framework which will always be free under the [MIT License](https://github.com/LeadBrowser/app/blob/master/LICENSE).

Security Vulnerabilities

Please don't disclose security vulnerabilities publicly. If you find any security vulnerability in LeadBrowser then please email us: mailto:mariuszmalek.dev@gmail.com.
