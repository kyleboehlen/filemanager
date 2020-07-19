# Basic File Manager

## Installation
Before installing verify your system has the following requirements:
- php7.1 or higher with the extensions
- imagemagick
- apache2
- MySQL (MariaDB)
- git
- composer (added to the PATH)
- npm

<br/>
Start by cloning into the repository

`cd /var/www/html && sudo git clone https://github.com/kyleboehlen/filemanager`

<br/>
Change the ownership and permissions

`sudo chown -R www-data:{your_user_group} filemanager && sudo chmod -R 775 filemanager`

<br/>
Install the required depdendencies

`cd filemanager && composer install && npm install`

<br/>
Generate the .css and .js files

`npm run prod`

<br/>
Create a copy of the enviroment file from the template

`cp .env.example .env`

<br/>
Generate the application encryption key

`php artisan key:generate`

<br/>
Change the apache2 webroot to the laravel public folder
- Change to the apache2 root directory and open the configuration file

   `cd /etc/apache2/sites-available && sudo nano 000-default.conf`
- Edit the document root option to:

   `DocumentRoot /var/www/html/filemanager/public`
- Or, if you'd prefer to create VHosts you can <a src="https://www.ostechnix.com/configure-apache-virtual-hosts-ubuntu-part-1/">do that</a>

<br/>
In order to allow laravel to handle URLs, make sure the apache mod_rewrite extension is enabled and allow overrides
- Edit apache2.conf to allow overrides

   `cd /etc/apache2/ && sudo nano apache2.conf`
- Add the following to the directory settings

```
   <Directory /var/www/html/filemanager/public>

      Options Indexes FollowSymLinks

      AllowOverride All

      Require all granted

   </Directory>
```

- Enable mod_rewrite extension

   `sudo a2enmod rewrite`
- Restart apache2

   `sudo service apache2 restart`

<br/>
Create a nysql database and create a new user to grant all privliages to the database on. Be sure to fill out the DB .env vars

- DB_DATABASE=
- DB_USERNAME=
- DB_PASSWORD=

<br/>
Run the deployment for the migrations, seeds, etc. If you have a global install of phpunit it's probably going to error out, use the Laravel install.

`cd /var/www/html/filemanager && alias vendor_phpunit=vendor/phpunit/phpunit/phpunit && vendor_phpunit --testsuite Deploy`

<br/>
Change the php.ini file to let Laravel handle file upload sizes (if desired)

`upload_max_filesize = 0`
`post_max_size = 0`

<br/><br/>
### _Make sure these steps are completed last_ 

Optimize the autoloader class

   `composer install --optimize-autoloader --no-dev`

<br/>
Cache the configuration

   `php artisan config:cache`


Optimize route loading

   `php artisan route:cache`

<br/><br/>

## Notes

### Requirements
- [x] Allow uploading and persisting .jpg and .mp4 files
- [x] Show a UI where users can upload new files, and show the list of files uploaded so far
- [x] Provide a way to "preview" the uploaded files. For images, we want to see the image, and for mp4's, play the video
- [x] Write basic tests for your code, and document a way to run them (see Testing)

### Extra Requirements
- [x] Add a login mechanism, and allow each user to have their own list of files (see Auth)
- [x] Add a way to associate a title, description and tags with a file and have those changes persist.
- [ ] Allow for filtering the list of files with search terms that can match these new fields (see Tags)
- [x] Use a responsive layout that works and looks great on desktops and mobile devices (see Responsive Design)
- [ ] Max filesize storage
- [ ] Attribution

### Auth
You'll notice this app just uses the basic Laravel auth defaults (boostrap and vue). I haven't used bootstrap before, I usually do custom sass, but I can see how it can be useful in something like this or an MVP. I'd be happy to show some custom sass in some personal codebases

I'd really like to learn Vue or Angular as well, had always leaned toward Vue as it was Laravel's default, but I haven't quite had the chance yet with my personal projects.

### Responsive Design
As I mentioned above in Auth, the site is styled with bootstrap so it is already responsive. Kinda cheating. Okay actually kinda fun how simple it can be. That being said, I still prefer to write my styles with custom sass in my personal projects, because idk just really nitpicky I guess, and would be happy to show you examples of responsive design in a personal codebase.

### Tags
I utilized the boostrap-tagsinput jQuery plugin for this

### Testing
To make validation testing in the upload easier I used the trait packaged in jasonmccreary/laravel-test-assertions. Unit tests can be ran using the laravel install of phpunit using

`vendor_phpunit --testsuite Unit`

You did alias it... right?
