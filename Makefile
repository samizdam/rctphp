run:
	docker-compose up -d

ab-test:
	echo "Php-fpm:"
	docker-compose run --rm ab ab -c 1000 -n 100000 http://nginx:80/index.php
	echo "React php:"
	docker-compose run --rm ab ab -c 1000 -n 100000 http://nginx:81/

ab-test-to-logs:
	echo "Php-fpm:"
	docker-compose run --rm --user $$(id -u):$$(id -g) \
		ab \
		ab -c 1000 -n 100000 \
		-e php-fpm.csv \
		-g php-fpm.gnuplot \
		http://nginx:80/index.php > logs/php-fpm.log

	echo "React php:"
	docker-compose run --rm --user $$(id -u):$$(id -g) \
		ab \
		ab -c 1000 -n 100000 \
		-e react-php.csv \
		-g react-php.gnuplot \
		http://nginx:81/ > logs/react-php.log

	echo "All logs collected to logs/ directory:"
	ls -la logs/