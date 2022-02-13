#!/bin/bash

cd docker/dev
docker-compose exec -u 1000 hgs_app /bin/bash
