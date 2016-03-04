# WP Bedrock-base

WP Bedrock-base is a base Wordpress installation which follows the great work from the [Bedrock Wordpress stack](https://roots.io/bedrock/).
Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

It also combines gulp workflow tools provided by the fantasic [Ahmad Awais](https://github.com/ahmadawais/Advanced-Gulp-WordPress) with BrowserSync.

It also implements the [Foundation for Sites 6.2](https://github.com/zurb/foundation-sites-template) SCSS/JS framework into a base theme to get started.


## Requirements

* PHP >= 5.5
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

1. Clone the git repo - `git clone https://github.com/bpdons/wp-bedrock-base`
2. Run `composer install`
3. Copy `.env.example` to `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
  * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT` - Generate with [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command) or from the [WordPress Salt Generator](https://api.wordpress.org/secret-key/1.1/salt/)
4. Change folders to `web/app/themes/base-theme`
5. Run `npm install` to install the Node Packages/dependencies.
6. Set your site vhost document root to `/path/to/site/web/` (`/path/to/site/current/web/` if using deploys)
7. Run `gulp` to compile the css/js/html watcher and brings up BrowserSync. 
8. Access WP admin at `http://example.com/wp/wp-admin`

## Deploys

There are two methods to deploy Bedrock sites out of the box:

* [Trellis](https://github.com/roots/trellis)
* [bedrock-capistrano](https://github.com/roots/bedrock-capistrano)

Any other deployment method can be used as well with one requirement:

`composer install` must be run as part of the deploy process.

## Documentation

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
Advanced Gulp workflow for Wordpress documentation is available at [https://ahmadawais.com/my-advanced-gulp-workflow-for-wordpress-themes/](https://ahmadawais.com/my-advanced-gulp-workflow-for-wordpress-themes/)
Foundation for Sites 6.2 documentation is available at [http://foundation.zurb.com/sites/docs/](http://foundation.zurb.com/sites/docs/)


### Thanks
