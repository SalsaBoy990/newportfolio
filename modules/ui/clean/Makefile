SHELL = /bin/bash

FONTCUSTOM_FLAGS = --config _font/fontcustom.yml \
	--name=solbit \
	--no-hash \
	--output=assets/css/fonts/ \
	_font/

SASSFLAGS = --style nested -M

# sassc - a very fast SASS compiler written in C++
install-sass:
	sudo apt install fontcustom sassc

sass:
	#fontcustom compile $(FONTCUSTOM_FLAGS)
	sassc $(SASSFLAGS) _dev/sass/clean.sass > assets/css/clean.css

.DEFAULT_GOAL := all

.PHONY: all

all: sass

# Watch changes in SASS files and compile the CSS bundle
sass-watch:
	while true; do \
  		make; \
  		inotifywait -qre close_write ./_dev/sass; \
	done


# esbuild - a very fast JavaScript bundler written in Go
install-esbuild:
	npm install --save-exact esbuild

# create bundle from the source
esbuild:
	./node_modules/.bin/esbuild _dev/js/clean.js --bundle --sourcemap --target=es6 --outfile=assets/js/clean.js

esbuild-watch:
	./node_modules/.bin/esbuild _dev/js/clean.js --bundle --sourcemap --outfile=assets/js/clean.js --watch

