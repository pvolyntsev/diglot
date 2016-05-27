# Инструкция по установке приложения Diglot #

[Readme](https://github.com/pvolyntsev/diglot/blob/master/README.md)


####Минимальные требования####
- PHP 5.5+
- MySQL 5.0+
- [Composer](https://getcomposer.org/download/)
- php5-curl
- Java
- [ElasticSearch](https://github.com/elastic/elasticsearch/blob/master/README.textile)

##### Установить Elastic Search v 2.3.3 #####
```
wget https://download.elastic.co/elasticsearch/release/org/elasticsearch/distribution/deb/elasticsearch/2.3.3/elasticsearch-2.3.3.deb -O /tmp/elasticsearch-2.3.3.deb
sudo dpkg -I /tmp/elasticsearch-2.3.3.deb
```

Настроить файл конфигурации, установить host 127.0.0.1 и порт 9200
```
nano /etc/elasticsearch/elasticsearch.yaml
```

##### Установить плагин русской морфологии для Elastic Search #####
Описание https://github.com/imotov/elasticsearch-analysis-morphology

Для Elastic Search v2.3.3 для Ubuntu
```
cd /usr/share/elasticsearch
sudo bin/plugin install http://dl.bintray.com/content/imotov/elasticsearch-plugins/org/elasticsearch/elasticsearch-analysis-morphology/2.3.3/elasticsearch-analysis-morphology-2.3.3.zip
sudo service elasticsearch restart
```

Настроить морфологию

```
curl -XDELETE 'http://localhost:9200/diglot' && echo
curl -XPUT 'http://localhost:9200/diglot' -d '{
    "settings": {
        "analysis": {
            "analyzer": {
                "my_analyzer": {
                    "type": "custom",
                    "tokenizer": "standard",
                    "filter": ["lowercase", "russian_morphology", "english_morphology", "my_stopwords"]
                }
            },
            "filter": {
                "my_stopwords": {
                    "type": "stop",
                    "stopwords": "а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with"
                }
            }
        }
    }
}' && echo
curl -XPUT 'http://localhost:9200/diglot/type1/_mapping' -d '{
    "type1": {
        "_all" : {"analyzer" : "russian_morphology"},
        "properties" : {
            "title_translate" : { "type" : "string", "analyzer" : "russian_morphology" },
            "title_original" : { "type" : "string", "analyzer" : "russian_morphology" }
        }
    }
}' && echo
```

####Скопировать репозиторий####
```
cd /var/www
git clone https://github.com/pvolyntsev/diglot.git
cd diglot
composer global require "fxp/composer-asset-plugin:~1.1.4"
composer update
```

#### Создание БД ####
```
DROP DATABASE IF EXISTS `diglot`;
CREATE DATABASE IF NOT EXISTS `diglot` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON diglot.* TO diglot_rw@localhost IDENTIFIED BY '123456';
```

#### Миграция таблиц ####
```
cd /var/www/diglot
php yii migrate/up --migrationPath=@vendor/budyaga/yii2-users/migrations
php yii migrate/up
```
