# XCMSL
XML based content and ticket management system

## Requirement
1. PHP
2. MYSQL

## Configruations
**File:** datastore.sql - File containing schema

**File:** config.php

Variable | Description
-------- | --------
$user_file | File to store user information
$xml_dir   | Directory of working XML files
$webview_dir | Directory to webview folder
$appview_dir | Directory to appview Folder
$from | Mail from field
$gscid | Google OAuth ID
$servername | Database server host
$dbuser | Database username
$dbpass | Database password
$dbname| Database name

Make sure xml_dir, uploads, app and all defined directories with write permissions i.e. chmod 0777


## Directory Structure
Directory | Description
-------- | --------
./app | Store in-application related files e.g. XML files generated are store here.
./appview | Mock-up in-mobile app view using Framework7
./css | Store XCMSL css files
./do | Files to handle Ajax related queries e.g. Save XML, Delete XML, Login etc.
./email | Contain text files e.g. default email Format with variables _RUSER_ , #_ID and _URL_
./img | Store XCMSL images files  
./js | Store XCMSL JavaScript files  
./plugin | Store XCMSL plugin xonomy https://github.com/michmech/xonomy, editor used to edit xml files in html form.
./uploads | Store files uploaded via XCMSL image upload
./webview | Mock-up web app view using Framework7
./webview_externam | Web app for to be hosted as a site


## Change Log

v1
+ Initial
+ User Management
+ Image Upload

v2
+ Changed XML Editor with Defination
+ Custom Preview
+ Fixed Bugs

v2.1
+ Fixed Several Bugs  Regarding escape characters and xml formatting
+ Fixed Json and Ajax queries

v3
+ Added Webview

v4
+ Added Appview
+ Bugs Fixed

v5
+ Added Ticket
+ Optimization

v6
+ Progress
+ External Webview

v7
+ Added Email Function
+ Google Oauth API
+ Javascript Fixes

v8
+ Implemented Mysql
+ Bootstrap v4
