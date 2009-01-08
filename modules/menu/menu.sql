create table menu_categories ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  name CHAR(100) NOT NULL,
  url CHAR(255) NOT NULL,
  hits INTEGER(9) DEFAULT '0' NOT NULL,
  sort TINYINT(2) DEFAULT '0' NOT NULL,
  PRIMARY KEY (contentID),
  KEY(sort)
);

create table menu_links ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  categoryID INTEGER(9) DEFAULT '0' NOT NULL,
  name CHAR(100) NOT NULL,
  url CHAR(255) NOT NULL,
  hits INTEGER(9) DEFAULT '0' NOT NULL,
  sort TINYINT(2) DEFAULT '0' NOT NULL,
  PRIMARY KEY (contentID),
  KEY(sort)
);

