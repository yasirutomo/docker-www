# docker-www

## Host:
- apt install nginx
- cd /etc/nginx/site-available
- nano pypip.id.conf:
server {
    listen 80;
    listen [::]:80;

    #root /var/www/ex1.pypip.id/html;
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
-----------
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
- certbot --nginx -d ex1.pypip.id -d www....
- sudo systemctl status snap.certbot.renew.service (verifikasi auto renew jalan)
- certbot renew --dry-run
- https://ex1.pypip.id/
