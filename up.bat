@echo off

docker-compose -f docker-compose.yml -p corbomite-mailer up -d
docker exec -it --user root --workdir /app php-corbomite-mailer bash -c "cd /app && composer install"
