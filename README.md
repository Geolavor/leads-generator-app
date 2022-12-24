> :warning: 20% of the software has not yet been published due to market research. Next year the whole thing should be available.

> :warning: The demo version does not allow you to run the search function.


<p align="center">
  <a href="#">
    <img src="https://github.com/LeadBrowser/app/blob/main/images/mini-white.png?raw=true" width="100px" alt="LeadBrowser logo" />
  </a>
</p>

<h1 align="center">LeadBrowser</h1>
<p align="center">Prospects AI browser. Unique AI tool to extract contact details from all over the Internet, from all over the world in the real time. Better alternative to Hunter.io and Snov.io</p>
<p align="center"><a href="http://leadbrowser.co">Try live demo</a></p>
<br />

<p align="center">
  <a href="https://www.npmjs.org/package/@leadbrowser/leadbrowser">
    <img src="https://img.shields.io/npm/v/@leadbrowser/leadbrowser/latest.svg" alt="NPM Version" />
  </a>
  <a href="https://github.com/leadbrowser/app/actions/workflows/tests.yml">
    <img src="https://github.com/leadbrowser/app/actions/workflows/tests.yml/badge.svg?branch=main" alt="Tests" />
  </a>
  <a href="https://discord.leadbrowser.io">
    <img src="https://img.shields.io/discord/811989166782021632?label=Discord" alt="LeadBrowser on Discord" />
  </a>
  <a href="https://github.com/leadbrowser/app/actions/workflows/nightly.yml">
    <img src="https://github.com/leadbrowser/app/actions/workflows/nightly.yml/badge.svg" alt="LeadBrowser Release Build Status" />
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

## Features

* 📁 **AI** (Soon) We classify websites, with the life of AI. This allows us to better match prospects.
* 🔄 **Live search** Prospects are searched in real time. That's why LeadBrowser is better than Hunter.io and Snov.io.
* 🙌 **Linkedin** We search for companies first. Then we check that the companies have the right people and only then do we assign the data. Without any extensions.
* 🚀 **Go to market** The tool is 100% ready to enter the market.

![alt text](https://github.com/LeadBrowser/app/blob/main/images/dashboard.png?raw=true)

<br>

## Compare us

Compared to paid tools, we perform better in almost every field. We want to go farther all the time and fully deliver value to our users that they won't find anywhere else. We strongly believe in our functionality.

![alt text](https://github.com/LeadBrowser/app/blob/main/images/compare-us.png?raw=true)

<br>

## Use-cases

* 📁 **Search for small businesses**
* 📁 **Information about active companies**
* 📁 **Analyze the market**

<br>

## Documentation

#### LeadBrowser Documentation [http://leadbrowser.co/docs](http://leadbrowser.co/docs)

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


**How to log in as admin:**

> _http(s)://example.com/admin/login_

```
email:admin@leadbrowser.co
password:admin123
```

<br>

## License

LeadBrowser is a truly opensource framework which will always be free under the [MIT License](https://github.com/LeadBrowser/app/blob/master/LICENSE).

### Security Vulnerabilities

Please don't disclose security vulnerabilities publicly. If you find any security vulnerability in LeadBrowser then please email us: mailto:mariuszmalek.dev@gmail.com.
