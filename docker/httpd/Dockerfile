FROM httpd:alpine

COPY httpd.conf /usr/local/apache2/conf/httpd.conf
COPY host.conf /usr/local/apache2/conf/host.conf
RUN echo "Include /usr/local/apache2/conf/host.conf" >> /usr/local/apache2/conf/httpd.conf

RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf

RUN { \
  echo 'IncludeOptional conf.d/*.conf'; \
} >> /usr/local/apache2/conf/httpd.conf \
  && mkdir /usr/local/apache2/conf.d