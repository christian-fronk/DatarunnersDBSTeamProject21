CREATE TABLE challenges (
    PRIMARY KEY (challenge_id),
    challenge_id      INT  NOT NULL AUTO_INCREMENT,
    challenge_date    DATE  NOT NULL,
    challenge_progress_made   INT NOT NULL CHECK (challenge_progress_made >=0 AND challenge_progress_made <=5),
    trainer_id       INT NOT NULL,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id)
);