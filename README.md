# docker-www

## Host:
- apt install nginx
- cd /etc/nginx/site-available
- nano pypip.id.conf:
```
server {
    listen 80;
    listen [::]:80;

    #root /var/www/pypip.id/html;
    #index index.php index.html index.htm index.nginx-debian.html;

    server_name pypip.id www.pypip.id;

    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```
- ln -s /etc/nginx/sites-available/pypip.id.conf /etc/nginx/sites-enabled/
- systemctl restart nginx
- akses: http://pypip.id

## SSL
- snap install core; sudo snap refresh core
- apt remove certbot
- snap install --classic certbot
- ln -s /snap/bin/certbot /usr/bin/certbot

--- cek nginx conf
- sudo nginx -t
- sudo systemctl reload nginx

--- minta SSL
- certbot --nginx -d ex1.pypip.id -d www.pypip.id
- sudo systemctl status snap.certbot.renew.service (verifikasi auto renew jalan)
- certbot renew --dry-run
- https://pypip.id/

## Database
- restore: cat backup.sql | docker exec -i CONTAINER /usr/bin/mysql -u root --password=root DATABASE
- backup: docker exec CONTAINER /usr/bin/mysqldump -u root --password=root DATABASE > DATABASE.sql
- user:
```
GRANT USAGE ON *.* To USER_BARU IDENTIFIED by 'PASSWORD';
GRANT ALL PRIVILEGES ON DATABASE.* TO USER_BARU;
```

## Permison www-data
- chown -R www-data:www-data public
- chmod -R 755

## File Upload Size
- Tambahkan di nginx.conf, baik di host dan container (setelah server{):
client_max_body_size 15M;

Ubah php.ini (config container):
- upload_max_filesize = 15M
- post_max_size = 15M

(optional) config in container: 
cd /usr/local/etc/php