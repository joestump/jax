create table content ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  posted INTEGER(11) DEFAULT '0' NOT NULL,
  lastUpdate INTEGER(11) DEFAULT '0' NOT NULL,
  available TINYINT(1) DEFAULT '0' NOT NULL,
  mime CHAR(25) NOT NULL,
  title CHAR(255) NOT NULL,
  search text NOT NULL,
  module CHAR(25) NOT NULL,
  PRIMARY KEY (contentID),
  KEY(userID),
  KEY(posted),
  KEY(mime),
  KEY(title),
  KEY(module)
);

create table content_groups ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  groupID TINYINT(2) DEFAULT '0' NOT NULL,
  permissions mediumint(3) DEFAULT '644' NOT NULL,
  PRIMARY KEY (contentID,groupID)
);

create table html ( 
  contentID INTEGER(9) DEFAULT '0' NOT NULL,
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  title VARCHAR(255) NOT NULL,
  name VARCHAR(64) NOT NULL,
  html text NOT NULL,
  lastUpdate INTEGER(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (contentID),
  KEY(userID),
  KEY(title),
  KEY(lastUpdate),
  KEY(name),
  UNIQUE (name)
);

