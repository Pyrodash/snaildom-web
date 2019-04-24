# snaildom-web

This repository contains the web, API and game files for Snaildom. This was very rushed due to my lack of PHP knowledge and care but feel free to submit a PR if you have any improvements.

## Features
1. Almost the same as the original website.
2. Easy to configure.
3. Register & registration logs.
4. Recaptcha for both login & registration.
5. In-game server selection instead of an HTML page.
6. Large amount of the game's functions were rewritten to allow you to set this up with the change of only a few things.
7. Fully functioning blog.

### Prerequisites
- Web server ([apache](https://httpd.apache.org/) or [nginx](https://www.nginx.com/)) (XAMPP or WAMP on windows)
- PHP (compatible with both 5 and 7)
- [The `phpredis` module](https://github.com/phpredis/phpredis)

### How to install phpredis
#### Which version?
You should use whichever version that supports your PHP version. If you're using PHP 5.6, the last release that supports it is [2.2.7]((https://pecl.php.net/package/redis/2.2.7/windows)) (thread safe). Versions 3.0.0 and above all support 7.x. Remember to click on the DLL links if you're on windows for downloads (and to check the supported versions)
#### Automatic
Run `pecl install redis` in the terminal.
#### Manual (Windows)
1. Download it from the [PECL website]((https://pecl.php.net/package/redis) (the thread safe one)
2. Extract the `php_redis.dll` to `XAMPP folder/php/ext/`.
3. Open `XAMPP folder/php/php.ini` in notepad.
4. Add this in a new line anywhere in the file (preferably after the last extension in the list):
For PHP 5:
`extension=php_redis.dll`
For PHP 7:
`extension=redis`
5. Restart Apache in the XAMPP control panel.

### Installation

1. Extract this package outside your webroot folder (i.e webroot -> ..). The HTML folder should be the webroot for your website, you can rename it to whatever you want as long as you configure your web server to use that name. I named it html because that's the most common. So on Linux you would extract this to `/var/www`. On windows, you would extract this to the XAMPP folder and rename html to htdocs (no reconfiguration needed as long as you rename it)
2. Import the database if you haven't already. (Should be in the [emulator's repo](https://github.com/Pyrodash/snaildom))
3. Add a new site to Google Recaptcha using Google Recaptcha v3. You can do that through the [Google Recaptcha Admin Console](https://www.google.com/recaptcha/admin/) (use `localhost` as a domain if you're using your local computer)
4. Navigate to `application/config` and rename the `snaildom.php.sample` to `snaildom.php`. Edit it and update the recaptcha secret & private keys with the ones you got after adding your site through the Google Recaptcha Admin Console.
6. In `application/config`, rename `database.php.sample` to `database.php`. Change the database settings to match the emulator's.
7. If you are on Linux, the permissions for the html/uploads folder should be 755. (i.e. `chmod 755 html/uploads`);
8. Navigate to `html/media/` and edit the `config.json`. You only need to change the host to the URL to your media files. E.g. `http://localhost/snaildom/media` (This should be the same as the media url in the snaildom.php config file. Trailing slash is optional here)

**Note:** The .FLA files used to modify the game (a dependency called `rewritten.swf` for everything game-related including the server selection, `snaildom.swf` the game's loader and container, and a dependency called `rewritten_create.swf` used to make the register functioning) are located in `html/media/snaildom/gs/edited`. Make sure to delete them before going into production if you don't want people to find the decompiled files on your website.


Special thanks to **ShawnTD/Reed** for his assistance in compiling the Snaildom files and modifying them.