# Carrera Advanced RMS Statistic

This is a web app for different types of statistic for the data of Carrera Digital 124/132
races. The data is uploaded to this web app from a desktop app which acts as a race management system.

Desktop RMS app: https://github.com/wachjose88/carrera-advanced-rms

The web app is developed using [CodeIgniter](https://codeigniter.com/) 4.2.

## Requirements

To run the web app a web server with PHP >= 7.4 is required.

Depending on the used database provider it is required to install the
corresponding php library (e.g. sqlite3)

## Run local

For testing and development it is possible to run the web app using a local
dev server which is integrated. This local server uses a local sqlite database.

Run the server from the CLI:

```
cd src
php spark serve
```

Now the app is available on http://localhost:8080

More information about the local server can be found [here](https://codeigniter.com/user_guide/installation/running.html#local-development-server).

## Host on web server

For a productive usage of the web app it is required to host it on a suitable
web server.

Please consult the [documentation](https://codeigniter.com/user_guide/installation/running.html) of
CodeIgniter for more information and adapt the configuration in 
```src/.env``` accordingly.

To create the initial database schema use the sql file ```create-db-empty.sql```.

## Usage

The web app is protected by HTTP basic authentication. Default credentials
are stored in ```src/.htpasswd``` and for the local server in
```src/public/index.php```:

* Username: carrera
* Password: rms

To upload data to the web app open the desktop app and navigate to

```
Settings > Sync
```

and enter the following data:

* URL: http://localhost:8080/index.php/api/
* Username: carrera
* Password: rms
* Realm: Carrera RMS Statistics

Now click "Synchronize" to upload the racing results.