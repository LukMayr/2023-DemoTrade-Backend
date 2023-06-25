CREATE TABLE DT_USER(
                        U_ID INT NOT NULL AUTO_INCREMENT,
                        U_USERNAME VARCHAR(16) NOT NULL UNIQUE,
                        U_EMAIL VARCHAR(64) NOT NULL UNIQUE,
                        U_PASSWORD VARCHAR(128) NOT NULL,
                        U_CREATED TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        CONSTRAINT PK_U_ID PRIMARY KEY ( U_ID )
);

CREATE TABLE DT_CURRENCY(
                            C_ID INT NOT NULL AUTO_INCREMENT,
                            C_NAME VARCHAR(3) NOT NULL UNIQUE,
                            CONSTRAINT PK_C_ID PRIMARY KEY ( C_ID )
);

CREATE TABLE DT_PORTFOLIO(
                             P_ID INT NOT NULL AUTO_INCREMENT,
                             P_U_ID INT NOT NULL,
                             CONSTRAINT PK_P_ID PRIMARY KEY ( P_ID ),
                             CONSTRAINT FK_P_U_ID FOREIGN KEY ( P_U_ID )
                                 REFERENCES DT_USER ( U_ID )
);

CREATE TABLE DT_STOCK(
                         S_ID INT NOT NULL AUTO_INCREMENT,
                         S_P_ID INT NOT NULL,
                         S_QUANTITY decimal(32,8),
                         S_PRICE decimal(16,4),
                         S_C_ID INT NOT NULL,
                         CONSTRAINT PK_S_ID PRIMARY KEY ( S_ID ),
                         CONSTRAINT FK_S_P_ID FOREIGN KEY ( S_P_ID )
                             REFERENCES DT_PORTFOLIO ( P_ID ),
                         CONSTRAINT FK_S_C_ID FOREIGN KEY ( S_C_ID )
                             REFERENCES DT_CURRENCY ( C_ID )
);