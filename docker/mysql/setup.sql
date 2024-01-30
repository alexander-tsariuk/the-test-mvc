use `test`;

CREATE TABLE IF NOT EXISTS  comments(
                         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         name varchar(40) not null comment 'Имя пользователя',
                         email varchar(255) not null unique comment 'E-mail пользователя',
                         title varchar(40) not null comment 'Заголовок коммента',
                         comment text not null comment 'Текст коммента',
                         created_at timestamp default now() comment 'Время создания коммента'
);
