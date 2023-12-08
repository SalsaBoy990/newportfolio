SHELL = /bin/bash

SASSFLAGS = --style nested -M

# sassc - a very fast SASS compiler written in C++
install-sass:
	sudo apt install sassc

sass:
	sassc $(SASSFLAGS) _dev/sass/frontpage.sass > assets/css/frontpage2.css

.DEFAULT_GOAL := all

.PHONY: all

all: sass

# Watch changes in SASS files and compile the CSS bundle
sass-watch:
	while true; do \
  		make; \
  		inotifywait -qre close_write ./_dev/sass; \
	done


