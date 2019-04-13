@echo off

docker exec -it --user root --workdir /app php-corbomite-mailer bash -c "php %*"
