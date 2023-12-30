-- wedding gallery Table
CREATE TABLE gallery(
    imageID VARCHAR(255) PRIMARY KEY NOT NULL,
    imageName VARCHAR(255),
    weddingID VARCHAR(255),
    imageURL VARCHAR(2048),
    uploadedAt DATETIME,
    type ENUM('template', 'gallery'),
    FOREIGN KEY (weddingID) REFERENCES weddings(weddingID)
);