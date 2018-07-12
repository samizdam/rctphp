# rctphp


nginx
```
server {
        listen 8080;

        root /home/maxim/projects/Mine/reactPHPTest/src;

        index index.php;

        server_name localhost;

        access_log  /var/log/nginx/test_access.log;
        error_log   /var/log/nginx/test_error.log;


        location / {
                try_files $uri $uri/ =404;
        }

        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
               try_files $uri =404;
        }

        location ~ \.php$ {
               fastcgi_pass unix:/run/php/php7.1-fpm.sock;
               fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
               include        fastcgi_params;
        }
}

upstream backend  {
    server 127.0.0.1:8082;
    server 127.0.0.1:8083;
    server 127.0.0.1:8084;
    server 127.0.0.1:8085;
    server 127.0.0.1:8086;
    server 127.0.0.1:8087;
    server 127.0.0.1:8088;
}

server {
	listen 8888;

	server_name localhost;
	
        root /home/maxim/projects/Mine/reactPHPTest/src;

    	access_log  /var/log/nginx/react_test_access.log;
    	error_log   /var/log/nginx/react_test_error.log;

    	location / {
               proxy_pass http://backend;
        }

    	location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        	try_files $uri =404;
    	}

}
```