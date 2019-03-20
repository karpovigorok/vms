# How to Install

1. Unpack and upload files in your web server root directory
![alt text](/images/vms-installer-files.png "Unpack and upload files in your web server root directory")
2. Please note, the code already contain .htaccess file for Apache web server.

For Nginx, you can use config bellow: 
```
server {
    listen 80;

    root /var/www/your-vms-site.com/public;
    index index.php index.html index.htm;
    
    rewrite ^/.env$ / redirect;

    server_name your-vms-site.com;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php7.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}

```

3. Directory **application/storage/** and subdirs should be writable (permissions 775 would be enought).

4. Edit .env file. Find and specify mysql connection. The database should be empty.
```
DB_HOST=database_host
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_username
DB_PASSWORD=databse_user_password
```

Specify the APP_KEY. You can get already generated key by the link https://tools.noxls.net/laravel_app_key.php

Specify the APP_URL - your website domain 

5. Open your website in browser.
The system will check and notify you about errors.
![alt text](/images/vms-installer-error.png "The system will check and notify you about errors")

6. On success, rename or delete install.php file
![alt text](/images/vms-installer-success.png "On success, rename or delete install.php file")


7. Click "Visit Your VMS Site" button 

8. Please note, by default website is disabled for search engines. You can change it by edit robots.txt

9. Please note, by default your Administrator user has login and password "admin". Don't forget to change password.

10. Please note, you need to delete or rename install.php file in your web root directory.

11. Please note, you need to change .env file parameters:
 - APP_DEBUG from true to false
 - APP_LOG_LEVEL from debug to error