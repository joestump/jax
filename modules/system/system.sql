create table groups ( 
  groupID TINYINT(2) DEFAULT '0' NOT NULL,
  name CHAR(50) NOT NULL,
  sticky TINYINT(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (groupID,name)
);

create table groups_users ( 
  groupID TINYINT(2) DEFAULT '0' NOT NULL,
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  PRIMARY KEY (groupID,userID)
);

create table modules ( 
  moduleID mediumint(3) DEFAULT '0' NOT NULL,
  name CHAR(45) NOT NULL,
  title CHAR(255) NOT NULL,
  description text NOT NULL,
  image CHAR(45) NOT NULL,
  posted INTEGER(11) DEFAULT '0' NOT NULL,
  available TINYINT(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (moduleID),
  KEY(name)
);

create table modules_groups ( 
  moduleID mediumint(3) DEFAULT '0' NOT NULL,
  groupID TINYINT(2) DEFAULT '0' NOT NULL,
  permissions mediumint(3) DEFAULT '644' NOT NULL,
  PRIMARY KEY (moduleID,groupID)
);

create table modules_config ( 
  module CHAR(15) NOT NULL,
  var CHAR(25) NOT NULL,
  value CHAR(75) NOT NULL,
  PRIMARY KEY (module,var)
);

create table preferences ( 
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  module CHAR(15) NOT NULL,
  var CHAR(25) NOT NULL,
  value CHAR(75) NOT NULL,
  PRIMARY KEY (userID,module,var)
);

create table users ( 
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  password CHAR(15) NOT NULL,
  email CHAR(45) NOT NULL,
  fname CHAR(35) NOT NULL,
  lname CHAR(35) NOT NULL,
  posted INTEGER(11) DEFAULT '0' NOT NULL,
  admin TINYINT(1) DEFAULT '0' NOT NULL,
  available TINYINT(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (userID),
  KEY(email),
  KEY(posted),
  KEY(available),
  UNIQUE (email)
);

create table users_sessions ( 
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  sessionID CHAR(32) NOT NULL,
  posted INTEGER(11) DEFAULT '0' NOT NULL,
  track TINYINT(1) DEFAULT '0' NOT NULL,
  KEY(userID),
  KEY(sessionID),
  KEY(posted),
  KEY(track)
);

create table plugins ( 
  name CHAR(50) NOT NULL,
  module CHAR(45) NOT NULL,
  title CHAR(255) NOT NULL,
  available TINYINT(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (name),
  KEY(available),
  KEY(module)
);

