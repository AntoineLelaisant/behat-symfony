FROM mariadb:10
RUN echo "Europe/Paris" > /etc/timezone
RUN dpkg-reconfigure --frontend noninteractive tzdata
RUN mkdir -p /var/log/mysql && touch /var/log/mysql/mysql.log
RUN apt-get update && apt-get install -y --no-install-recommends vim && rm -r /var/lib/apt/lists/*
COPY conf.d/custom.cnf /etc/mysql/conf.d/custom.cnf
