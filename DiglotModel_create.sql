-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2016-05-05 20:03:17.597

-- tables
-- Table: Article
CREATE TABLE Article (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    title varchar(100) NOT NULL,
    category varchar(100) NOT NULL,
    url varchar(500) NOT NULL,
    id_status int NOT NULL DEFAULT 0,
    date_create timestamp NULL,
    date_modified timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
    date_deleted timestamp NOT NULL,
    CONSTRAINT Article_pk PRIMARY KEY (id)
) COMMENT ''
COMMENT 'Статья';

-- Table: Comments
CREATE TABLE Comments (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    id_person int NOT NULL,
    id_article int NOT NULL,
    comment text NULL,
    date_create timestamp NULL,
    CONSTRAINT Comments_pk PRIMARY KEY (id)
) COMMENT ''
COMMENT 'Комментарии к статьям';

-- Table: Paragraph
CREATE TABLE Paragraph (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    id_article int NOT NULL,
    paragraph text NULL,
    date_modified timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT Paragraph_pk PRIMARY KEY (id)
) COMMENT ''
COMMENT 'Абзац в статье, который может быть и ссылкой на картинку';

-- Table: Person
CREATE TABLE Person (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    login text NULL,
    password varchar(40) NULL,
    name text NULL,
    description text NOT NULL,
    url varchar(500) NOT NULL,
    date_registry timestamp NULL,
    CONSTRAINT Person_pk PRIMARY KEY (id)
) COMMENT ''
COMMENT 'Автор, читатель или редактор статьи';

-- Table: Selected_article
CREATE TABLE Selected_article (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    id_person int NOT NULL,
    id_article int NOT NULL,
    date_selected timestamp NULL,
    date_deleted timestamp NOT NULL,
    CONSTRAINT Selected_article_pk PRIMARY KEY (id)
);

-- Table: Selected_author
CREATE TABLE Selected_author (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    id_person int NOT NULL,
    id_author int NOT NULL,
    date_selected timestamp NULL,
    date_deleted timestamp NOT NULL,
    CONSTRAINT Selected_author_pk PRIMARY KEY (id)
) COMMENT ''
COMMENT 'Избранный автор';

-- Table: Selected_paragraph
CREATE TABLE Selected_paragraph (
    id int NOT NULL DEFAULT 0 AUTO_INCREMENT,
    id_person int NOT NULL,
    id_article int NOT NULL,
    date_modified timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
    date_deleted timestamp NOT NULL,
    CONSTRAINT Selected_paragraph_pk PRIMARY KEY (id)
);

-- Table: status
CREATE TABLE status (
    id int NOT NULL DEFAULT 0,
    status varchar(20) NULL DEFAULT Черновик,
    CONSTRAINT status_pk PRIMARY KEY (id)
) COMMENT ''
COMMENT 'У статьи статус : черновик, опубликована, удалена';

-- foreign keys
-- Reference: Article_status (table: Article)
ALTER TABLE Article ADD CONSTRAINT Article_status FOREIGN KEY Article_status (id_status)
    REFERENCES status (id);

-- Reference: Comments_Article (table: Comments)
ALTER TABLE Comments ADD CONSTRAINT Comments_Article FOREIGN KEY Comments_Article (id_article)
    REFERENCES Article (id);

-- Reference: Comments_Person (table: Comments)
ALTER TABLE Comments ADD CONSTRAINT Comments_Person FOREIGN KEY Comments_Person (id_person)
    REFERENCES Person (id);

-- Reference: Paragraph_Article (table: Paragraph)
ALTER TABLE Paragraph ADD CONSTRAINT Paragraph_Article FOREIGN KEY Paragraph_Article (id_article)
    REFERENCES Article (id);

-- Reference: Selected_article_Article (table: Selected_article)
ALTER TABLE Selected_article ADD CONSTRAINT Selected_article_Article FOREIGN KEY Selected_article_Article (id_article)
    REFERENCES Article (id);

-- Reference: Selected_article_Person (table: Selected_article)
ALTER TABLE Selected_article ADD CONSTRAINT Selected_article_Person FOREIGN KEY Selected_article_Person (id_person)
    REFERENCES Person (id);

-- Reference: Selected_author_Person (table: Selected_author)
ALTER TABLE Selected_author ADD CONSTRAINT Selected_author_Person FOREIGN KEY Selected_author_Person (id_author)
    REFERENCES Person (id);

-- Reference: Selected_author_Person1 (table: Selected_author)
ALTER TABLE Selected_author ADD CONSTRAINT Selected_author_Person1 FOREIGN KEY Selected_author_Person1 (id_person)
    REFERENCES Person (id);

-- Reference: Selected_paragraph_Article (table: Selected_paragraph)
ALTER TABLE Selected_paragraph ADD CONSTRAINT Selected_paragraph_Article FOREIGN KEY Selected_paragraph_Article (id_article)
    REFERENCES Article (id);

-- Reference: Selected_paragraph_Person (table: Selected_paragraph)
ALTER TABLE Selected_paragraph ADD CONSTRAINT Selected_paragraph_Person FOREIGN KEY Selected_paragraph_Person (id_person)
    REFERENCES Person (id);

-- End of file.

