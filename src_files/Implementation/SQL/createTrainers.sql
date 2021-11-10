CREATE TABLE trainers (
    PRIMARY KEY (trainer_id),
    trainer_id      INT  NOT NULL AUTO_INCREMENT,
    trainer_name    VARCHAR(32)     NOT NULL,
    trainer_hometown        VARCHAR(32)     NOT NULL,
    trainer_dob        DATE NOT NULL,
    isActive            BOOLEAN
);
