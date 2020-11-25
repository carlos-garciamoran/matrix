![MATRIX](public/images/logo-orig.png)

## Overview
MATRIX can be deployed at boarding schools as a central management system. Among other functionalities, users can post announcements or reminders in the school's news board. A daily newsletter with that content is sent by default to all users.

Student users can:
- sign-in / sign-out
- make requests for overnight trips

Advisors/Teachers can:
- check their advisee's trip history
- allow / deny overnight trips
- make requests for a leave of absence

Several user roles (e.g. duty advisors, moderators, administrators, etc.) can be assigned to perform privileged tasks.

## Technology stack
Key | Value
------------ | -------------
Front-end | Bootstrap 4
Back-end | Laravel 5.8
Database | MySQL
Mailing driver | Mailgun
Deployment | Laravel Envoyer

## Installation instructions
1. Create the DB
2. Clone the repository
3. Install vendor dependencies
4. Setup the `.env` file
5. Run the DB migrations
6. Create a symlink for public storage

> Check `Envoyer.blade.php` as an example production deployment.


## TL;DR
```bash
mysql -u root -p -e "CREATE DATABASE <DATABASE_NAME>"
git clone git@github.com:carlosgmoran/matrix.git
cd matrix
composer install
[ ! -f .env ] && cp .env.example .env
php artisan migrate
php artisan storage:link
```

