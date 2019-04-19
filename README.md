# snaildom-web

This repository contains the web, API and game files for Snaildom. This was very rushed due to my lack of PHP knowledge and care but feel free to submit a PR if you have any improvements.

## Features
1. Almost the same as the original website.
2. Easy to configure.
3. Register w/ captcha & registration logs.
4. In-game server selection instead of an HTML page.
5. Large amount of the game's functions were rewritten to allow you to set this up with the change of only a few things.

### Prerequisites
- Web server ([apache](https://httpd.apache.org/) or [nginx](https://www.nginx.com/))
- PHP (not sure if this is compatible with 7.x, tested with 5.5)
- [The `phpredis` module](https://github.com/phpredis/phpredis)

### Installation

1. Import the database if you haven't already. (Should be in the [emulator's repo](https://github.com/Pyrodash/snaildom))
2. Add a new site to Google Recaptcha using Google Recaptcha v3. You can do that through the [Google Recaptcha Admin Console](https://www.google.com/recaptcha/admin/) (use `localhost` if you're using your local computer)
3. Navigate to `snaildom-web/snaildom/play/api` and edit the `config.php`. Change the database settings to match the emulator's and update the recaptcha secret & private keys with the ones you got after adding your site through the Google Recaptcha Admin Console.
4. Update the `baseURL` and `playURL` constants with wherever you're hosting the media.

E.g. If the website was on snaildom.com and the play page was on play.snaildom.com, `baseURL` would be `http://snaildom.com` and `playURL` would be `http://play.snaildom.com`. Don't forget to use `https://` instead of `http://` if you're using SSL!

5. Navigate to `snaildom-web/play` and edit the `config.json`. You only need to change the host to wherever your play page is. E.g. `http://play.snaildom.com`

**Note:** The .FLA files used to modify the game (a dependency called `rewritten.swf` for everything game-related including the server selection, `snaildom.swf` the game's loader and container, and a dependency called `rewritten_create.swf` used to make the register functioning) are located in `snaildom-web/play/snaildom/gs/edited`. Make sure to delete them before going into production if you don't want people to find the decompiled files on your website.


Special thanks to **ShawnTD/Reed** for his assistance in compiling the Snaildom files and modifying them.