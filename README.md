# temirkhan/blog

[![Build Status](https://travis-ci.org/TemirkhanN/test-blog.svg?branch=master)](https://travis-ci.org/TemirkhanN/test-blog)
[![Coverage Status](https://coveralls.io/repos/github/TemirkhanN/test-blog/badge.svg?branch=master)](https://coveralls.io/github/TemirkhanN/test-blog?branch=master)

# Тестовый блог

После перекантовки откровенно сырой.
Не хватает:
- редактирование/удаление публикаций;
- добавление комментариев

Откровенно хромают:
- фильтрация публикаций
- разграничение прав доступа (app-sec layer)
- разделение слоев (пересекаются app и domain)
- маппинг сущностей

### Установка/развертывание

```shell
$ git clone https://github.com/TemirkhanN/test-blog.git
$ docker-compose up --build -d
```

Блог поднимется по адресу http://localhost

>Если восьмидесятый порт уже занят, поставьте свободный в docker-compose.

```yaml
  frontend:
    ports:
      - "81:80"
```
