# WP Bedrock-base

WP Bedrock-base is a base Wordpress installation which follows the great work from the [Bedrock Wordpress stack](https://roots.io/bedrock/).
Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

It also combines gulp workflow tools provided by the fantasic [Ahmad Awais](https://github.com/ahmadawais/Advanced-Gulp-WordPress) with BrowserSync.

It also implements the [Foundation for Sites 6.2](https://github.com/zurb/foundation-sites-template) SCSS/JS framework into a base theme to get started.

* Better folder structure
* Dependency management with [Composer](http://getcomposer.org)
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
* Autoloader for mu-plugins (use regular plugins as mu-plugins)
* Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))

Use [Trellis](https://github.com/roots/trellis) for additional features:

* Easy development environments with [Vagrant](http://www.vagrantup.com/)
* Easy server provisioning with [Ansible](http://www.ansible.com/) (Ubuntu 14.04, PHP 5.6 or HHVM, MariaDB)
* One-command deploys

See a complete working example in the [roots-example-project.com repo](https://github.com/roots/roots-example-project.com).

## Requirements

* PHP >= 5.6
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

  If you want to automatically generate the security keys (assuming you have wp-cli installed locally) you can use the very handy [wp-cli-dotenv-command][wp-cli-dotenv]:
      
      wp package install aaemnnosttv/wp-cli-dotenv-command

      wp dotenv salts regenerate

  Or, you can cut and paste from the [Roots WordPress Salt Generator][roots-wp-salt].

4. Add theme(s) in `web/app/themes` as you would for a normal WordPress site.
5. Change to your base-theme folder.
6. Run `npm install` to install the Node Packages/dependencies.

7. Set your site vhost document root to `/path/to/site/web/` (`/path/to/site/current/web/` if using deploys)
8. Run `gulp` to compile the css/js/html watcher and brings up BrowserSync.
9. Access WP admin at `http://example.com/wp/wp-admin`


## Documentation

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
Advanced Gulp workflow for Wordpress documentation is available at [https://ahmadawais.com/my-advanced-gulp-workflow-for-wordpress-themes/](https://ahmadawais.com/my-advanced-gulp-workflow-for-wordpress-themes/)
Foundation for Sites 6.2 documentation is available at [http://foundation.zurb.com/sites/docs/](http://foundation.zurb.com/sites/docs/)


### Thanks
