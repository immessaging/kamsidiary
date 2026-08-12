# Kamsi Diary Pages

## Folder structure

- index.html (your existing home page)
- biography.html
- about.html
- features.html
- how-it-works.html
- testimonials.html
- contact.html
- signup.html
- signin.html
- admin-dashboard.php
- user-dashboard.php
- biography-save.php
- testimonial-submit.php
- contact-submit.php
- signup.php
- signin.php
- logout.php
- config.php
- database.sql
- css/kamsi-pages.css
- image/main_image.png

## Main image

The CSS expects the image at:

image/main_image.png

because the shared CSS file is inside:

css/kamsi-pages.css

Therefore the correct relative path is:

../image/main_image.png

## PHP setup

1. Put the project inside a PHP/MySQL server such as XAMPP, Laragon, WAMP or a hosting server.
2. Create the MySQL database by importing database.sql.
3. Edit config.php with your real database credentials.
4. Create the first admin account using the users table, then change its role from user to admin.
5. Use HTTPS in production.
6. Keep config.php and database.sql inaccessible from the web.

## Security notes

The supplied PHP uses:
- PDO prepared statements
- password_hash/password_verify
- session regeneration after login
- login/admin authorization checks
- output escaping
- same-origin links
- rel="noopener noreferrer" on external target="_blank" links
- security response headers in .htaccess

For production, add CSRF tokens to every state-changing POST form, rate limiting, email verification, password-reset flows, audit logging, secure cookie flags, and a proper secret/configuration system.
