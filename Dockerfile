FROM mdelapenya/lamp

RUN set -x && \
    apt-get update && \
    apt-get install -y sendmail

COPY . /app