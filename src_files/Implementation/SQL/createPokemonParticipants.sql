CREATE TABLE pokemon_participants (
    PRIMARY KEY (pokemon_id,challenge_id),
    pokemon_id      INT  NOT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemon(pokemon_id) ON DELETE RESTRICT,
    challenge_id      INT NOT NULL,
    FOREIGN KEY (challenge_id) REFERENCES challenges(challenge_id) ON DELETE RESTRICT
    
);