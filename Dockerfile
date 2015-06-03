FROM centos:centos6
MAINTAINER The Gemini Platform Project <venkat@gemini-systems.net> - venkat

# install dependencies
RUN yum install -y httpd php php-mysql mysql

# copy sample-app to web dir
RUN mkdir -p /home/gemini/sample-app/
ADD . /home/gemini/sample-app/

# copy sample-app conf file
ADD sample-app.conf /etc/httpd/conf.d/sample-app.conf 

WORKDIR /home/gemini/sample-app/

# restart apache
#RUN service httpd restart
RUN chmod +x run.sh

EXPOSE 80

CMD ["/home/gemini/sample-app/run.sh"]
