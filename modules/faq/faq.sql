create table faq ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  categoryID INTEGER(9) DEFAULT '0' NOT NULL,
  question VARCHAR(255) NOT NULL,
  answer text NOT NULL,
  hits INTEGER(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (contentID),
  KEY(hits)
);

create table faq_categories ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  name CHAR(150) NOT NULL,
  PRIMARY KEY (contentID)
);

