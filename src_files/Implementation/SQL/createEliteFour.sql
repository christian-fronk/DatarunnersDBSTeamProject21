CREATE TABLE elite_four (
    PRIMARY KEY (trainer_id),
    trainer_id      INT  NOT NULL AUTO_INCREMENT,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id),
    elite_four_position    INT NOT NULL,
    type_specialty         VARCHAR(32) NOT NULL
    
);