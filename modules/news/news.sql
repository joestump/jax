create table news ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  categoryID INTEGER(9) DEFAULT '0' NOT NULL,
  title VARCHAR(255) NOT NULL,
  teaser text NOT NULL,
  story text NOT NULL,
  PRIMARY KEY (contentID),
  KEY(title)
);

create table news_categories ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  name CHAR(150),
  PRIMARY KEY (contentID)
);

