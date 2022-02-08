#!/bin/bash

cd docker/local
docker-compose exec -u 1000 hgs_app /bin/bash
