# PHP-FPM vs. ReactPhp Benchmark

## Requirements

Docker & docker-compose. 

Also you can run included applications on local installed nginx and php.
See config files in `docker/` directory. 

## Actions after Cloning
 
`make composer-install`

`make run`

`make ab-test` - run benchmark in terminal. 

`make ab-test-to-logs` - for get logging. 

Also you can run local installed ab util on this patients:
```
# fpm
ab -c 100 -n 10000 http://127.0.0.1:8080/index.php
# react app (via nginx or not, depends from your way - docker or on localhost)
ab -c 100 -n 10000 http://127.0.0.1:8081/ 
```

## Contributing

You can for this repository and make pull requests with other configurations. All tuning and language will be suggested.  

## Nginx configuration: 
See [/docker/nginx/](/docker/nginx). 

## Application 
See [/src](/src). 

## Results

Current revision on my old good notebook get next results:

```

samizdam@samizdam ~/dev/rctphp (master) $ make ab-test
echo "Php-fpm:"
Php-fpm:
docker-compose run --rm ab ab -c 100 -n 10000 http://nginx:80/index.php
This is ApacheBench, Version 2.3 <$Revision: 1826891 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking nginx (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        nginx/1.15.1
Server Hostname:        nginx
Server Port:            80

Document Path:          /index.php
Document Length:        26 bytes

Concurrency Level:      100
Time taken for tests:   30.477 seconds
Complete requests:      10000
Failed requests:        0
Total transferred:      1890000 bytes
HTML transferred:       260000 bytes
Requests per second:    328.12 [#/sec] (mean)
Time per request:       304.768 [ms] (mean)
Time per request:       3.048 [ms] (mean, across all concurrent requests)
Transfer rate:          60.56 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.1      0      15
Processing:    23  303  68.0    278     521
Waiting:       12  303  68.0    278     521
Total:         27  303  67.8    279     521

Percentage of the requests served within a certain time (ms)
  50%    279
  66%    296
  75%    383
  80%    391
  90%    403
  95%    412
  98%    421
  99%    442
 100%    521 (longest request)
echo "React php:"
React php:
docker-compose run --rm ab ab -c 100 -n 10000 http://nginx:81/
This is ApacheBench, Version 2.3 <$Revision: 1826891 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking nginx (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        nginx/1.15.1
Server Hostname:        nginx
Server Port:            81

Document Path:          /
Document Length:        27 bytes

Concurrency Level:      100
Time taken for tests:   3.302 seconds
Complete requests:      10000
Failed requests:        0
Total transferred:      1970000 bytes
HTML transferred:       270000 bytes
Requests per second:    3028.92 [#/sec] (mean)
Time per request:       33.015 [ms] (mean)
Time per request:       0.330 [ms] (mean, across all concurrent requests)
Transfer rate:          582.71 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.2      0      16
Processing:     5   30 244.6      9    3276
Waiting:        2   30 244.6      9    3276
Total:          6   30 245.1      9    3283

Percentage of the requests served within a certain time (ms)
  50%      9
  66%      9
  75%      9
  80%     10
  90%     13
  95%     14
  98%     20
  99%     41
 100%   3283 (longest request)


```

Configuration: 
- nginx:
    - worker_connections 1024, 
-ab:
    - -c 100 -n 1000


React Win with:
```
Metric:   |  Time taken for tests | Requests per second | Time per request    
==================================|=======================================
React php:|  3.302 seconds        | 3028.92 [#/sec]     | 33.015
php-fpm:  |  30.477 seconds       | 328.12 [#/sec]      | 304.768 [ms] (mean)
========================================================|=================
Rate:     |  *10                  | *10                 | *10
``` 

### 1000 Concurrency Results

I up worker_connections to 4096 for both patients can work. 

Configuration:
- nginx:
    - worker_connections 4096
- ab:
    - c 1000 -n 100000  
    
```
samizdam@samizdam ~/dev/rctphp (1000-concurrency) $ make ab-test
echo "Php-fpm:"
Php-fpm:
docker-compose run --rm ab ab -c 1000 -n 100000 http://nginx:80/index.php
This is ApacheBench, Version 2.3 <$Revision: 1826891 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking nginx (be patient)
Completed 10000 requests
Completed 20000 requests
Completed 30000 requests
Completed 40000 requests
Completed 50000 requests
Completed 60000 requests
Completed 70000 requests
Completed 80000 requests
Completed 90000 requests
Completed 100000 requests
Finished 100000 requests


Server Software:        nginx/1.15.1
Server Hostname:        nginx
Server Port:            80

Document Path:          /index.php
Document Length:        26 bytes

Concurrency Level:      1000
Time taken for tests:   248.043 seconds
Complete requests:      100000
Failed requests:        2737
   (Connect: 0, Receive: 0, Length: 2737, Exceptions: 0)
Non-2xx responses:      2737
Total transferred:      19304797 bytes
HTML transferred:       3024049 bytes
Requests per second:    403.16 [#/sec] (mean)
Time per request:       2480.428 [ms] (mean)
Time per request:       2.480 [ms] (mean, across all concurrent requests)
Transfer rate:          76.00 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    6  75.6      0    1044
Processing:    31 2259 9680.5    280   83982
Waiting:        8 2259 9680.5    280   83982
Total:         79 2265 9712.7    281   83982

Percentage of the requests served within a certain time (ms)
  50%    281
  66%    363
  75%    429
  80%    491
  90%   1404
  95%   3670
  98%  60002
  99%  61122
 100%  83982 (longest request)
echo "React php:"
React php:
docker-compose run --rm ab ab -c 1000 -n 100000 http://nginx:81/
This is ApacheBench, Version 2.3 <$Revision: 1826891 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking nginx (be patient)
Completed 10000 requests
Completed 20000 requests
Completed 30000 requests
Completed 40000 requests
Completed 50000 requests
Completed 60000 requests
Completed 70000 requests
Completed 80000 requests
Completed 90000 requests
Completed 100000 requests
Finished 100000 requests


Server Software:        nginx/1.15.1
Server Hostname:        nginx
Server Port:            81

Document Path:          /
Document Length:        27 bytes

Concurrency Level:      1000
Time taken for tests:   68.720 seconds
Complete requests:      100000
Failed requests:        365
   (Connect: 0, Receive: 0, Length: 365, Exceptions: 0)
Non-2xx responses:      365
Total transferred:      19752195 bytes
HTML transferred:       2756940 bytes
Requests per second:    1455.19 [#/sec] (mean)
Time per request:       687.196 [ms] (mean)
Time per request:       0.687 [ms] (mean, across all concurrent requests)
Transfer rate:          280.70 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    4  61.6      0    1043
Processing:     5  507 4799.1     13   67322
Waiting:        2  507 4799.1     13   67322
Total:          7  511 4800.6     13   67382

Percentage of the requests served within a certain time (ms)
  50%     13
  66%     16
  75%     18
  80%     19
  90%     27
  95%     48
  98%   2047
  99%   7518
 100%  67382 (longest request)

```

React Win with:
```
Metric:   |  Time taken for tests | Requests per second | Time per request | Non-2xx responses
==================================|===================================================
React php:|  68.720 seconds       | 1455.19 [#/sec]     | 687.196 [ms]     | 365
php-fpm:  |  248.043 seconds      | 403.16 [#/sec]      | 2480.428 [ms]    | 2737
========================================================|=============================
Rate:     |  *4                   | *3                  | *4               | *6