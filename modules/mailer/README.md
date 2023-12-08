# Install Mailhog

sudo apt-get -y install golang-go
go get github.com/mailhog/MailHog


## Install mhsendmail

A sendmail replacement which forwards mail to an SMTP server.
In our case to Mailcatcher's SMTP local server.

wget https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64

sudo chmod +x mhsendmail_linux_amd64

sudo mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail

Edit php.ini

php -i | grep 'php.ini'

sendmail_path = /usr/local/bin/mhsendmail


mhsendmail test@mailhog.local <<EOF
From: Salman <kinsta@mailhog.local>
To: Test <test@mailhog.local>
Subject: Hello, MailHog!

Hey there,
Missing you pig time.

Hogs & Kisses,
Salman
EOF



sudo apt-get install -qy ruby ruby-dev rubygems build-essential libsqlite3-dev

sudo gem install mailcatcher

mailcatcher

http://127.0.0.1:1080/
