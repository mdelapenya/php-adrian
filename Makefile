build:
	- docker build -t mdelapenya/adrian .
run:
	- docker run -v `pwd`:/app -p 80:80 mdelapenya/adrian