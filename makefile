DOCKER_IMAGE=gpb:8.3

build:
	docker build -t $(DOCKER_IMAGE) .

run:
	docker run --rm -v $(PWD):/app -v $(PWD)/vendor:/app/vendor -w /app $(DOCKER_IMAGE) $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
