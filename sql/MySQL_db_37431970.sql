USE `db_37431970`;

DROP TABLE IF EXISTS hasliked;
DROP TABLE IF EXISTS inforum;
DROP TABLE IF EXISTS postmessages;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS forums;
DROP TABLE IF EXISTS users;


CREATE TABLE users (
    username        VARCHAR(256),
    pass            VARCHAR(256),
    siteadmin       BOOLEAN,
    startdate       DATE,
    email           VARCHAR(256),
    phone           VARCHAR(10),
    firstname       VARCHAR(256),
    lastname        VARCHAR(256),
    profileimage    MEDIUMBLOB,
    PRIMARY KEY (username)
);

CREATE TABLE forums (
    forumname      VARCHAR(256),
    ownername      VARCHAR(256),
    creationdate    DATETIME,
    PRIMARY KEY (forumname),
    FOREIGN KEY (ownername) REFERENCES users(username)
        ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE posts (
    forumname      VARCHAR(256),
    username        VARCHAR(256),
    postid          INT UNIQUE AUTO_INCREMENT,
    posttitle       VARCHAR(512),
    posttext        VARCHAR(1024),
    postdate        DATETIME,
    PRIMARY KEY (forumname, username, postid),
    FOREIGN KEY (username) REFERENCES users (username)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (forumname) REFERENCES forums (forumname)
        ON UPDATE CASCADE ON DELETE CASCADE
);
-- CREATE INDEX idx_postid ON posts (postid);

CREATE TABLE postmessages (
    forumname      VARCHAR(256),
    postid          INT,
    username        VARCHAR(256),
    messageid       INT UNIQUE AUTO_INCREMENT,
    messagetext     VARCHAR(512),
    postdate        DATETIME,
    PRIMARY KEY (forumname, postid, username, messageid),
    FOREIGN KEY (username) REFERENCES users (username)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (forumname) REFERENCES forums (forumname)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (postid) REFERENCES posts (postid)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE inforum (
    username        VARCHAR(256),
    forumname      VARCHAR(256),
    isadmin         BOOLEAN,
    joindate        DATETIME,
    PRIMARY KEY (forumname, username),
    FOREIGN KEY (username) REFERENCES users (username)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (forumname) REFERENCES forums (forumname)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE hasliked (
    username        VARCHAR(256),
    postid        INT,
    PRIMARY KEY (username, postid),
    FOREIGN KEY (username) REFERENCES users (username)
        ON UPDATE CASCADE ON DELETE CASCADE,    
    FOREIGN KEY (postid) REFERENCES posts (postid)
        ON UPDATE CASCADE ON DELETE CASCADE
);
