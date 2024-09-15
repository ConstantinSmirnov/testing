dc_build:
	docker-compose -f ./docker/docker-compose.yml build

dc_up:
	docker-compose -f ./docker/docker-compose.yml up -d --remove-orphans

dc_ps:
	docker-compose -f ./docker/docker-compose.yml ps

dc_logs:
	docker-compose -f ./docker/docker-compose.yml logs -f

dc_down:
	docker-compose -f ./docker/docker-compose.yml down -v --rmi=all --remove-orphans


# Go inside container
app_bash:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bash