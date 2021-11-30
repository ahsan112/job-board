### Overview

this is an implementation of a job board 

### Usage

Using docker to get started

``` bash
docker-compose up --build 
```

migrate the tables and seed
``` bash
docker-compose run --rm artisan migrate --seed
```

should be running on localhost:8000


