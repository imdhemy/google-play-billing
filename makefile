.PHONY: build bash start

start: build bash

build:
	@if ! docker images | grep -q imdhemy/liap; then \
		docker build -t imdhemy/liap .; \
	fi

bash:
	docker run --rm -it --name liap-container -v $(PWD):/var/www imdhemy/liap bash

%:
	@:
