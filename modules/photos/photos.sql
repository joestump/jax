create table photos_albums ( 
  albumID INTEGER(2) DEFAULT '0' NOT NULL,
  title CHAR(255) NOT NULL,
  description text,
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  posted INTEGER(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (albumID),
  KEY(posted),
  KEY(userID)
);

create table photos_albums_images ( 
  imageID INTEGER(2) DEFAULT '0' NOT NULL,
  albumID INTEGER(2) DEFAULT '0' NOT NULL,
  PRIMARY KEY (imageID,albumID)
);

create table photos_images ( 
  imageID INTEGER(2) DEFAULT '0' NOT NULL,
  userID INTEGER(9) DEFAULT '0' NOT NULL,
  caption CHAR(255) NOT NULL,
  type CHAR(5) NOT NULL,
  posted INTEGER(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (imageID),
  KEY(posted),
  KEY(userID)
);

